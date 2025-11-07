<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminNotificationEmail extends Model
{
    protected $fillable = [
        'email',
        'formations',
        'orders',
        'devis',
        'services'
    ];

    protected $casts = [
        'formations' => 'boolean',
        'orders' => 'boolean',
        'devis' => 'boolean',
        'services' => 'boolean'
    ];
}
