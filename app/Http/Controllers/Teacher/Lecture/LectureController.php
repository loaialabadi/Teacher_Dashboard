<?php

namespace App\Http\Controllers\Teacher\Lecture;
use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Grade;
use App\Models\Group;

class LectureController extends Controller
{


public function groups(Teacher $teacher, Grade $grade)
{
    $groups = $teacher->groups()->where('grade_id', $grade->id)->get();
    return view('teacher.lectures.by_groups', compact('teacher', 'grade', 'groups'));
}



public function byGroup(Teacher $teacher, Grade $grade, Group $group)
{
    // جلب المحاضرات الخاصة بالمجموعة
    $lectures = $group->lectures()->with('subject')->get();
    return view('teacher.lectures.by_group', compact('teacher', 'grade', 'group', 'lectures'));
}

    public function grades(Teacher $teacher)
    {
        $grades = $teacher->grades()->get();
        return view('teacher.lectures.by_grades', compact('teacher', 'grades'));
    }



public function index($teacher_id)
{
    $teacher = Teacher::with('groups.subject')->findOrFail($teacher_id);

    $groupIds = $teacher->groups->pluck('id');

    // جلب المحاضرات وترتيبها حسب start_time
    $lectures = Lecture::whereIn('group_id', $groupIds)
        ->orderBy('start_time')
        ->get();

    // ترتيب المحاضرات حسب أيام الأسبوع
    $weekDays = ['Saturday','Sunday','Monday','Tuesday','Wednesday','Thursday','Friday'];

    $lecturesByDay = [];
    foreach ($weekDays as $day) {
        $lecturesByDay[$day] = $lectures->filter(function($lecture) use ($day) {
            return Carbon::parse($lecture->start_time)->format('l') === $day;
        });
    }

    return view('teacher.lectures.index', compact('teacher', 'lecturesByDay','lectures'));
}


public function create($teacherId)
{
    $teacher = Teacher::findOrFail($teacherId);

    // اختر أول مجموعة مرتبطة بالمعلم تلقائيًا
    $selectedGroup = $teacher->groups()->with('subject', 'grade')->first();

    if (!$selectedGroup) {
        // إذا لم توجد مجموعة
        return view('teacher.lectures.create', compact('teacher', 'selectedGroup'));
    }

    $selectedSubjectName = $selectedGroup->subject->name;

    return view('teacher.lectures.create', compact('teacher', 'selectedGroup', 'selectedSubjectName'));
}

public function store(Request $request, $teacher_id)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_time' => 'required|date',
        'end_time' => 'required|date|after:start_time',
        'group_id' => 'required|exists:groups,id',
        'subject_id' => 'required|exists:subjects,id',
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

    return redirect()->route('teachers.lectures.index', $teacher_id)
                     ->with('success', 'تمت إضافة المحاضرة بنجاح.');
}


    public function edit($teacher_id, Lecture $lecture)
    {
        $teacher = Teacher::findOrFail($teacher_id);
        return view('teacher.lectures.edit', compact('teacher', 'lecture'));
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
