<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Collection;

class CourseService
{
    /**
     * Récupérer tous les cours
     */
    public function getAllCourses()
    {
        return Course::with(['classroom', 'instructor'])
            ->orderBy('code')
            ->get();
    }

    /**
     * Récupérer un cours par ID
     */
    public function getCourse($id)
    {
        return Course::with(['classroom', 'instructor', 'students', 'enrollments'])
            ->findOrFail($id);
    }

    /**
     * Créer un nouveau cours
     */
    public function createCourse($data)
    {
        return Course::create($data);
    }

    /**
     * Mettre à jour un cours
     */
    public function updateCourse($id, $data)
    {
        $course = Course::findOrFail($id);
        $course->update($data);
        return $course;
    }

    /**
     * Supprimer un cours
     */
    public function deleteCourse($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return true;
    }

    /**
     * Obtenir les cours d'un instructeur
     */
    public function getInstructorCourses($instructorId)
    {
        return Course::where('instructor_id', $instructorId)
            ->with('classroom')
            ->orderBy('code')
            ->get();
    }

    /**
     * Obtenir les cours d'une salle
     */
    public function getClassroomCourses($classroomId)
    {
        return Course::where('classroom_id', $classroomId)
            ->with('instructor')
            ->orderBy('code')
            ->get();
    }

    /**
     * Chercher des cours
     */
    public function searchCourses($query)
    {
        return Course::where('name', 'like', "%{$query}%")
            ->orWhere('code', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->get();
    }

    /**
     * Obtenir les cours actifs
     */
    public function getActiveCourses()
    {
        return Course::where('status', 'active')
            ->with(['classroom', 'instructor'])
            ->orderBy('code')
            ->get();
    }

    /**
     * Filtrer les cours par statut
     */
    public function getCoursesByStatus($status)
    {
        return Course::where('status', $status)
            ->with(['classroom', 'instructor'])
            ->orderBy('code')
            ->get();
    }
}
