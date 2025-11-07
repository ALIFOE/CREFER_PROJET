<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mettre à jour les chemins d'images de 'products/' vers 'images/products/'
        DB::table('products')
            ->whereNotNull('image')
            ->where('image', 'like', 'products/%')
            ->update([
                'image' => DB::raw("CONCAT('images/', image)")
            ]);

        // Mettre à jour les chemins d'images qui pointent directement vers 'images/'
        DB::table('products')
            ->whereNotNull('image')
            ->where('image', 'like', 'images/%')
            ->where('image', 'not like', 'images/products/%')
            ->update([
                'image' => DB::raw("REPLACE(image, 'images/', 'images/products/')")
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Restaurer les anciens chemins
        DB::table('products')
            ->whereNotNull('image')
            ->where('image', 'like', 'images/products/%')
            ->update([
                'image' => DB::raw("REPLACE(image, 'images/products/', 'products/')")
            ]);
    }
};
