<?php

namespace App\Http\Controllers\Teacher\Quiz;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Teacher;
use App\Models\Group;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Teacher $teacher, Group $group)
{
    $quizzes = $group->quizzes()->latest()->get();
    return view('teacher.quizzes.index', compact('teacher', 'group', 'quizzes'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request, Teacher $teacher, Group $group)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $quiz = $group->quizzes()->create($data);

    return redirect()->route('teachers.groups.quizzes.index', [$teacher, $group])
                     ->with('success', '✅ تم إضافة الكويز بنجاح');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
