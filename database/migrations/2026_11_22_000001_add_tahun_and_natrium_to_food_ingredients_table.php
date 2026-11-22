<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('food_ingredients', function (Blueprint $table) {
            if (! Schema::hasColumn('food_ingredients', 'tahun')) {
                $table->string('tahun', 10)->default('2019')->after('id')->index();
            }
            if (! Schema::hasColumn('food_ingredients', 'natrium')) {
                $table->float('natrium')->default(0)->after('fe'); // miligram (mg) per 100g BDD
            }
        });
    }

    public function down(): void
    {
        Schema::table('food_ingredients', function (Blueprint $table) {
            if (Schema::hasColumn('food_ingredients', 'natrium')) {
                $table->dropColumn('natrium');
            }
            if (Schema::hasColumn('food_ingredients', 'tahun')) {
                $table->dropColumn('tahun');
            }
        });
    }
};
