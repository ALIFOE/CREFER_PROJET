<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $primaryKey = 'classroom_id';
    protected $fillable = [
        'room_number',
        'building',
        'capacity',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'classroom_id');
    }
}

