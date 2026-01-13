<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Professor extends Model
{
    use HasFactory;

    protected $primaryKey = 'professor_id';
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'phone',
        'specialization',
        'hire_date',
        'status',
    ];

    protected $casts = [
        'hire_date' => 'date',
    ];

    // Relations
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'professor_id');
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->firstname} {$this->lastname}";
    }
}
