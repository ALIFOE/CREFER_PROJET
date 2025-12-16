<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Course;
use Illuminate\Pagination\Paginator;

class StudentService
{
    /**
     * Récupérer la liste paginée des étudiants
     */
    public function getStudents($perPage = 15)
    {
        return Student::orderBy('last_name')
            ->orderBy('first_name')
            ->paginate($perPage);
    }

    /**
     * Récupérer un étudiant par ID
     */
    public function getStudent($id)
    {
        return Student::with(['enrollments', 'courses'])->findOrFail($id);
    }

    /**
     * Créer un nouvel étudiant
     */
    public function createStudent($data)
    {
        return Student::create($data);
    }

    /**
     * Mettre à jour un étudiant
     */
    public function updateStudent($id, $data)
    {
        $student = Student::findOrFail($id);
        $student->update($data);
        return $student;
    }

    /**
     * Supprimer un étudiant
     */
    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return true;
    }

    /**
     * Chercher des étudiants
     */
    public function searchStudents($query)
    {
        return Student::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('student_id', 'like', "%{$query}%")
            ->get();
    }

    /**
     * Obtenir les cours d'un étudiant
     */
    public function getStudentCourses($studentId)
    {
        return Student::findOrFail($studentId)
            ->courses()
            ->with('instructor')
            ->get();
    }

    /**
     * Obtenir les inscriptions d'un étudiant
     */
    public function getStudentEnrollments($studentId)
    {
        return Enrollment::where('student_id', $studentId)
            ->with('course')
            ->get();
    }
}
