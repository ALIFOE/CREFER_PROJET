<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'path',
        'type',
        'category',
        'dimensions',
        'is_featured'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'dimensions' => 'array',
    ];

    public static function getCategories()
    {
        return [
            'installations' => 'Installations',
            'maintenance' => 'Maintenance',
            'formations' => 'Formations',
            'evenements' => 'Événements',
            'projets' => 'Projets',
            'general' => 'Général'
        ];
    }
}
