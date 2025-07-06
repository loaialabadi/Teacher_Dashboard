<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class storeGroup extends Controller
{
    public function storeGroup(Request $request)
{
    $request->validate([
        'teacher_id' => 'required|exists:teachers,id',
        'group_name' => 'required|string|max:255',
        'student_ids' => 'required|array',
        'student_ids.*' => 'exists:students,id',
        'dates'      => 'required|array',
        'times'      => 'required|array',
    ]);

    // تحقق عدم انضمام الطلاب لمجموعة أخرى لنفس المدرس
    foreach ($request->student_ids as $student_id) {
        $exists = \DB::table('group_student')
            ->join('groups', 'groups.id', '=', 'group_student.group_id')
            ->where('group_student.student_id', $student_id)
            ->where('groups.teacher_id', $request->teacher_id)
            ->exists();

        if ($exists) {
            return back()->withErrors([
                'student_ids' => "الطالب برقم ID {$student_id} موجود بالفعل في مجموعة أخرى لهذا المدرس."
            ])->withInput();
        }
    }

    // إنشاء المجموعة
    $group = Group::create([
        'name' => $request->group_name,
        'teacher_id' => $request->teacher_id,
    ]);

    // ربط الطلاب بالمجموعة
    $group->students()->attach($request->student_ids);

    // إنشاء المواعيد لكل طالب في المجموعة حسب التواريخ والأوقات
    $students = $group->students;

    foreach ($request->dates as $index => $date) {
        $time = $request->times[$index] ?? '08:00';

        foreach ($students as $student) {
            \App\Models\Appointment::create([
                'teacher_id' => $group->teacher_id,
                'student_id' => $student->id,
                'group_id'   => $group->id,
                'appointment_date' => $date,
                'appointment_time' => $time,
            ]);
        }
    }

    return redirect()->route('teachers.appointments', $request->teacher_id)
                     ->with('success', 'تم إنشاء المجموعة وربط الطلاب والمواعيد بنجاح.');
}

}
