<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Devis extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($devis) {
            // Si user_id n'est pas défini, essayer de trouver l'utilisateur par email
            if (!$devis->user_id && $devis->email) {
                $user = User::where('email', $devis->email)->first();
                
                if ($user) {
                    $devis->user_id = $user->id;
                } else {
                    // Créer un nouvel utilisateur
                    $user = User::create([
                        'name' => $devis->nom . ' ' . $devis->prenom,
                        'email' => $devis->email,
                        'password' => Hash::make('changeme' . Str::random(8)),
                        'role' => 'client'
                    ]);
                    $devis->user_id = $user->id;
                }
            }
        });
    }

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'type_batiment',
        'facture_mensuelle',
        'consommation_annuelle',
        'type_toiture',
        'orientation',
        'objectifs',
        'message',
        'analyse_technique',
        'statut',
        'user_id'
    ];

    protected $casts = [
        'objectifs' => 'array',
        'analyse_technique' => 'array',
        'facture_mensuelle' => 'decimal:2',
        'consommation_annuelle' => 'decimal:2'
    ];

    /**
     * Get the user that owns the devis.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'en_attente' => 'En attente',
            'en_cours' => 'En cours',
            'accepte' => 'Accepté',
            'refuse' => 'Refusé'
        ][$this->statut] ?? 'Inconnu';
    }

    public function getStatusColorAttribute()
    {
        return [
            'en_attente' => 'yellow',
            'en_cours' => 'blue',
            'accepte' => 'green',
            'refuse' => 'red'
        ][$this->statut] ?? 'gray';
    }

    public function getNomCompletAttribute()
    {
        return "{$this->nom} {$this->prenom}";
    }
}
