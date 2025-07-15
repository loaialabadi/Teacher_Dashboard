<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Teacher;
use Illuminate\Http\Request;

class LectureController extends Controller
{
        public function index($teacher_id)
        {
            // جلب المعلم مع المجموعات وعلاقات المواد
            $teacher = Teacher::with('groups.subject')->findOrFail($teacher_id);

            // استخراج ids المجموعات
            $groupIds = $teacher->groups->pluck('id');

            // جلب المحاضرات للمجموعات
            $lectures = Lecture::whereIn('group_id', $groupIds)->latest()->paginate(10);

            return view('lectures.index', compact('teacher', 'lectures', 'groupIds'));
        }


public function create(Request $request, $teacher_id)
{
$teacher = Teacher::with('groups.subject', 'groups.grade')->findOrFail($teacher_id);

    $selectedGroup = null;
    $selectedSubjectName = null;

    if ($request->has('group_id')) {
        $selectedGroup = $teacher->groups->where('id', $request->group_id)->first();
        if ($selectedGroup && $selectedGroup->subject) {
            $selectedSubjectName = $selectedGroup->subject->name;
        }
    }

    return view('lectures.create', compact('teacher', 'selectedGroup', 'selectedSubjectName'));
}


        public function store(Request $request, $teacher_id)
        {
            $request->merge(['teacher_id' => $teacher_id]);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'start_time' => 'required|date',
                'end_time' => 'required|date|after:start_time',
                'group_id' => 'required|exists:groups,id',
                'subject_id' => 'required|exists:subjects,id',
                'teacher_id' => 'required|exists:teachers,id',
            ]);

            Lecture::create([
                'group_id' => $validated['group_id'],
                'subject_id' => $validated['subject_id'],
                'teacher_id' => $teacher_id,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
            ]);

            return redirect()->route('lectures.index', $teacher_id)->with('success', 'تمت إضافة المحاضرة بنجاح.');
        }




    public function edit($teacher_id, Lecture $lecture)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        return view('lectures.edit', compact('teacher', 'lecture'));
    }

    public function update(Request $request, $teacher_id, Lecture $lecture)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        $lecture->update($request->all());

        return redirect()->route('lectures.index', $teacher_id)->with('success', 'تم تعديل المحاضرة بنجاح.');
    }

    public function destroy($teacher_id, Lecture $lecture)
    {
        $lecture->delete();
        return redirect()->route('lectures.index', $teacher_id)->with('success', 'تم حذف المحاضرة.');
    }


public function storeMultiple(Request $request, $teacher_id)
{
    $request->validate([
        'lectures' => 'required|array',
        'lectures.*.title' => 'required|string|max:255',
        'lectures.*.description' => 'nullable|string',
        'lectures.*.start_time' => 'required|date',
        'lectures.*.end_time' => 'required|date|after:lectures.*.start_time',
        'lectures.*.group_id' => 'required|exists:groups,id',
        'lectures.*.subject_id' => 'required|exists:subjects,id',
    ]);

    foreach ($request->lectures as $lectureData) {
        Lecture::create([
            'group_id' => $lectureData['group_id'],
            'subject_id' => $lectureData['subject_id'],
    'teacher_id' => $teacher_id, // من المعامل مباشرة

            'title' => $lectureData['title'],
            'description' => $lectureData['description'] ?? null,
            'start_time' => $lectureData['start_time'],
            'end_time' => $lectureData['end_time'],
        ]);
    }

    return redirect()->route('lectures.index', $teacher_id)->with('success', 'تمت إضافة المحاضرات بنجاح.');
}


}
