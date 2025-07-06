<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\Student;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Notifications\AttendanceNotification;

use App\Models\Appointment;

class AttendanceController extends Controller
{
    // صفحة عرض الطلاب للحصة مع اختيار الحضور والغياب
    public function markAttendanceForm(Appointment $appointment)
    {
        $students = $appointment->teacher->students;

        // استدعاء الحضور السابق إذا موجود (تعديل)
        $attendances = Attendance::where('appointment_id', $appointment->id)
                        ->get()->keyBy('student_id');

        return view('attendance.mark', compact('appointment', 'students', 'attendances'));
    }

    // حفظ الحضور
    public function saveAttendance(Request $request, Appointment $appointment)
    {
        $request->validate([
            'attendance' => 'required|array',
            'attendance.*' => 'in:present,absent',
        ]);

        foreach ($request->attendance as $studentId => $status) {
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'appointment_id' => $appointment->id,
                ],
                [
                    'status' => $status,
                    'attended_at' => $appointment->scheduled_at,
                ]
            );
        }

        return redirect()->route('appointments.index', $appointment->teacher->id)
                         ->with('success', 'تم تسجيل الحضور بنجاح');
    }
}
