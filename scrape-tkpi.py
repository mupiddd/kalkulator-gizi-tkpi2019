import csv
import re
import requests
import urllib3
from bs4 import BeautifulSoup
from concurrent.futures import ThreadPoolExecutor, as_completed

# Nonaktifkan peringatan SSL karena sertifikat server panganku kadang expired
urllib3.disable_warnings(urllib3.exceptions.InsecureRequestWarning)

BASE_URL = "https://www.panganku.org/id-ID/semua_nutrisi"
DETAIL_URL = "https://www.panganku.org/id-ID/view"
OUTPUT_CSV = "database/data/tkpi_2019.csv"

HEADERS = {
    "User-Agent": "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36"
}

def clean_number(text):
    """Mengubah teks nutrisi seperti '180,5 kkal' atau '-' menjadi angka float murni"""
    if not text:
        return 0.0
    text = text.replace(",", ".")
    match = re.search(r"[-+]?\d*\.\d+|\d+", text)
    return float(match.group(0)) if match else 0.0

def get_all_food_codes():
    """Mengambil daftar seluruh kode dan nama bahan dari halaman tabel utama"""
    print("1. Mengambil daftar bahan makanan dari panganku.org...")
    session = requests.Session()
    resp = session.get(BASE_URL, headers=HEADERS, verify=False, timeout=30)
    soup = BeautifulSoup(resp.text, "lxml")

    foods = []
    # Cari semua baris di dalam tabel nutrisi
    for tr in soup.select("table tbody tr"):
        cols = [td.get_text(strip=True) for td in tr.find_all("td")]
        if len(cols) >= 2:
            # Biasanya kolom 0 = No/Kode, sesuaikan deteksi kode TKPI (misal AR001, FP001)
            kode = cols[0] if re.match(r"^[A-Z]{1,2}\d+", cols[0]) else cols[1]
            nama = cols[1] if kode == cols[0] else cols[2]
            
            # Cari link detail atau form ID jika ada
            link = tr.find("a", href=True)
            food_id = link["href"].split("/")[-1] if link else kode
            foods.append((kode, nama, food_id))

    print(f"   Ditemukan {len(foods)} bahan makanan di halaman utama.")
    return foods

def fetch_food_detail(item):
    """Mengambil rincian nutrisi lengkap per bahan makanan"""
    kode, nama_awal, food_id = item
    data = {
        "kode_tkpi": kode,
        "nama_bahan": nama_awal,
        "bdd": 100.0,
        "air": 0.0,
        "kalori": 0.0,
        "protein": 0.0,
        "lemak": 0.0,
        "kh": 0.0,
        "ca_mg": 0.0,
        "p_mg": 0.0,
        "fe_mg": 0.0,
        "vit_a": 0.0,
        "vit_b1": 0.0,
        "vit_c": 0.0,
    }

    try:
        # Request ke halaman detail bahan pangan
        resp = requests.post(
            DETAIL_URL,
            data={"id": food_id, "kode": kode},
            headers=HEADERS,
            verify=False,
            timeout=15
        )
        soup = BeautifulSoup(resp.text, "lxml")
        text_all = soup.get_text(" ", strip=True)

        # Cari BDD (%) jika tertulis di halaman
        bdd_match = re.search(r"(?:BDD|Berat Dapat Dimakan)[^0-9]*(\d+(?:[\.,]\d+)?)", text_all, re.I)
        if bdd_match:
            data["bdd"] = clean_number(bdd_match.group(1))

        # Ekstrak pasangan label nutrisi dan nilainya dari baris tabel detail
        for tr in soup.find_all("tr"):
            row_text = " ".join([td.get_text(strip=True) for td in tr.find_all(["td", "th"])])
            low = row_text.lower()

            if "air" in low and "udara" not in low:
                data["air"] = clean_number(row_text)
            elif "energi" in low or "kalori" in low:
                data["kalori"] = clean_number(row_text)
            elif "protein" in low:
                data["protein"] = clean_number(row_text)
            elif "lemak" in low:
                data["lemak"] = clean_number(row_text)
            elif "karbohidrat" in low or "(kh)" in low:
                data["kh"] = clean_number(row_text)
            elif "kalsium" in low or "(ca)" in low:
                data["ca_mg"] = clean_number(row_text)
            elif "fosfor" in low or "(p)" in low:
                data["p_mg"] = clean_number(row_text)
            elif "besi" in low or "(fe)" in low:
                data["fe_mg"] = clean_number(row_text)
            elif "retinol" in low or "vit a" in low or "vitamin a" in low or "karoten" in low:
                if data["vit_a"] == 0:
                    data["vit_a"] = clean_number(row_text)
            elif "thiamin" in low or "vit b1" in low or "vitamin b1" in low:
                data["vit_b1"] = clean_number(row_text)
            elif "vit c" in low or "vitamin c" in low or "askorbat" in low:
                data["vit_c"] = clean_number(row_text)

    except Exception as e:
        print(f"   [!] Gagal mengambil detail {kode}: {e}")

    return data

def main():
    foods = get_all_food_codes()
    if not foods:
        print("Tidak ada data ditemukan. Pastikan koneksi internet aktif atau cek struktur HTML panganku.org.")
        return

    results = []
    print("2. Mengambil detail zat gizi (BDD, Makro, Mineral, Vitamin) secara paralel...")
    
    with ThreadPoolExecutor(max_workers=10) as executor:
        futures = {executor.submit(fetch_food_detail, item): item for item in foods}
        for idx, future in enumerate(as_completed(futures), 1):
            res = future.result()
            results.append(res)
            if idx % 50 == 0 or idx == len(foods):
                print(f"   Progress: {idx}/{len(foods)} bahan selesai...")

    # Urutkan kembali berdasarkan kode_tkpi
    results.sort(key=lambda x: x["kode_tkpi"])

    # Simpan ke CSV sesuai format Seeder Laravel
    fieldnames = [
        "kode_tkpi", "nama_bahan", "bdd", "air", "kalori",
        "protein", "lemak", "kh", "ca_mg", "p_mg", "fe_mg",
        "vit_a", "vit_b1", "vit_c"
    ]

    with open(OUTPUT_CSV, mode="w", newline="", encoding="utf-8") as f:
        writer = csv.DictWriter(f, fieldnames=fieldnames)
        writer.writeheader()
        writer.writerows(results)

    print(f"\nSelesai! File CSV berhasil disimpan di: {OUTPUT_CSV}")

if __name__ == "__main__":
    main()