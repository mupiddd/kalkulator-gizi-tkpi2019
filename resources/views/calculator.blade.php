<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulator Gizi TKPI 2019</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 1. Tambahkan CSS & JS TomSelect untuk fitur Searchable Dropdown -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

    <!-- Custom CSS agar tampilan TomSelect serasi dengan Tailwind -->
    <style>
        .ts-control {
            border-radius: 0.5rem !important;
            padding: 0.625rem 0.75rem !important;
            border-color: #cbd5e1 !important;
            font-size: 0.875rem !important;
            box-shadow: none !important;
        }
        .ts-wrapper.focus .ts-control {
            border-color: #10b981 !important;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3) !important;
        }
        .ts-dropdown {
            border-radius: 0.5rem !important;
            margin-top: 4px !important;
            font-size: 0.875rem !important;
        }
        .ts-dropdown .active {
            background-color: #ecfdf5 !important;
            color: #065f46 !important;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-10 px-4">

    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-slate-200">
            <h1 class="text-2xl font-bold text-slate-800">Kalkulator Gizi Bahan Makanan</h1>
            <p class="text-sm text-slate-500 mt-1">Acuan Perhitungan: Tabel Komposisi Pangan Indonesia (TKPI) 2019</p>
        </div>

        <!-- Form Input -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-slate-200">
            <form action="{{ route('calculator.calculate') }}" method="POST" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Cari & Pilih Bahan Makanan</label>
                    <!-- 2. Tambahkan id="select-bahan" pada elemen select -->
                    <select id="select-bahan" name="ingredient_id" required placeholder="Ketik nama bahan atau kode TKPI...">
                        <option value="">-- Ketik untuk mencari bahan --</option>
                        @foreach($ingredients as $item)
                            <option value="{{ $item->id }}" {{ (isset($selected) && $selected->id == $item->id) ? 'selected' : '' }}>
                                [{{ $item->kode_tkpi }}] {{ $item->nama_bahan }} (BDD: {{ $item->bdd }}%)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Berat Bahan (gram)</label>
                    <input type="number" step="0.1" min="0.1" name="berat" value="{{ $beratInput ?? '' }}" placeholder="Contoh: 150" required
                        class="w-full rounded-lg border-slate-300 border p-2.5 text-sm text-slate-700 focus:ring-2 focus:ring-emerald-500 focus:outline-none">
                </div>

                <div>
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 px-4 rounded-lg transition text-sm">
                        Hitung Zat Gizi
                    </button>
                </div>
            </form>
        </div>

        <!-- Hasil Perhitungan -->
        @if(isset($hasil))
        <div class="bg-white rounded-xl shadow-sm p-6 border border-slate-200">
            <div class="flex flex-col md:flex-row md:items-center justify-between pb-4 mb-4 border-b border-slate-200">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider bg-emerald-100 text-emerald-800 px-2.5 py-1 rounded">Kode TKPI: {{ $hasil['kode_tkpi'] }}</span>
                    <h2 class="text-xl font-bold text-slate-800 mt-2">{{ $hasil['nama_bahan'] }}</h2>
                </div>
                <div class="mt-3 md:mt-0 text-sm text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-200">
                    <div>Berat Kotor: <strong>{{ $hasil['berat_awal'] }} g</strong></div>
                    <div>BDD: <strong>{{ $hasil['bdd_persen'] }}%</strong> (Berat Bersih: <strong>{{ $hasil['berat_bdd'] }} g</strong>)</div>
                </div>
            </div>

            <!-- Grid Zat Gizi -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-sm">
                            <th class="py-3 px-4">Zat Gizi</th>
                            <th class="py-3 px-4">Hasil Perhitungan</th>
                            <th class="py-3 px-4">Satuan</th>
                            <th class="py-3 px-4 text-slate-400 font-normal">Nilai Asli / 100g BDD</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 text-slate-700 text-sm">
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Berat Bahan</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['berat_awal'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">100 g</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">BDD (Berat Dapat Dimakan)</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['bdd_persen'] }}</td>
                            <td class="py-2.5 px-4">%</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->bdd }} %</td>
                        </tr>
                        <tr class="bg-emerald-50/40">
                            <td class="py-2.5 px-4 font-medium">Kalori (Energi)</td>
                            <td class="py-2.5 px-4 font-bold text-emerald-700">{{ $hasil['kalori'] }}</td>
                            <td class="py-2.5 px-4">kkal</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->kalori }} kkal</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Protein Hewani (h)</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['protein_h'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->kategori_protein == 'hewani' ? $selected->protein : 0 }} g</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Protein Nabati (n)</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['protein_n'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->kategori_protein == 'nabati' ? $selected->protein : 0 }} g</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Lemak</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['lemak'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->lemak }} g</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Karbohidrat (KH)</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['kh'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->kh }} g</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Kalsium (Ca)</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['ca'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->ca }} g</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Fosfor (P)</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['p'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->p }} g</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Besi (Fe)</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['fe'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->fe }} g</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Vitamin A</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['vit_a'] }}</td>
                            <td class="py-2.5 px-4">UI</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->vit_a }} UI</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Vitamin B1</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['vit_b1'] }}</td>
                            <td class="py-2.5 px-4">miligram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->vit_b1 }} mg</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Vitamin C</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['vit_c'] }}</td>
                            <td class="py-2.5 px-4">miligram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->vit_c }} mg</td>
                        </tr>
                        <tr>
                            <td class="py-2.5 px-4 font-medium">Air</td>
                            <td class="py-2.5 px-4 font-bold">{{ $hasil['air'] }}</td>
                            <td class="py-2.5 px-4">gram</td>
                            <td class="py-2.5 px-4 text-slate-400">{{ $selected->air }} g</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- 3. Inisialisasi TomSelect -->
    <script>
        new TomSelect("#select-bahan", {
            create: false,
            maxOptions: 100, // Membatasi render sekaligus agar tetap ringan & ngebut
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Ketik nama bahan atau kode TKPI..."
        });
    </script>

</body>
</html>