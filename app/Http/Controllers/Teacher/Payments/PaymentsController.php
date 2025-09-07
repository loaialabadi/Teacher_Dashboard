<?php

namespace App\Http\Controllers\Teacher\Payments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
      // عرض صفحة الشهور للطالب
    public function index($student_id)
    {
        $student = Student::findOrFail($student_id);

        $year = now()->year;
        $months = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];

        // جلب الشهور المدفوعة
        $payments = Payment::where('student_id', $student_id)
            ->where('year', $year)
            ->pluck('is_paid', 'month')
            ->toArray();

        return view('teacher.payments.index', compact('student','months','payments','year'));
    }

    // حفظ أو تحديث الشهور
    public function store(Request $request, $student_id)
    {
        $student = Student::findOrFail($student_id);
        $teacher_id = auth()->id(); // المدرس الحالي
        $year = $request->input('year', now()->year);

        $months = [
            'January','February','March','April','May','June',
            'July','August','September','October','November','December'
        ];

        foreach ($months as $month) {
            $isPaid = in_array($month, $request->input('months', []));

            Payment::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'teacher_id' => $teacher_id,
                    'year' => $year,
                    'month' => $month,
                ],
                [
                    'is_paid' => $isPaid,
                    'paid_at' => $isPaid ? Carbon::now() : null,
                ]
            );
        }

        return redirect()->route('teachers.payments.index', $student_id)
            ->with('success', 'تم تحديث بيانات الدفع بنجاح ✅');
    }
}
