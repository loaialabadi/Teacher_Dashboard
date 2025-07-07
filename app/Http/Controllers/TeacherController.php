<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\SchoolGrade;
class TeacherController extends Controller
{
    // عرض جميع المعلمين مع المادة الخاصة بهم

public function dashboard($id)
{
    $teacher = Teacher::with('students', 'appointments', 'groups')->findOrFail($id);

    $group = $teacher->groups()->first(); // جلب أول مجموعة للمعلم
    $groupId = $group ? $group->id : null;
    
$appointments = Appointment::where('teacher_id', $teacher->id)
    ->orderBy('start_time', 'asc')
    ->get();

    return view('teacher.dashboard', compact('teacher', 'appointments', 'groupId'));
}

public function showAppointments($teacherId)
{
    // جلب المعلم مع الحصص والطلاب المرتبطين
    $teacher = Teacher::with('appointments.student')->findOrFail($teacherId);

    // جلب الحصص مع ترتيبها
    $appointments = $teacher->appointments()->orderBy('appointment_date')->orderBy('appointment_time')->get();

    $groupId = $groups->first()?->id;

    // عرض الصفحة وتمرير البيانات
    return view('teachers.dashboard', compact('teacher', 'groups', 'groupId'));
}



public function showStudents($teacherId)
{
    // جلب المعلم مع الطلاب المرتبطين
    $teacher = Teacher::with('students')->findOrFail($teacherId);

    // إرسال البيانات إلى الـ view
    return view('teacher.show-students', compact('teacher'));
}


public function showClasses(Teacher $teacher)
{
    // تحميل الفصول مع المجموعات، وكل مجموعة مع طلابها
    $SchoolGrades = $teacher->SchoolGrades()->with('groups.students')->get();

    return view('teacher.show-classes', compact('teacher', 'SchoolGrades'));
}


}
