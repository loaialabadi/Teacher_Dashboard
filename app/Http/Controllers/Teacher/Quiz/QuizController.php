<?php

namespace App\Http\Controllers\Teacher\Quiz;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Teacher;
use App\Models\Group;

use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function groupsWithQuizzes(Teacher $teacher)
    {
        $groups = $teacher->groups()->with('quizzes')->get();

        return view('teacher.quizzes.groups_index', compact('teacher', 'groups'));
    }


    public function create(Teacher $teacher, Group $group)
    {
        return view('teacher.quizzes.create', compact('teacher', 'group'));
    }

    // حفظ الكويز
    public function store(Request $request, Teacher $teacher, Group $group)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'quiz_date'   => 'required|date',
        ]);

        $quiz = $group->quizzes()->create([
            'teacher_id'  => $teacher->id,
            'title'       => $data['title'],
            'description' => $data['description'] ?? null,
            'quiz_date'   => $data['quiz_date'],
        ]);

        // إنشاء نتائج مبدئية لكل طالب في المجموعة
        foreach ($group->students as $student) {
            $quiz->results()->create([
                'student_id' => $student->id,
                'score'      => null,
                'note'       => null,
            ]);
        }

        return redirect()->route('teachers.groups.quizzes.index', $teacher->id)
            ->with('success', 'تم إنشاء الكويز بنجاح.');
    }



        public function results(Teacher $teacher, Quiz $quiz)
    {
        // جلب الطلاب اللي في نفس المجموعة الخاصة بالكويز
        $results = $quiz->results()->with('student')->get();

        return view('teacher.quizzes.results', compact('teacher', 'quiz', 'results'));
    }

    // حفظ درجات الطلاب
    public function storeResults(Request $request, Teacher $teacher, Quiz $quiz)
    {
        $data = $request->validate([
            'scores' => 'required|array',
            'scores.*' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:255',
        ]);

        foreach ($data['scores'] as $studentId => $score) {
            $quiz->results()->where('student_id', $studentId)->update([
                'score' => $score,
                'note'  => $data['notes'][$studentId] ?? null,
            ]);
        }

        return redirect()->route('teachers.quizzes.results', [$teacher->id, $quiz->id])
            ->with('success', 'تم حفظ الدرجات بنجاح ✅');
    }
}
