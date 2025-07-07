<?php

namespace App\Http\Controllers;

use App\Models\SchoolGrade;  // غيّر إلى الموديل الصحيح لديك
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeController
{
    public function create()
    {
        $teachers = Teacher::all();
        $subjects = Subject::all();

        return view('grade.create', compact('teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'description' => 'nullable|string',
        ]);

        SchoolGrade::create($request->all());  // تأكد من اسم الموديل الصحيح

        return redirect()->route('grade.index')->with('success', 'تم إضافة الحصة بنجاح');
    }

    public function index()
    {
        $grades = SchoolGrade::with('teacher', 'subject')->orderBy('date', 'desc')->paginate(10);

        return view('grade.index', compact('grades'));
    }
}
