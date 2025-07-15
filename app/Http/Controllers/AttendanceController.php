<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Teacher;
use App\Models\Group;

class AttendanceController extends Controller
{
    // 1. عرض جميع سجلات الحضور الخاصة بمعلم معين
    public function index($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        // جلب حضور الطلاب المرتبطين بمحاضرات مجموعات هذا المعلم
        $attendances = Attendance::whereHas('lecture.group', function($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        })->get();

        return view('attendance.index', compact('teacher', 'attendances'));
    }

    // 2. عرض نموذج تسجيل الحضور والغياب لمحاضرة معينة
    public function create(Lecture $lecture)
    {
        $students = $lecture->group->students;
        $teacher = $lecture->group->teacher;

        $attendances = Attendance::where('lecture_id', $lecture->id)->get()->keyBy('student_id');

        return view('attendance.create', compact('lecture', 'students', 'attendances', 'teacher'));
    }

    // 3. حفظ بيانات الحضور والغياب لمجموعة (تستخدم عند اختيار مجموعة)
    public function storeForGroup(Request $request, Group $group)
    {
        $request->validate([
            'statuses' => 'required|array',
            'statuses.*' => 'in:present,absent,late',
        ]);

        $lecture = $group->lectures()->latest()->first();

        if (!$lecture) {
            return back()->with('error', 'لا توجد محاضرة مرتبطة بهذه المجموعة.');
        }

        foreach ($request->statuses as $studentId => $status) {
            Attendance::updateOrCreate(
                ['lecture_id' => $lecture->id, 'student_id' => $studentId],
                ['status' => $status]
            );
        }

        return redirect()->route('teachers.groups.attendance.index', ['teacher' => $group->teacher_id, 'group' => $group->id])
            ->with('success', 'تم تسجيل الحضور بنجاح.');
    }

    // 4. حفظ بيانات الحضور والغياب لمحاضرة معينة (تستخدم عند اختيار محاضرة)
    public function storeForLecture(Request $request, Teacher $teacher, Lecture $lecture)
        {
            $request->validate([
                'statuses' => 'required|array',
                'statuses.*' => 'in:present,absent,late',
            ]);

            foreach ($request->statuses as $studentId => $status) {
                Attendance::updateOrCreate(
                    ['lecture_id' => $lecture->id, 'student_id' => $studentId],
                    ['status' => $status]
                );
            }

            return redirect()->route('attendances.create', $lecture->id)->with('success', 'تم تسجيل الحضور بنجاح.');
        }

    // 5. عرض تقرير الحضور لمحاضرة معينة
        public function report(Teacher $teacher, Lecture $lecture)
        
        {
                // dd($lecture); // هنا ستعرف ما هي القيمة التي تصل للباراميتر

            $attendances = Attendance::where('lecture_id', $lecture->id)->with('student')->get();

            return view('attendance.report', compact('lecture', 'attendances'));
        }

    // 6. عرض نموذج تعديل حضور طالب معين لمحاضرة معينة
    public function edit(Lecture $lecture, Student $student)
    {
        $attendance = Attendance::where('lecture_id', $lecture->id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        return view('attendances.edit', compact('lecture', 'student', 'attendance'));
    }

    // 7. تحديث حالة حضور طالب معين في محاضرة معينة
    public function update(Request $request, Lecture $lecture, Student $student)
    {
        $request->validate([
            'status' => 'required|in:present,absent,late',
        ]);

        $attendance = Attendance::where('lecture_id', $lecture->id)
            ->where('student_id', $student->id)
            ->firstOrFail();

        $attendance->status = $request->status;
        $attendance->save();

        return redirect()->route('attendances.report', $lecture->id)->with('success', 'تم تحديث حالة الحضور.');
    }

    // 8. عرض الحضور لمجموعة معينة تحت معلم معين
    public function groupAttendance($teacherId, $groupId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $group = Group::with('students')->findOrFail($groupId);

        $attendances = Attendance::whereHas('lecture', function($query) use ($groupId) {
            $query->where('group_id', $groupId);
        })->get();

        $lectures = Lecture::where('group_id', $groupId)->get();

        return view('attendance.index', compact('teacher', 'group', 'lectures', 'attendances'));
    }
}
