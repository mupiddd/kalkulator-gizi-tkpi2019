<?php

namespace Database\Seeders;

use App\Models\FoodIngredient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FoodIngredientSeeder extends Seeder
{
    public function run(): void
    {
        $datasets = [
            '2019' => database_path('data/tkpi_2019.csv'),
            '2020' => database_path('data/tkpi_2020.csv'),
        ];

        // Kosongkan tabel sebelum import ulang
        FoodIngredient::truncate();

        $now = now();
        $cleanNum = fn($val) => is_numeric(str_replace(',', '.', $val)) ? (float) str_replace(',', '.', $val) : 0.0;

        foreach ($datasets as $tahun => $csvFile) {
            if (! file_exists($csvFile)) {
                $this->command->warn("File CSV untuk TKPI {$tahun} tidak ditemukan di: " . $csvFile);
                continue;
            }

            $file = fopen($csvFile, 'r');
            $header = fgetcsv($file); // Lewati baris pertama (judul kolom)
            $hasNatriumCol = is_array($header) && count($header) >= 15;

            $batchData = [];
            $count = 0;

            while (($row = fgetcsv($file)) !== false) {
                if (count($row) < 14) {
                    continue;
                }

                $kode = trim($row[0]);
                $hurufDepan = strtoupper(substr($kode, 0, 1));

                // Deteksi otomatis Hewani / Nabati dari Kode Kelompok TKPI
                $kategoriProtein = in_array($hurufDepan, ['F', 'G', 'H', 'J'], true) ? 'hewani' : 'nabati';

                $bdd = $cleanNum($row[2]);
                if ($bdd <= 0) {
                    $bdd = 100.0;
                }

                if ($hasNatriumCol) {
                    // Format 15 kolom: kode_tkpi,nama_bahan,bdd,air,kalori,protein,lemak,kh,ca_mg,p_mg,fe_mg,natrium_mg,vit_a,vit_b1,vit_c
                    $natrium = $cleanNum($row[11]);
                    $vitA    = $cleanNum($row[12]);
                    $vitB1   = $cleanNum($row[13]);
                    $vitC    = $cleanNum($row[14]);
                } else {
                    // Fallback format lama 14 kolom
                    $natrium = 0.0;
                    $vitA    = $cleanNum($row[11]);
                    $vitB1   = $cleanNum($row[12]);
                    $vitC    = $cleanNum($row[13]);
                }

                $batchData[] = [
                    'tahun'            => (string) $tahun,
                    'kode_tkpi'        => $kode,
                    'nama_bahan'       => trim($row[1]),
                    'kategori_protein' => $kategoriProtein,
                    'bdd'              => $bdd,
                    'air'              => $cleanNum($row[3]),
                    'kalori'           => $cleanNum($row[4]),
                    'protein'          => $cleanNum($row[5]),
                    'lemak'            => $cleanNum($row[6]),
                    'kh'               => $cleanNum($row[7]),
                    // Konversi mg (buku TKPI) ke gram untuk Ca, P, Fe
                    'ca'               => $cleanNum($row[8]) / 1000,
                    'p'                => $cleanNum($row[9]) / 1000,
                    'fe'               => $cleanNum($row[10]) / 1000,
                    // Natrium dalam miligram (mg) sesuai buku TKPI
                    'natrium'          => $natrium,
                    'vit_a'            => $vitA,
                    'vit_b1'           => $vitB1,
                    'vit_c'            => $vitC,
                    'created_at'       => $now,
                    'updated_at'       => $now,
                ];
                $count++;

                if (count($batchData) >= 250) {
                    DB::table('food_ingredients')->insert($batchData);
                    $batchData = [];
                }
            }

            if (! empty($batchData)) {
                DB::table('food_ingredients')->insert($batchData);
            }

            fclose($file);
            $this->command->info("Berhasil mengimpor {$count} data TKPI {$tahun} ke database!");
        }
    }
}
