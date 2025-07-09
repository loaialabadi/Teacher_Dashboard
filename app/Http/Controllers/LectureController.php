<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Teacher;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $lectures = $teacher->lectures()->latest()->paginate(10);

        return view('lectures.index', compact('teacher', 'lectures'));
    }

    public function create($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        return view('lectures.create', compact('teacher'));
    }

    public function store(Request $request, $teacher_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $teacher = Teacher::findOrFail($teacher_id);
        $teacher->lectures()->create($request->all());

        return redirect()->route('lectures.index', $teacher_id)->with('success', 'تمت إضافة المحاضرة بنجاح.');
    }

    public function edit($teacher_id, Lecture $lecture)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        return view('lectures.edit', compact('teacher', 'lecture'));
    }

    public function update(Request $request, $teacher_id, Lecture $lecture)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $lecture->update($request->all());

        return redirect()->route('lectures.index', $teacher_id)->with('success', 'تم تعديل المحاضرة بنجاح.');
    }

    public function destroy($teacher_id, Lecture $lecture)
    {
        $lecture->delete();
        return redirect()->route('lectures.index', $teacher_id)->with('success', 'تم حذف المحاضرة.');
    }
}
