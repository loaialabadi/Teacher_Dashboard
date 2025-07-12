<?php

namespace App\Http\Controllers;

use App\Models\Lecture;
use App\Models\Teacher;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        $groupIds = $teacher->groups()->pluck('id');

$lectures = Lecture::whereIn('group_id', $groupIds)->latest()->paginate(10);

        return view('lectures.index', compact('teacher', 'lectures', 'groupIds'));
    }

    public function create($teacher_id)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        return view('lectures.create', compact('teacher'));
    }
public function store(Request $request, $teacher_id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'group_id' => 'required|exists:groups,id',
    ]);

    Lecture::create([
        'group_id' => $request->group_id,
        'title' => $request->title,
        'description' => $request->description,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
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
    $validated = $request->validate([
        'lectures' => 'required|array|min:1',
        'lectures.*.group_id' => 'required|exists:groups,id',
        'lectures.*.title' => 'required|string|max:255',
        'lectures.*.description' => 'nullable|string',
        'lectures.*.start_time' => 'required|date',
        'lectures.*.end_time' => 'required|date|after:lectures.*.start_time',
    ]);

    foreach ($validated['lectures'] as $lectureData) {
                $lectureData['teacher_id'] = $teacher_id;  // أضف هذا السطر

        Lecture::create($lectureData);
    }

    return redirect()->route('lectures.index', $teacher_id)->with('success', 'تمت إضافة المحاضرات بنجاح.');
}

}
