<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with(['student', 'course'])->paginate(15);
        return view('attendances.index', compact('attendances'));
    }

    public function create()
    {
        $students = Student::where('status', 'active')->get();
        $courses = Course::all();
        return view('attendances.create', compact('students', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'course_id' => 'required|exists:courses,course_id',
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,excused',
            'remarks' => 'nullable|string',
        ]);

        // Vérifier que l'étudiant est inscrit à ce cours
        $enrollment = $student = \DB::table('enrollments')
            ->where('student_id', $validated['student_id'])
            ->where('course_id', $validated['course_id'])
            ->exists();

        if (!$enrollment) {
            return redirect()->back()->with('error', 'Cet étudiant n\'est pas inscrit à ce cours');
        }

        Attendance::create($validated);
        return redirect()->route('attendances.index')->with('success', 'Présence enregistrée avec succès');
    }

    public function show(Attendance $attendance)
    {
        return view('attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $students = Student::where('status', 'active')->get();
        $courses = Course::all();
        return view('attendances.edit', compact('attendance', 'students', 'courses'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'attendance_date' => 'required|date',
            'status' => 'required|in:present,absent,excused',
            'remarks' => 'nullable|string',
        ]);

        $attendance->update($validated);
        return redirect()->route('attendances.index')->with('success', 'Présence modifiée avec succès');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Présence supprimée avec succès');
    }
}
