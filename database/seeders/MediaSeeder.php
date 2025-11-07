<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MediaSeeder extends Seeder
{
    public function run()
    {
        $mediaData = [
            [
                'title' => 'Installation Solaire Résidentielle',
                'description' => 'Installation de panneaux solaires sur une maison familiale',
                'path' => 'media/installations/solar-home-1.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Projet Commercial',
                'description' => 'Installation de grande envergure pour un client commercial',
                'path' => 'media/installations/commercial-1.jpg',
                'type' => 'image',
                'is_featured' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Maintenance Préventive',
                'description' => 'Notre équipe effectuant une maintenance préventive',
                'path' => 'media/maintenance/maintenance-1.jpg',
                'type' => 'image',
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Formation Technique',
                'description' => 'Session de formation technique pour nos installateurs',
                'path' => 'media/training/training-1.jpg',
                'type' => 'image',
                'is_featured' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('media')->insert($mediaData);
    }
}