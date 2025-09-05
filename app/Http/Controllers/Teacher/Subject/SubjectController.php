<?php

namespace App\Http\Controllers\Teacher\Subject;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Subject;
class SubjectController extends Controller
{
    public function index(Teacher $teacher)
    {
        $subjects = $teacher->subjects()->paginate(10);

        return view('teacher.subjects.index', compact('teacher', 'subjects'));
    }

    public function edit(Teacher $teacher)
{
    $allSubjects = \App\Models\Subject::all();
    $teacherSubjects = $teacher->subjects->pluck('id')->toArray();

    return view('subjects.edit', compact('teacher', 'allSubjects', 'teacherSubjects'));
}

public function create(Teacher $teacher)
{
    $subjects = Subject::all();
    return view('teacher.subjects.create', compact('teacher', 'subjects'));
}

public function store(Request $request, Teacher $teacher)
{
    $validated = $request->validate([
        'subjects' => 'required|array',
        'subjects.*' => 'exists:subjects,id',
    ]);

    $teacher->subjects()->attach($validated['subjects']);

    return redirect()->route('subjects.index', $teacher)->with('success', 'تمت إضافة المواد بنجاح.');
}


public function update(Request $request, Teacher $teacher)
{
    $validated = $request->validate([
        'subjects' => 'nullable|array',
        'subjects.*' => 'exists:subjects,id',
    ]);

    $teacher->subjects()->sync($validated['subjects'] ?? []);

    return redirect()->route('teacher.subjects.index', $teacher)->with('success', 'تم تحديث المواد بنجاح.');
}


public function destroy(Teacher $teacher, Subject $subject)
{
    $teacher->subjects()->detach($subject->id);

    return redirect()->route('subjects.index', $teacher)->with('success', 'تم حذف المادة بنجاح.');
}
}