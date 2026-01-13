<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - supprimer les tables de formations
     */
    public function up(): void
    {
        // Supprimer les tables dans l'ordre inverse des dépendances
        Schema::dropIfExists('formation_inscriptions');
        Schema::dropIfExists('formations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Non implémenté - cette migration est de nettoyage
    }
};
