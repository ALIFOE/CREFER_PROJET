<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'course_id',
        'title',
        'description',
        'due_date',
        'submitted_date',
        'grade',
        'feedback',
        'status',
    ];

    protected $casts = [
        'due_date' => 'date',
        'submitted_date' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
