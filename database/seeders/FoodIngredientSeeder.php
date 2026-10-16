<?php

namespace Database\Seeders;

use App\Models\FoodIngredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodIngredientSeeder extends Seeder
{
    public function run(): void
    {
        $csvFile = database_path('data/tkpi_2019.csv');

        if (!file_exists($csvFile)) {
            $this->command->error("File CSV tidak ditemukan di: " . $csvFile);
            return;
        }

        // Kosongkan tabel sebelum import ulang
        FoodIngredient::truncate();

        $file = fopen($csvFile, 'r');
        $header = fgetcsv($file); // Lewati baris pertama (judul kolom)

        $batchData = [];
        $now = now();

        while (($row = fgetcsv($file)) !== false) {
            if (count($row) < 14) continue; // Lewati baris jika data tidak lengkap

            $kode = trim($row[0]);
            $hurufDepan = strtoupper(substr($kode, 0, 1));

            // Deteksi otomatis Hewani / Nabati dari Kode Kelompok TKPI
            $kategoriProtein = in_array($hurufDepan, ['F', 'G', 'H', 'J']) ? 'hewani' : 'nabati';

            $cleanNum = fn($val) => is_numeric(str_replace(',', '.', $val)) ? (float) str_replace(',', '.', $val) : 0;

            $batchData[] = [
                'kode_tkpi'        => $kode,
                'nama_bahan'       => trim($row[1]),
                'kategori_protein' => $kategoriProtein,
                'bdd'              => $cleanNum($row[2]),
                'air'              => $cleanNum($row[3]),
                'kalori'           => $cleanNum($row[4]),
                'protein'          => $cleanNum($row[5]),
                'lemak'            => $cleanNum($row[6]),
                'kh'               => $cleanNum($row[7]),
                // Konversi mg (buku TKPI) ke gram
                'ca'               => $cleanNum($row[8]) / 1000,
                'p'                => $cleanNum($row[9]) / 1000,
                'fe'               => $cleanNum($row[10]) / 1000,
                'vit_a'            => $cleanNum($row[11]),
                'vit_b1'           => $cleanNum($row[12]),
                'vit_c'            => $cleanNum($row[13]),
                'created_at'       => $now,
                'updated_at'       => $now,
            ];

            // Insert per 250 baris agar cepat
            if (count($batchData) >= 250) {
                DB::table('food_ingredients')->insert($batchData);
                $batchData = [];
            }
        }

        // Insert sisa baris terakhir
        if (!empty($batchData)) {
            DB::table('food_ingredients')->insert($batchData);
        }

        fclose($file);
        $this->command->info("Berhasil mengimpor seluruh data TKPI 2019 ke database!");
    }
}