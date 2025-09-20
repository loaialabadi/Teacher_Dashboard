<?php

namespace App\Http\Controllers\Teacher\Group;

use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Lecture;
use App\Models\Grade;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    // عرض جميع المجموعات للمعلم
public function index(Teacher $teacher)
{
    // جلب الفصول الخاصة بالمعلم فقط
    $grades = $teacher->grades()->get();

    // جلب المجموعات الخاصة بالمعلم والتي تتبع الفصول الخاصة به فقط


    return view('teacher.groups.index', compact('teacher', 'grades'));
}




public function groupsByGrade(Teacher $teacher, Grade $grade)
{
    // نجيب المجموعات الخاصة بالمعلم والفصل المحدد
    $groups = $teacher->groups()
        ->where('grade_id', $grade->id)
        ->with(['students', 'subject'])
        ->get();

    return view('teacher.groups.by-grade', compact('teacher', 'grade', 'groups'));
}

    // صفحة إنشاء مجموعة جديدة
    public function create($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $students = $teacher->students; 
        $subjects = $teacher->subjects; 
        $grades = $teacher->grades; 
        $groupIds = $teacher->groups()->pluck('id');

        return view('teacher.groups.create', compact('teacher', 'students', 'subjects', 'grades', 'groupIds'));
    }

    // حفظ مجموعة جديدة
public function store(Request $request, $teacherId)
{
    $request->validate([
        'group_name' => 'required|string|max:255',
        'subject_id' => 'required|exists:subjects,id',
        'grade_id' => 'required|exists:grades,id',
    ]);

    $group = Group::create([
        'name' => $request->group_name,
        'teacher_id' => $teacherId,
        'subject_id' => $request->subject_id,
        'grade_id' => $request->grade_id,
    ]);

    // فلترة الطلاب
    $studentIds = $request->student_ids ?? [];

    // هات الطلاب اللي بالفعل في مجموعة تابعة لنفس المدرس والمادة
    $conflictedStudents = Student::whereIn('id', $studentIds)
        ->whereHas('groups', function($q) use ($teacherId, $request) {
            $q->where('teacher_id', $teacherId)
              ->where('subject_id', $request->subject_id);
        })->pluck('id')->toArray();

    // استبعدهم
    $finalStudents = array_diff($studentIds, $conflictedStudents);

    // اربط الطلاب الباقيين
    $group->students()->sync($finalStudents);

    return redirect()->route('teachers.groups.by-grade', [$teacherId, $group->grade_id])
                     ->with('success', 'تم إنشاء المجموعة بنجاح');
}

    // تحديث بيانات المجموعة
    public function update(Request $request, $teacherId, $groupId)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
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

        return redirect()->route('teachers.teachers.groups.index', $teacherId)
                         ->with('success', 'تم تحديث المجموعة بنجاح');
    }

    // عرض نموذج نقل الطلاب بين المجموعات
    public function transferForm(Teacher $teacher, Group $sourceGroup)
    {
        $students = Student::whereHas('groups', function ($query) use ($teacher) {
            $query->where('teacher_id', $teacher->id);
        })->with('groups')->get();

        $groups = Group::where('teacher_id', $teacher->id)
                       ->where('id', '!=', $sourceGroup->id)
                       ->get();

        return view('teacher.groups.transfer-students', compact('teacher', 'sourceGroup', 'students', 'groups'));
    }

    // تنفيذ نقل الطلاب
    public function transfer(Request $request, Teacher $teacher, Group $sourceGroup)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'target_group_id' => 'required|exists:groups,id',
        ]);

        $targetGroup = Group::findOrFail($request->target_group_id);

        // فصل الطلاب من المجموعة الأصلية
        $sourceGroup->students()->detach($request->student_ids);

        // ربط الطلاب بالمجموعة الجديدة بدون تكرار
        $targetGroup->students()->syncWithoutDetaching($request->student_ids);

        return redirect()->route('teachers.groups.index', $teacher->id)
                         ->with('success', 'تم نقل الطلاب بنجاح.');
    }

    // إضافة طالب لمجموعة
public function addStudentToGroup(Request $request, $teacherId, $groupId)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
    ]);

    $group   = Group::where('id', $groupId)
                    ->where('teacher_id', $teacherId)
                    ->firstOrFail();

    $student = Student::findOrFail($request->student_id);

    // تحقق: الطالب أصلاً مربوط بالمدرس والمادة
    $isAssigned = $student->teachers()
        ->wherePivot('teacher_id', $teacherId)
        ->wherePivot('subject_id', $group->subject_id)
        ->exists();

    if (! $isAssigned) {
        return back()->with('error', 'الطالب غير مرتبط بهذا المدرس/المادة.');
    }

    // تحقق: الطالب مش موجود في مجموعة تانية مع نفس المدرس/المادة
    $alreadyInGroup = $student->groups()
        ->where('teacher_id', $teacherId)
        ->where('subject_id', $group->subject_id)
        ->exists();

    if ($alreadyInGroup) {
        return back()->with('info', 'الطالب موجود بالفعل في مجموعة أخرى لنفس المدرس/المادة.');
    }

    // إضافة الطالب للمجموعة
    $group->students()->attach($student->id);

    return back()->with('success', 'تم إضافة الطالب إلى المجموعة بنجاح.');
}

    // عرض نموذج إضافة طلاب للمجموعة
    public function showAddStudentForm($teacherId, $groupId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $group = Group::with('students')->findOrFail($groupId);
        $students = $teacher->students; 
        $groupIds = $teacher->groups()->pluck('id');
        $lectures = Lecture::whereIn('group_id', $groupIds)->get();

        return view('teacher.groups.add-student', compact('teacher', 'group', 'students', 'lectures', 'groupIds'));
    }

    // عرض تفاصيل المجموعة
    public function show($teacherId, $groupId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $group = Group::findOrFail($groupId);

        return view('teacher.groups.show', compact('teacher', 'group'));
    }



    public function showUnassignedStudents(Teacher $teacher, Group $group)
{
    // الطلاب اللي مش في أي مجموعة
    $students = Student::whereDoesntHave('groups')->get();

    return view('teacher.groups.add_students', compact('teacher', 'group', 'students'));
}

public function assignStudents(Request $request, Teacher $teacher, Group $group)
{
    $studentIds = $request->input('student_ids', []);

    foreach ($studentIds as $studentId) {
        $alreadyInGroup = \DB::table('student_teacher')
            ->where('student_id', $studentId)
            ->where('teacher_id', $teacher->id)
            ->where('subject_id', $group->subject_id) // نفس المادة
            ->exists();

        if (! $alreadyInGroup) {
            $group->students()->attach($studentId, [
                'teacher_id' => $teacher->id,
                'subject_id' => $group->subject_id,
                'grade_id'   => $group->grade_id,
            ]);
        }
    }

    return redirect()->route('teachers.groups.show', [$teacher->id, $group->id])
                     ->with('success', 'تم إضافة الطلاب بنجاح ✅');
}

}
