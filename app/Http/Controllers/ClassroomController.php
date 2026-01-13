<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function index()
    {
        $classrooms = Classroom::paginate(15);
        return view('classrooms.index', compact('classrooms'));
    }

    public function create()
    {
        return view('classrooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:classrooms,room_number|max:50',
            'building' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:500',
        ]);

        Classroom::create($validated);
        return redirect()->route('classrooms.index')->with('success', 'Salle créée avec succès');
    }

    public function show(Classroom $classroom)
    {
        return view('classrooms.show', compact('classroom'));
    }

    public function edit(Classroom $classroom)
    {
        return view('classrooms.edit', compact('classroom'));
    }

    public function update(Request $request, Classroom $classroom)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:classrooms,room_number,' . $classroom->classroom_id . ',classroom_id|max:50',
            'building' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1|max:500',
        ]);

        $classroom->update($validated);
        return redirect()->route('classrooms.index')->with('success', 'Salle modifiée avec succès');
    }

    public function destroy(Classroom $classroom)
    {
        $classroom->delete();
        return redirect()->route('classrooms.index')->with('success', 'Salle supprimée avec succès');
    }
}
