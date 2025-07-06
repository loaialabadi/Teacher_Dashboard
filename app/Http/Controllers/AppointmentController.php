<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Appointment;
use App\Models\Group;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
public function create() {
    $teachers = Teacher::all();
    return view('appointments.create', compact('teachers'));
}

public function store(Request $request) {
    if ($request->has('group_name')) {
        // إنشاء مجموعة مع مواعيد متعددة
        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'group_name' => 'required|string|max:255',
            'dates'      => 'required|array',
            'times'      => 'required|array',
        ]);

        $group = Group::create([
            'name'       => $request->group_name,
            'teacher_id' => $request->teacher_id,
        ]);

        $students = Student::where('teacher_id', $request->teacher_id)->get();

        foreach ($request->dates as $index => $date) {
            $time = $request->times[$index] ?? null;
            foreach ($students as $student) {
                Appointment::create([
                    'teacher_id'       => $request->teacher_id,
                    'group_id'         => $group->id,
                    'student_id'       => $student->id,
                    'appointment_date' => $date,
                    'appointment_time' => $time,
                ]);
            }
        }

        return redirect()->route('teachers.appointments', $request->teacher_id)
                         ->with('success', 'تم إضافة الحصص داخل المجموعة بنجاح');
    } else {
        // إدخال حصة واحدة بدون مجموعة
        $request->validate([
            'teacher_id'       => 'required|exists:teachers,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
        ]);

        $students = Student::where('teacher_id', $request->teacher_id)->get();

        foreach ($students as $student) {
            Appointment::create([
                'teacher_id'       => $request->teacher_id,
                'student_id'       => $student->id,
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
            ]);
        }

        return redirect()->route('teachers.appointments', $request->teacher_id)
                         ->with('success', 'تم إضافة الحصة لجميع الطلاب بنجاح');
    }
}

public function index($teacherId) {
    $teacher = Teacher::findOrFail($teacherId);
    $appointments = Appointment::where('teacher_id', $teacherId)
                               ->orderBy('appointment_date')
                               ->orderBy('appointment_time')
                               ->get();

    return view('appointments.index', compact('teacher', 'appointments'));
}




    
};
