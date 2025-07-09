<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Subject;
use App\Models\SchoolGrade;
use App\Models\Lecture;
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
        $grades = $teacher->schoolGrades; // الفصول المرتبطة بالمدرس
        $lectures = $teacher->lectures; // المحاضرات الخاصة بالمدرس

        return view('groups.create', compact('teacher', 'students', 'subjects', 'grades', 'lectures'));
    }

    public function store(Request $request, $teacherId)
    {
        $request->validate([
            'group_name' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:school_grades,id',
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
}
