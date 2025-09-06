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
        $groups = $teacher->groups()->with(['students', 'grade', 'subject'])->get();
        return view('teacher.groups.index', compact('teacher', 'groups'));
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

        $group->students()->sync($request->student_ids);

        return redirect()->route('teachers.groups.index', $teacherId)
                         ->with('success', 'تم إنشاء المجموعة بنجاح');
    }

    // صفحة تعديل المجموعة
    public function edit($teacherId, $groupId)
    {
        $group = Group::with('students')->findOrFail($groupId);
        $teacher = Teacher::findOrFail($teacherId);
        $students = Student::all();
        $subjects = $teacher->subjects;
        $grades = $teacher->grades;
        $lectures = $teacher->lectures;

        return view('teacher.groups.edit', compact('group', 'teacher', 'students', 'subjects', 'grades', 'lectures'));
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

        $teacher = Teacher::findOrFail($teacherId);
        $group = Group::where('id', $groupId)->where('teacher_id', $teacherId)->firstOrFail();

        $studentId = $request->student_id;

        if ($group->students()->where('student_id', $studentId)->exists()) {
            return redirect()->back()->with('info', 'الطالب موجود بالفعل في هذه المجموعة.');
        }

        $group->students()->attach($studentId);

        return redirect()->back()->with('success', 'تم إضافة الطالب إلى المجموعة بنجاح.');
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
}
