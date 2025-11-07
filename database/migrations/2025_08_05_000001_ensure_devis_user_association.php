<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up(): void
    {
        // 1. D'abord, mettre à jour les devis existants
        $this->associateExistingUsers();
        $this->createUsersForOrphanDevis();

        // 2. Ensuite, mettre à jour la contrainte
        Schema::table('devis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    private function associateExistingUsers()
    {
        DB::statement('
            UPDATE devis d
            INNER JOIN users u ON d.email = u.email
            SET d.user_id = u.id
            WHERE d.user_id IS NULL
        ');
    }

    private function createUsersForOrphanDevis()
    {
        $orphanDevis = DB::table('devis')
            ->whereNull('user_id')
            ->get();

        foreach ($orphanDevis as $devis) {
            // Vérifier si l'email existe déjà
            $existingUser = DB::table('users')
                ->where('email', $devis->email)
                ->first();

            if ($existingUser) {
                DB::table('devis')
                    ->where('id', $devis->id)
                    ->update(['user_id' => $existingUser->id]);
            } else {
                // Créer un nouvel utilisateur
                $userId = DB::table('users')->insertGetId([
                    'name' => $devis->nom . ' ' . $devis->prenom,
                    'email' => $devis->email,
                    'password' => Hash::make('changeme' . Str::random(8)),
                    'role' => 'client',
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::table('devis')
                    ->where('id', $devis->id)
                    ->update(['user_id' => $userId]);
            }
        }
    }

    public function down(): void
    {
        Schema::table('devis', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }
};
