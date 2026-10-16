<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('kode_tkpi')->nullable(); // Contoh: AP001
            $table->string('nama_bahan');
            $table->enum('kategori_protein', ['hewani', 'nabati']); // Penentu Protein H atau N
            
            // Nilai per 100 gram BDD sesuai parameter yang kamu minta
            $table->float('bdd');        // % (Berat Dapat Dimakan)
            $table->float('air');        // gram
            $table->float('kalori');     // kkal
            $table->float('protein');    // gram (nanti masuk ke H atau N sesuai kategori)
            $table->float('lemak');      // gram
            $table->float('kh');         // gram (Karbohidrat)
            $table->float('ca');         // gram (Kalsium - di TKPI mg, dibagi 1000)
            $table->float('p');          // gram (Fosfor - di TKPI mg, dibagi 1000)
            $table->float('fe');         // gram (Besi - di TKPI mg, dibagi 1000)
            $table->float('vit_a');      // UI / SI
            $table->float('vit_b1');     // miligram
            $table->float('vit_c');      // miligram
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_ingredients');
    }
};