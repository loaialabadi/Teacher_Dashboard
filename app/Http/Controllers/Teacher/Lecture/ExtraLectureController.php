<?php

namespace App\Http\Controllers\Teacher\Lecture;

use App\Http\Controllers\Controller;
use App\Models\ExtraLecture;
use App\Models\Teacher;
use App\Models\Group;
use App\Models\Subject;
use Illuminate\Http\Request;

class ExtraLectureController extends Controller
{
    public function index()
    {
        $extraLectures = ExtraLecture::with(['teacher','group','subject'])->latest()->get();
        return view('teacher.extra_lectures.index', compact('extraLectures'));
    }

    public function create()
    {
        $teachers = Teacher::all();
        $groups   = Group::all();
        $subjects = Subject::all();

        return view('teacher.extra_lectures.create', compact('teachers','groups','subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'group_id'    => 'required|exists:groups,id',
            'subject_id'  => 'required|exists:subjects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
            'is_makeup'   => 'boolean',
        ]);

        ExtraLecture::create($data);

        return redirect()->route('extra_lectures.index')
                         ->with('success', 'تمت إضافة المحاضرة الإضافية بنجاح.');
    }

    public function edit(ExtraLecture $extraLecture)
    {
        $teachers = Teacher::all();
        $groups   = Group::all();
        $subjects = Subject::all();

        return view('teacher.extra_lectures.edit', compact('extraLecture','teachers','groups','subjects'));
    }

    public function update(Request $request, ExtraLecture $extraLecture)
    {
        $data = $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'group_id'    => 'required|exists:groups,id',
            'subject_id'  => 'required|exists:subjects,id',
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
            'is_makeup'   => 'boolean',
        ]);

        $extraLecture->update($data);

        return redirect()->route('extra_lectures.index')
                         ->with('success', 'تم تحديث المحاضرة الإضافية بنجاح.');
    }

    public function destroy(ExtraLecture $extraLecture)
    {
        $extraLecture->delete();
        return redirect()->route('extra_lectures.index')
                         ->with('success', 'تم حذف المحاضرة الإضافية.');
    }
}
