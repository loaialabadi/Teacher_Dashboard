<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Appointment;

class GroupController extends Controller
{
    public function createGroup($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        // جلب الطلاب التابعين للمعلم
        $students = Student::where('teacher_id', $teacherId)->get();

        return view('groups.create', compact('teacher', 'students'));
    }

    public function storeGroup(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'group_name' => 'required|string|max:255',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:students,id',
            'dates' => 'required|array|min:1',
            'dates.*' => 'date',
            'times' => 'required|array|min:1',
            'times.*' => 'date_format:H:i',
        ]);

        $group = Group::create([
            'name'       => $request->group_name,
            'teacher_id' => $request->teacher_id,
        ]);

        // ربط الطلاب بالمجموعة
        $group->students()->sync($request->student_ids);

        // جدول المواعيد
        foreach ($request->dates as $index => $date) {
            $time = $request->times[$index] ?? '08:00';

            foreach ($request->student_ids as $studentId) {
                Appointment::create([
                    'teacher_id'       => $request->teacher_id,
                    'student_id'       => $studentId,
                    'group_id'         => $group->id,
                    'appointment_date' => $date,
                    'appointment_time' => $time,
                ]);
            }
        }

        return redirect("/teachers/{$request->teacher_id}/appointments")
               ->with('success', 'تم إنشاء المجموعة وجدولة الحصص بنجاح.');
    }

    public function showAppointments($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $appointments = $teacher->appointments()
            ->with('student')
            ->orderBy('appointment_date')
            ->orderBy('appointment_time')
            ->get();

        return view('teachers.appointments', compact('teacher', 'appointments'));
    }

    public function showGroups($teacherId)
    {
        $teacher = Teacher::findOrFail($teacherId);

        // جلب المجموعات مع الطلاب المرتبطين بكل مجموعة
        $groups = $teacher->groups()->with('students')->get();

return view('groups.index', compact('teacher', 'groups'));
    }

    public function show($teacherId, $groupId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $group = Group::with('students')->findOrFail($groupId);

        // تأكد أن المجموعة تتبع نفس المعلم (اختياري لكن ينصح به)
        if ($group->teacher_id != $teacher->id) {
            abort(403, 'ليس لديك صلاحية الوصول لهذه المجموعة');
        }

        return view('groups.show', compact('teacher', 'group'));  // <=== صححت هنا من $groups إلى $group
    }

    public function addStudentForm($teacherId, $groupId)
    {
        $teacher = Teacher::findOrFail($teacherId);
        $group = Group::with('students')->findOrFail($groupId);

        // الطلاب الذين لا ينتمون للمجموعة بعد
        $availableStudents = Student::where('teacher_id', $teacherId)
                                    ->whereNotIn('id', $group->students->pluck('id'))
                                    ->get();

        return view('groups.add-student', compact('teacher', 'group', 'availableStudents'));
    }

    public function addStudentStore(Request $request, $teacherId, $groupId)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
        ]);

        $group = Group::findOrFail($groupId);
        $group->students()->attach($request->student_id);

        return redirect()->route('groups.show', ['teacher' => $teacherId, 'group' => $groupId])
                         ->with('success', 'تم إضافة الطالب للمجموعة بنجاح.');
    }

    public function showTransferForm($teacherId, $sourceGroupId)
{
    $teacher = Teacher::findOrFail($teacherId);
    $sourceGroup = Group::with('students')->findOrFail($sourceGroupId);

    // تأكد أن المجموعة تابعة للمعلم
    if ($sourceGroup->teacher_id != $teacher->id) {
        abort(403, 'ليس لديك صلاحية الوصول لهذه المجموعة');
    }

    // جلب مجموعات المعلم الأخرى (المجموعات المستهدفة لنقل الطلاب إليها)
    $targetGroups = Group::where('teacher_id', $teacherId)
                        ->where('id', '!=', $sourceGroupId)
                        ->get();

    // جلب طلاب المعلم في المجموعة المصدر
    $students = $sourceGroup->students;

    return view('groups.transfer-students', compact('teacher', 'sourceGroup', 'targetGroups', 'students'));
}

public function transferStudents(Request $request, $teacherId, $sourceGroupId)
{
    $request->validate([
        'target_group_id' => 'required|exists:groups,id',
        'student_ids' => 'required|array|min:1',
        'student_ids.*' => 'exists:students,id',
    ]);

    $teacher = Teacher::findOrFail($teacherId);
    $sourceGroup = Group::findOrFail($sourceGroupId);
    $targetGroup = Group::findOrFail($request->target_group_id);

    // التحقق من ملكية المجموعات للمعلم
    if ($sourceGroup->teacher_id != $teacher->id || $targetGroup->teacher_id != $teacher->id) {
        abort(403, 'ليس لديك صلاحية إجراء هذه العملية');
    }

    // إزالة الطلاب من المجموعة المصدر
    $sourceGroup->students()->detach($request->student_ids);

    // إضافة الطلاب للمجموعة الهدف (مع تجنب التكرار)
    $targetGroup->students()->syncWithoutDetaching($request->student_ids);

    return redirect()->route('groups.show', ['teacher' => $teacherId, 'group' => $sourceGroupId])
                     ->with('success', 'تم نقل الطلاب بنجاح.');
}

}
