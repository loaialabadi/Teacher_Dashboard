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
$students = $teacher->students; // أو $teacher->students()->get();
        $subjects = $teacher->subjects; // المواد المرتبطة بالمدرس
        $grades = $teacher->grades; // الفصول المرتبطة بالمدرس
$groupIds = $teacher->groups()->pluck('id');

        return view('groups.create', compact('teacher', 'students', 'subjects', 'grades', 'groupIds'));
    }

  public function store(Request $request, $teacherId)
{
    $request->validate([
        'group_name' => 'required|string|max:255',
        'subject_id' => 'required|exists:subjects,id',
        'grade_id' => 'required|exists:grades,id',
        'student_ids' => 'required|array|min:1',
    ]);

    $group = Group::create([
        'name' => $request->group_name,
        'teacher_id' => $teacherId,
        'subject_id' => $request->subject_id,
        'grade_id' => $request->grade_id,
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
$students = $teacher->students; // أو $teacher->students()->get();

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

    return redirect()->route('groups.index', ['teacher' => $teacher->id, 'group' => $sourceGroup->id])
                     ->with('success', 'تم نقل الطلاب بنجاح.');
}


public function addStudentToGroup(Request $request, $teacherId, $groupId)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
    ]);

    $teacher = Teacher::findOrFail($teacherId);
    $group = Group::where('id', $groupId)->where('teacher_id', $teacherId)->firstOrFail();

    $studentId = $request->student_id;

    // تحقق إذا الطالب مرتبط أصلاً بالمجموعة (لتجنب التكرار)
    if ($group->students()->where('student_id', $studentId)->exists()) {
        return redirect()->back()->with('info', 'الطالب موجود بالفعل في هذه المجموعة.');
    }

    // ربط الطالب بالمجموعة
    $group->students()->attach($studentId);

    return redirect()->back()->with('success', 'تم إضافة الطالب إلى المجموعة بنجاح.');
}


public function showAddStudentForm($teacherId, $groupId)
{
    $teacher = Teacher::findOrFail($teacherId);
    $group = Group::with('students')->findOrFail($groupId);
$students = $teacher->students; // أو $teacher->students()->get();
$groupIds = $teacher->groups()->pluck('id');
$lectures = Lecture::whereIn('group_id', $groupIds)->get();
    // لو عندك علاقات أخرى تبغى تعرضها مثل المحاضرات، المواد، تقدر تجيبها هنا

    return view('groups.add-student', compact('teacher', 'group', 'students', 'lectures', 'groupIds'));
}

public function show($teacherId, $groupId)
{
    $teacher = Teacher::findOrFail($teacherId);
    $group = Group::findOrFail($groupId);

    // ممكن تضيف بيانات أخرى لو احتجت
    return view('groups.show', compact('teacher', 'group'));
}


}
