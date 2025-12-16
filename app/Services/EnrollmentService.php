<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;

class EnrollmentService
{
    /**
     * Inscrire un étudiant à un cours
     */
    public function enrollStudent($studentId, $courseId, $enrollmentData = [])
    {
        // Vérifier si l'étudiant est déjà inscrit
        $existingEnrollment = Enrollment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->first();

        if ($existingEnrollment) {
            throw new \Exception('L\'étudiant est déjà inscrit à ce cours.');
        }

        $enrollmentData = array_merge([
            'student_id' => $studentId,
            'course_id' => $courseId,
            'enrollment_date' => now(),
            'status' => 'enrolled',
        ], $enrollmentData);

        return Enrollment::create($enrollmentData);
    }

    /**
     * Retirer l'inscription d'un étudiant
     */
    public function unenrollStudent($enrollmentId)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $enrollment->update(['status' => 'dropped']);
        return $enrollment;
    }

    /**
     * Affecter une note à un étudiant
     */
    public function gradeEnrollment($enrollmentId, $grade)
    {
        $enrollment = Enrollment::findOrFail($enrollmentId);
        $enrollment->update([
            'grade' => $grade,
            'status' => 'completed',
        ]);
        return $enrollment;
    }

    /**
     * Obtenir les inscriptions d'un cours
     */
    public function getCourseEnrollments($courseId)
    {
        return Enrollment::where('course_id', $courseId)
            ->with('student')
            ->get();
    }

    /**
     * Obtenir le nombre d'étudiants inscrits à un cours
     */
    public function getCourseEnrollmentCount($courseId)
    {
        return Enrollment::where('course_id', $courseId)
            ->where('status', '!=', 'dropped')
            ->count();
    }

    /**
     * Obtenir les statistiques d'un cours
     */
    public function getCourseStats($courseId)
    {
        $enrollments = Enrollment::where('course_id', $courseId)->get();

        return [
            'total_enrolled' => $enrollments->where('status', 'enrolled')->count(),
            'total_completed' => $enrollments->where('status', 'completed')->count(),
            'total_dropped' => $enrollments->where('status', 'dropped')->count(),
            'average_grade' => $enrollments->whereNotNull('grade')->avg('grade'),
        ];
    }
}
