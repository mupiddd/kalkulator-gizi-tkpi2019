<?php

namespace App\Http\Controllers;

use App\Models\FoodIngredient;
use Illuminate\Http\Request;

class FoodIngredientController extends Controller
{
    public function index()
    {
        $ingredients = FoodIngredient::orderBy('nama_bahan', 'asc')->get();
        return view('calculator', compact('ingredients'));
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'ingredient_id' => 'required|exists:food_ingredients,id',
            'berat' => 'required|numeric|min:0.1',
        ]);

        $ingredients = FoodIngredient::orderBy('nama_bahan', 'asc')->get();
        $selected = FoodIngredient::findOrFail($request->ingredient_id);
        $beratInput = (float) $request->berat;

        // Faktor pengali TKPI: (Berat (g) / 100) * (BDD (%) / 100)
        $faktor = ($beratInput / 100) * ($selected->bdd / 100);
        $beratDapatDimakan = $beratInput * ($selected->bdd / 100);

        // Hasil perhitungan setiap zat gizi
        $hasil = [
            'nama_bahan' => $selected->nama_bahan,
            'kode_tkpi'  => $selected->kode_tkpi,
            'berat_awal' => $beratInput,
            'bdd_persen' => $selected->bdd,
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

        return view('calculator', compact('ingredients', 'hasil', 'selected', 'beratInput'));
    }
}