<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // عرض كل الطلاب للمدرس معين مع عرض بياناته
    public function index(Teacher $teacher)
    {
        // جلب الطلاب المرتبطين بالمدرس مع إمكانية التصفية أو البحث مستقبلاً
        $students = Student::where('teacher_id', $teacher->id)->paginate(15);


        return view('students.index', compact('teacher', 'students'));
    }

    // عرض نموذج إنشاء طالب جديد
    public function create(Teacher $teacher)
    {
        return view('students.create', compact('teacher'));
    }

    // تخزين الطالب الجديد
    public function store(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        // إضافة teacher_id
        $data['teacher_id'] = $teacher->id;

        Student::create($data);

        return redirect()->route('teachers.students.index', $teacher->id)
                         ->with('success', 'تم إضافة الطالب بنجاح');
    }

    // عرض بيانات طالب معين
    public function show(Teacher $teacher, Student $student)
    {
        // تأكد إن الطالب يخص هذا المدرس
        if ($student->teacher_id !== $teacher->id) {
            abort(403);
        }

        return view('students.show', compact('teacher', 'student'));
    }

    // عرض نموذج تعديل طالب
    public function edit(Teacher $teacher, Student $student)
    {
        if ($student->teacher_id !== $teacher->id) {
            abort(403);
        }

        return view('students.edit', compact('teacher', 'student'));
    }

    // تحديث بيانات الطالب
    public function update(Request $request, Teacher $teacher, Student $student)
    {
        if ($student->teacher_id !== $teacher->id) {
            abort(403);
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $student->update($data);

        return redirect()->route('teachers.students.index', $teacher->id)
                         ->with('success', 'تم تحديث بيانات الطالب بنجاح');
    }

    // حذف الطالب
    public function destroy(Teacher $teacher, Student $student)
    {
        if ($student->teacher_id !== $teacher->id) {
            abort(403);
        }

        $student->delete();

        return redirect()->route('teachers.students.index', $teacher->id)
                         ->with('success', 'تم حذف الطالب بنجاح');
    }
}
