<?php

namespace App\Http\Controllers\Teacher\Lecture;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\LectureChange;
use Illuminate\Http\Request;
use App\Models\Teacher;

class LectureChangeController extends Controller
{
    public function index(Teacher $teacher)
    {
        $changes = LectureChange::with('lecture.teacher')
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('teacher.lectures.changes.index', compact('changes', 'teacher'));
    }
public function create(Teacher $teacher)
{
    // هات المحاضرات الخاصة بالمعلم ده فقط
    $lectures = Lecture::where('teacher_id', $teacher->id)->get();

    return view('teacher.lectures.changes.create', compact('lectures', 'teacher'));
}


public function store(Request $request, Teacher $teacher)
{
    $data = $request->validate([
        'lecture_id'     => 'required|exists:lectures,id',
        'new_date'       => 'nullable|date',
        'new_start_time' => 'nullable|date_format:H:i',
        'new_end_time'   => 'nullable|date_format:H:i|after:new_start_time',
        'reason'         => 'nullable|string',
    ]);

    // نجيب بيانات المحاضرة القديمة
    $lecture = Lecture::findOrFail($data['lecture_id']);

LectureChange::create([
    'lecture_id'      => $lecture->id,
    'old_date'        => now()->format('Y-m-d'),
    'old_start_time'  => $lecture->start_time, // نص
    'old_end_time'    => $lecture->end_time,   // نص
    'new_date'        => $data['new_date'] ?? null,
    'new_start_time'  => $data['new_start_time'] ?? null,
    'new_end_time'    => $data['new_end_time'] ?? null,
    'reason'          => $data['reason'] ?? null,
]);


    return redirect()->route('teachers.lectures.lecture_changes.index', $teacher->id)
                     ->with('success', 'تم تسجيل التغيير بنجاح.');
}

public function edit(Teacher $teacher, LectureChange $lectureChange)
{
    $lectures = Lecture::where('teacher_id', $teacher->id)->get();
    return view('teacher.lectures.changes.edit', compact('teacher', 'lectureChange', 'lectures'));
}


    public function update(Request $request, LectureChange $lectureChange)
    {
        $data = $request->validate([
            'lecture_id' => 'required|exists:lectures,id',
            'new_start_time' => 'nullable|date',
            'new_end_time'   => 'nullable|date|after:new_start_time',
            'status'         => 'required|in:canceled,postponed,rescheduled',
            'note'           => 'nullable|string',
        ]);

        $lectureChange->update($data);

        return redirect()->route('lecture_changes.index')
                         ->with('success', 'تم تحديث التغيير بنجاح.');
    }

    public function destroy(LectureChange $lectureChange)
    {
        $lectureChange->delete();
        return redirect()->route('lecture_changes.index')
                         ->with('success', 'تم حذف التغيير.');
    }
}
