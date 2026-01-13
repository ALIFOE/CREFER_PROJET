<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Professor;
use App\Models\Classroom;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with(['professor', 'classroom'])->paginate(15);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $professors = Professor::where('status', 'active')->get();
        $classrooms = Classroom::all();
        return view('courses.create', compact('professors', 'classrooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|unique:courses,course_code|max:50',
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credit_hours' => 'required|integer|min:1|max:10',
            'professor_id' => 'required|exists:professors,professor_id',
            'classroom_id' => 'required|exists:classrooms,classroom_id',
            'schedule' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Course::create($validated);
        return redirect()->route('courses.index')->with('success', 'Cours créé avec succès');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $professors = Professor::where('status', 'active')->get();
        $classrooms = Classroom::all();
        return view('courses.edit', compact('course', 'professors', 'classrooms'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'course_code' => 'required|string|unique:courses,course_code,' . $course->course_id . ',course_id|max:50',
            'course_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'credit_hours' => 'required|integer|min:1|max:10',
            'professor_id' => 'required|exists:professors,professor_id',
            'classroom_id' => 'required|exists:classrooms,classroom_id',
            'schedule' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $course->update($validated);
        return redirect()->route('courses.index')->with('success', 'Cours modifié avec succès');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Cours supprimé avec succès');
    }
}
