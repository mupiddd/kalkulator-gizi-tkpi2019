<?php

namespace App\Http\Controllers;

use App\Models\FoodIngredient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class FoodIngredientController extends Controller
{
    /**
     * Daftar kata-kata romantis khusus untuk Nola yang diacak setiap refresh.
     */
    private function getRomanticQuotes(): array
    {
        return [
            "Dari 1.147 bahan makanan di tabel TKPI ini, cuma Nola satu-satunya yang bisa bikin hati Mufid kenyang bahagia setiap hari. ♥",
            "Kalori mungkin yang memberi energi buat tubuh, tapi senyumnya Nola yang selalu jadi sumber energi terbesar buat hidup aku.",
            "Nola jangan lupa makan yang teratur dan bergizi yaa! Kesehatan kamu itu prioritas nomor satunya Mufid. ✨",
            "Kalau zat gizi dihitung pakai rumus BDD per 100 gram, rasa sayang aku ke Nola itu selalu 100% utuh tanpa ada yang terbuang sedikit pun.",
            "Vitamin A bagus buat mata, tapi melihat Nola tersenyum bahagia itu jauh lebih menyegarkan mata dan hatiku. ♥",
            "Website kecil bertema pixel pink ini aku buat khusus buat kamu, Nola. Semoga setiap kliknya bikin hari-hari kamu makin manis yaa!",
            "Zat besi (Fe) tugasnya mengikat oksigen di dalam darah, kalau tugas aku itu menjaga dan menyayangi Nola setiap waktu. 🌷",
            "Seberapa banyak pun angka nutrisi yang dihitung di kalkulator ini, nggak akan pernah bisa menandingi besarnya rasa syukurku punya Nola.",
            "Hari ini Nola sudah hebat banget! Jangan lupa istirahat yang cukup dan makan makanan favoritmu yaa, cantik. ♥",
            "Kata ahli gizi, tubuh butuh karbohidrat, protein, dan vitamin. Kata hatiku, aku cuma butuh Nola selalu sehat dan bahagia di sampingku.",
            "Kalsium bikin tulang kuat, tapi kehadiran Nola di hidup aku yang bikin aku selalu semangat menghadapi hari apa pun. ✨",
            "Setiap pixel warna pink di halaman ini mewakili doa dan rasa sayang Mufid yang nggak pernah habis buat Nola seorang.",
            "Kalau manisnya gula punya batas takaran harian, manisnya Nola di mata aku nggak pernah ada batasnya sama sekali! ♥",
            "Nola sayang, sesibuk apa pun kegiatanmu hari ini, janji yaa jangan sampai telat makan. Aku selalu sayang kamu!",
            "Di dunia yang penuh angka dan hitungan rumit ini, mencintai Nola adalah hal paling mudah dan paling membahagiakan buatku. 🌸",
            "Protein berfungsi memperbaiki sel-sel tubuh yang rusak, sedangkan suara dan tawa Nola selalu berhasil memperbaiki suasana hatiku.",
            "Semoga kalkulator gizi kecil ini bisa selalu nemenin dan mempermudah tugas-tugasnya Nola yaa. Semangat terus kesayanganku! ♥",
            "Bahkan kalau seluruh vitamin C di dunia dikumpulkan, masih kalah segarnya sama semangat yang Nola bawa ke dalam hidupku.",
            "Terima kasih sudah jadi perempuan paling manis, sabar, dan luar biasa. Mufid selalu bangga sama setiap langkahnya Nola! ✨",
            "Apa pun bahan makanan yang sedang Nola hitung hari ini, ingat selalu ada seseorang yang mendoakan kebahagiaanmu setiap detik. ♥",
        ];
    }

    private function getCurrentUser(Request $request): ?string
    {
        $user = session('tkpi_user') ?? $request->cookie('tkpi_user');
        if (in_array($user, ['Nola', 'Mufid'], true)) {
            return $user;
        }

        return null;
    }

    public function login(Request $request)
    {
        $request->validate([
            'nickname' => 'required|string|max:50',
        ]);

        $input = strtolower(trim($request->input('nickname')));

        if (! in_array($input, ['nola', 'mufid'], true)) {
            return back()
                ->withInput()
                ->withErrors([
                    'nickname' => 'Ups! Maaf yaa, nama panggilan tersebut tidak memiliki akses ke ruangan pixel spesial ini ♥',
                ]);
        }

        $displayName = ucfirst($input);
        session(['tkpi_user' => $displayName]);

        return redirect()
            ->route('calculator.index')
            ->withCookie(cookie('tkpi_user', $displayName, 60 * 24 * 30));
    }

    public function logout()
    {
        session()->forget('tkpi_user');

        return redirect()
            ->route('calculator.index')
            ->withCookie(Cookie::forget('tkpi_user'));
    }

    public function index(Request $request)
    {
        $currentUser = $this->getCurrentUser($request);
        $quotes = $this->getRomanticQuotes();
        $randomQuote = $quotes[array_rand($quotes)];

        if (! $currentUser) {
            return view('calculator', [
                'currentUser' => null,
                'ingredients' => collect(),
                'randomQuote' => '',
                'quotes' => [],
            ]);
        }

        $ingredients = FoodIngredient::orderBy('nama_bahan', 'asc')->get();

        return view('calculator', compact('ingredients', 'currentUser', 'randomQuote', 'quotes'));
    }

    public function calculate(Request $request)
    {
        $currentUser = $this->getCurrentUser($request);
        if (! $currentUser) {
            return redirect()->route('calculator.index');
        }

        if (! $request->filled('ingredient_id') || ! $request->filled('berat')) {
            return redirect()->route('calculator.index');
        }

        $request->validate([
            'ingredient_id' => 'required|exists:food_ingredients,id',
            'berat' => 'required|numeric|min:0.1',
        ]);

        $quotes = $this->getRomanticQuotes();
        $randomQuote = $quotes[array_rand($quotes)];

        $ingredients = FoodIngredient::orderBy('nama_bahan', 'asc')->get();
        $selected = FoodIngredient::findOrFail($request->ingredient_id);
        $beratInput = (float) $request->berat;
        $bdd = $selected->bdd > 0 ? (float) $selected->bdd : 100.0;

        // Faktor pengali TKPI: (Berat (g) / 100) * (BDD (%) / 100)
        $faktor = ($beratInput / 100) * ($bdd / 100);
        $beratDapatDimakan = $beratInput * ($bdd / 100);

        // Hasil perhitungan setiap zat gizi
        $hasil = [
            'nama_bahan' => $selected->nama_bahan,
            'kode_tkpi'  => $selected->kode_tkpi,
            'berat_awal' => $beratInput,
            'bdd_persen' => $bdd,
            'berat_bdd'  => round($beratDapatDimakan, 2),
            'kalori'     => round($selected->kalori * $faktor, 2),
            // Pisahkan protein Hewani (h) dan Nabati (n)
            'protein_h'  => $selected->kategori_protein === 'hewani' ? round($selected->protein * $faktor, 2) : 0,
            'protein_n'  => $selected->kategori_protein === 'nabati' ? round($selected->protein * $faktor, 2) : 0,
            'lemak'      => round($selected->lemak * $faktor, 2),
            'kh'         => round($selected->kh * $faktor, 2),
            'ca'         => round($selected->ca * $faktor, 4), // 4 desimal karena dalam gram
            'p'          => round($selected->p * $faktor, 4),
            'fe'         => round($selected->fe * $faktor, 5),
            'vit_a'      => round($selected->vit_a * $faktor, 2),
            'vit_b1'     => round($selected->vit_b1 * $faktor, 3),
            'vit_c'      => round($selected->vit_c * $faktor, 2),
            'air'        => round($selected->air * $faktor, 2),
        ];

        return view('calculator', compact('ingredients', 'hasil', 'selected', 'beratInput', 'currentUser', 'randomQuote', 'quotes'));
    }
}