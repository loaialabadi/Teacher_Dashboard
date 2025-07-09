<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Lecture;
use App\Models\Grade;
use Illuminate\Http\Request;

class GroupController extends Controller
{
  public function index(Teacher $teacher)
{
    $groups = $teacher->groups()->with('students')->get();

    return view('groups.index', compact('teacher', 'groups'));
}


    public function create($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $students = Student::all();
        $subjects = $teacher->subjects; // المواد المرتبطة بالمدرس
        $grades = $teacher->grades; // الفصول المرتبطة بالمدرس
        $lectures = $teacher->lectures; // المحاضرات الخاصة بالمدرس

        return view('groups.create', compact('teacher', 'students', 'subjects', 'grades', 'lectures'));
    }

    public function store(Request $request, $teacherId)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'lecture_id' => 'required|exists:lectures,id',
            'student_ids' => 'required|array|min:1',
        ]);

        $group = Group::create([
            'name' => $request->group_name,
            'teacher_id' => $teacherId,
            'subject_id' => $request->subject_id,
            'grade_id' => $request->grade_id,
            'lecture_id' => $request->lecture_id,
        ]);

        $group->students()->sync($request->student_ids);

        return redirect()->route('groups.index', $teacherId)->with('success', 'تم إنشاء المجموعة بنجاح');
    }

    public function edit($teacherId, $groupId)
    {
        $group = Group::with('students')->findOrFail($groupId);
        $teacher = Teacher::findOrFail($teacherId);
        $students = Student::all();
        $subjects = $teacher->subjects;
        $grades = $teacher->schoolGrades;
        $lectures = $teacher->lectures;

        return view('groups.edit', compact('group', 'teacher', 'students', 'subjects', 'grades', 'lectures'));
    }

    public function update(Request $request, $teacherId, $groupId)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:school_grades,id',
            'lecture_id' => 'required|exists:lectures,id',
            'student_ids' => 'required|array|min:1',
        ]);

        $group = Group::findOrFail($groupId);
        $group->update([
            'name' => $request->group_name,
            'subject_id' => $request->subject_id,
            'grade_id' => $request->grade_id,
            'lecture_id' => $request->lecture_id,
        ]);

        $group->students()->sync($request->student_ids);

        return redirect()->route('groups.index', $teacherId)->with('success', 'تم تحديث المجموعة بنجاح');
    }



public function transferForm(Teacher $teacher, Group $sourceGroup)
{
    // جلب جميع طلاب المعلم (يمكنهم أن يكونوا في أي مجموعة أو بدون مجموعة)
    $students = Student::where('teacher_id', $teacher->id)->get();

    // جلب جميع مجموعات المعلم عدا المجموعة الحالية (لنقل الطلاب إليها)
    $groups = Group::where('teacher_id', $teacher->id)
                   ->where('id', '!=', $sourceGroup->id)
                   ->get();

    return view('groups.transfer-students', compact('teacher', 'sourceGroup', 'students', 'groups'));
}

public function transfer(Request $request, Teacher $teacher, Group $sourceGroup)
{
    $request->validate([
        'student_ids' => 'required|array',
        'student_ids.*' => 'exists:students,id',
        'target_group_id' => 'required|exists:groups,id',
    ]);

    $targetGroup = Group::findOrFail($request->target_group_id);

    // 1. افصل الطلاب من المجموعة الأصلية
    $sourceGroup->students()->detach($request->student_ids);

    // 2. اربط الطلاب بالمجموعة الجديدة
    $targetGroup->students()->attach($request->student_ids);

    return redirect()->route('groups.show', ['teacher' => $teacher->id, 'group' => $sourceGroup->id])
                     ->with('success', 'تم نقل الطلاب بنجاح.');
}

}
