<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Appointment;
class TeachersController extends Controller
{
    // عرض جميع المعلمين مع المادة الخاصة بهم
    public function index()
    {
        
        $teachers = Teacher::with('subject')->get();
        return view('teachers.index', compact('teachers'));
    }

    // عرض نموذج إضافة معلم جديد
    public function create()
    {
        $subjects = Subject::all();
        return view('teachers.create', compact('subjects'));
    }

    // تخزين معلم جديد مع التحقق من البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers',
            'phone'      => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        try {
            Teacher::create($request->only(['name', 'email', 'phone', 'subject_id']));
            return redirect()->route('teachers.index')->with('success', 'تم إضافة المعلم بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    // عرض نموذج تعديل معلم محدد
    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    // تحديث بيانات معلم محدد مع التحقق من البيانات
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone'      => 'nullable|string|max:20',
            'subject_id' => 'required|exists:subjects,id',  // أضفت تحقق للمادة هنا (مهم)
        ]);

        $teacher->update($request->only(['name', 'email', 'phone', 'subject_id']));

        return redirect()->route('teachers.index')->with('success', 'تم تحديث بيانات المعلم بنجاح.');
    }

    // حذف معلم محدد
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();

        return redirect()->route('teachers.index')->with('success', 'تم حذف المعلم بنجاح');
    }


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



}
