<?php

namespace App\Http\Controllers\Teacher\Student;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\GroupStudent;
use App\Models\ParentModel; // عدل الاسم حسب موديل ولي الأمر عندك

use App\Models\Group;
class StudentController extends Controller
{
    // عرض كل الطلاب للمدرس معين مع عرض بياناته


public function index(Teacher $teacher)
{
$students = Student::with(['parent', 'studentTeacher.subject', 'groups'])
    ->whereHas('groups', function($query) use ($teacher) {
        $query->where('teacher_id', $teacher->id);
    })->get();
        // dd($students);
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

    $parent = ParentModel::firstOrCreate(
        ['phone' => $data['parent_phone']],
        [
            'name' => $data['parent_name'],
            'password' => bcrypt('defaultpassword123'),
        ]
    );

    $student = Student::create([
        'name' => $data['name'],
        'phone' => $data['phone'],
        'grade_id' => $data['grade_id'],
        'parent_id' => $parent->id,
    ]);

    $teacher->students()->attach($student->id, [
        'subject_id' => $data['subject_id'],
        'grade_id' => $data['grade_id'],
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    

    if ($data['group_id']) {
        $student->groups()->attach($data['group_id']);
    } else {
        $group = Group::firstOrCreate([
            'teacher_id' => $teacher->id,
            'subject_id' => $data['subject_id'],
            'grade_id' => $data['grade_id'],
        ]);
        $student->groups()->attach($group->id);
    }

    return redirect()->route('teachers.students.index', $teacher->id)
                     ->with('success', 'تم إضافة الطالب وربطه بالمدرس وولي الأمر بنجاح');
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
