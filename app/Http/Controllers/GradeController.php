<?php

namespace App\Http\Controllers;

use App\Models\SchoolGrade;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
Use App\Models\Grade;
class GradeController extends Controller
{


//   public function index()
// {
//     $grades = SchoolGrade::with('teacher', 'subject')->orderBy('created_at', 'desc')->paginate(10);

//     return view('grades.index', compact('grades'));
// }


  public function create(Teacher $teacher)
{
    $grades = Grade::all(); // جدول الفصول الدراسية
    return view('grades.create', compact('teacher', 'grades'));
}


public function store(Request $request, $teacherId)
{
    $validated = $request->validate([
        'grade_id' => 'required|exists:grades,id',
    ]);

    \App\Models\GradeTeacher::create([
        'teacher_id' => $teacherId,
        'grade_id' => $validated['grade_id'],
    ]);

    return redirect()->route('grades.index', $teacherId)
                     ->with('success', 'تم إضافة الفصل الدراسي بنجاح.');
}



public function index(Teacher $teacher)
{
    $grades = $teacher->grades()->with('subject')->paginate(10);
    
    return view('grades.index', compact('teacher', 'grades'));
}


    // أضف الدوال edit, update, destroy حسب حاجتك
}
