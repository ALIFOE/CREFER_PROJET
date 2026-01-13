<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = Enrollment::with(['student', 'course'])->paginate(15);
        return view('enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')->get();
        $courses = Course::all();
        return view('enrollments.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'course_id' => 'required|exists:courses,course_id',
            'enrollment_date' => 'required|date',
            'grade' => 'nullable|string|max:5',
            'attendance_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        // Vérifier que l'étudiant n'est pas déjà inscrit à ce cours
        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Cet étudiant est déjà inscrit à ce cours');
        }

        Enrollment::create($validated);
        return redirect()->route('enrollments.index')->with('success', 'Inscription créée avec succès');
    }

    public function show(Enrollment $enrollment)
    {
        return view('enrollments.show', compact('enrollment'));
    }

    public function edit(Enrollment $enrollment)
    {
        $students = Student::where('status', 'active')->get();
        $courses = Course::all();
        return view('enrollments.edit', compact('enrollment', 'students', 'courses'));
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'enrollment_date' => 'required|date',
            'grade' => 'nullable|string|max:5',
            'attendance_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        $enrollment->update($validated);
        return redirect()->route('enrollments.index')->with('success', 'Inscription modifiée avec succès');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return redirect()->route('enrollments.index')->with('success', 'Inscription supprimée avec succès');
    }
}
