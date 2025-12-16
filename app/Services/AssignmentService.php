<?php

namespace App\Services;

use App\Models\Assignment;
use App\Models\Student;
use App\Models\Course;
use Carbon\Carbon;

class AssignmentService
{
    /**
     * Créer une nouvelle assignation
     */
    public function createAssignment($data)
    {
        return Assignment::create($data);
    }

    /**
     * Mettre à jour une assignation
     */
    public function updateAssignment($id, $data)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->update($data);
        return $assignment;
    }

    /**
     * Supprimer une assignation
     */
    public function deleteAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        $assignment->delete();
        return true;
    }

    /**
     * Soumettre une assignation
     */
    public function submitAssignment($assignmentId)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        
        $status = Carbon::now()->isAfter($assignment->due_date) ? 'late' : 'submitted';
        
        $assignment->update([
            'submitted_date' => now(),
            'status' => $status,
        ]);
        
        return $assignment;
    }

    /**
     * Noter une assignation
     */
    public function gradeAssignment($assignmentId, $grade, $feedback = null)
    {
        $assignment = Assignment::findOrFail($assignmentId);
        $assignment->update([
            'grade' => $grade,
            'feedback' => $feedback,
            'status' => 'graded',
        ]);
        return $assignment;
    }

    /**
     * Obtenir les assignations d'un étudiant
     */
    public function getStudentAssignments($studentId)
    {
        return Assignment::where('student_id', $studentId)
            ->with('course')
            ->orderBy('due_date')
            ->get();
    }

    /**
     * Obtenir les assignations d'un cours
     */
    public function getCourseAssignments($courseId)
    {
        return Assignment::where('course_id', $courseId)
            ->with('student')
            ->orderBy('due_date')
            ->get();
    }

    /**
     * Obtenir les assignations non notées
     */
    public function getPendingGradingAssignments($courseId = null)
    {
        $query = Assignment::where('status', '!=', 'graded');
        
        if ($courseId) {
            $query->where('course_id', $courseId);
        }
        
        return $query->with(['student', 'course'])
            ->orderBy('submitted_date')
            ->get();
    }

    /**
     * Obtenir les assignations en retard
     */
    public function getOverdueAssignments($studentId = null)
    {
        $query = Assignment::where('due_date', '<', now())
            ->whereIn('status', ['pending', 'late']);
        
        if ($studentId) {
            $query->where('student_id', $studentId);
        }
        
        return $query->with(['student', 'course'])
            ->orderBy('due_date')
            ->get();
    }

    /**
     * Obtenir les statistiques d'un étudiant
     */
    public function getStudentAssignmentStats($studentId)
    {
        $assignments = Assignment::where('student_id', $studentId)->get();

        return [
            'total' => $assignments->count(),
            'submitted' => $assignments->where('status', 'submitted')->count(),
            'graded' => $assignments->where('status', 'graded')->count(),
            'pending' => $assignments->where('status', 'pending')->count(),
            'average_grade' => $assignments->where('status', 'graded')->avg('grade'),
        ];
    }
}
