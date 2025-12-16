<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'capacity',
        'location',
        'description',
        'status',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
