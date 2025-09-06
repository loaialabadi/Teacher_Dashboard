<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
class StudentController extends Controller
{
    // عرض كل الطلاب
public function index(Request $request)
{
    $query = Student::with(['parent', 'grade']);

    if ($request->filled('q')) {
        $search = $request->q;
        $query->where('name', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%")
              ->orWhereHas('parent', function($q) use ($search) {
                  $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
              });
    }

    $students = $query->get();

    return view('student.index', compact('students'));
}

    // عرض تفاصيل طالب معين (مع المدرسين المرتبطين بيه)
    public function show($id)
    {
        $student = Student::with([
            'parent',
            'grade',
            'groups.subject',
            'groups.teacher',
            'groups.lectures',
        ])->findOrFail($id);

        return view('student.show', compact('student'));
    }

    // عرض تفاصيل طالب مع مدرس معين
    public function teacherDetails($studentId, $teacherId)
    {
        $student = Student::with(['groups' => function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId)->with('subject', 'lectures');
        }])->findOrFail($studentId);

        $teacher = Teacher::findOrFail($teacherId);
        $groups  = $student->groups;

        return view('student.teacher-details', compact('student', 'teacher', 'groups'));
    }
}
