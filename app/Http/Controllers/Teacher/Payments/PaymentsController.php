<?php

namespace App\Http\Controllers\Teacher\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\Teacher;
use Carbon\Carbon;

class PaymentsController extends Controller
{
    // عرض صفحة الشهور للطالب
    public function index($teacher_id, $student_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $student = Student::findOrFail($student_id);

        $year = now()->year;
        $months = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];

        // جلب الشهور الموجودة للطالب + المعلم + السنة
        $payments = Payment::where('student_id', $student->id)
            ->where('teacher_id', $teacher->id)
            ->where('year', $year)
            ->pluck('is_paid', 'month')
            ->toArray();

        // لو مفيش بيانات، نولّدها تلقائيًا
        if(empty($payments)) {
            foreach ($months as $month) {
                Payment::create([
                    'student_id' => $student->id,
                    'teacher_id' => $teacher->id,
                    'year' => $year,
                    'month' => $month,
                    'is_paid' => false,
                ]);
            }

            $payments = Payment::where('student_id', $student->id)
                ->where('teacher_id', $teacher->id)
                ->where('year', $year)
                ->pluck('is_paid', 'month')
                ->toArray();
        }

        return view('teacher.payments.index', compact('teacher','student','months','payments','year'));
    }

    // حفظ أو تحديث الشهور
    public function store(Request $request, $teacher_id, $student_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $student = Student::findOrFail($student_id);
        $year = $request->input('year', now()->year);

        $months = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];

        foreach ($months as $month) {
            $isPaid = in_array($month, $request->input('months', []));

            Payment::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'teacher_id' => $teacher->id,
                    'year' => $year,
                    'month' => $month,
                ],
                [
                    'is_paid' => $isPaid,
                    'paid_at' => $isPaid ? Carbon::now() : null,
                ]
            );
        }

        return redirect()->route('teachers.payments.index', [$teacher->id, $student->id])
            ->with('success', 'تم تحديث بيانات الدفع بنجاح ✅');
    }
}
