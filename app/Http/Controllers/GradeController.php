<?php

namespace App\Http\Controllers;

use App\Models\SchoolGrade;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Grade;
use App\Models\GradeTeacher;

class GradeController extends Controller
{
    /**
     * عرض الفصول المرتبطة بالمعلم
     */
    public function index(Teacher $teacher)
    {
        $grades = $teacher->grades()->with('subject')->paginate(10);
        return view('grades.index', compact('teacher', 'grades'));
    }

    /**
     * عرض نموذج إضافة فصل دراسي لمعلم معين
     */
    public function create(Teacher $teacher)
    {
        $grades = Grade::all(); // جلب جميع الفصول من جدول grades
        return view('grades.create', compact('teacher', 'grades'));
    }

    /**
     * تخزين الفصل الدراسي المرتبط بالمعلم
     */
        public function store(Request $request, Teacher $teacher)
        {
            $validated = $request->validate([
                'grade_id' => 'required|exists:grades,id',
            ]);

            GradeTeacher::create([
                'teacher_id' => $teacher->id,
                'grade_id' => $validated['grade_id'],
            ]);

            return redirect()->route('grades.index', ['teacher' => $teacher->id]);
        }


    public function destroy($teacherId, $gradeId)
    {
        $gradeTeacher = GradeTeacher::where('teacher_id', $teacherId)
                                    ->where('grade_id', $gradeId)
                                    ->firstOrFail();

        $gradeTeacher->delete();

        return redirect()->route('grades.index', $teacherId)
                        ->with('success', 'تم حذف الفصل الدراسي بنجاح.');
    }

    /**
     * عرض نموذج تعديل فصل دراسي لمعلم معين
     */
    public function edit(Teacher $teacher, $gradeId)
    {
        $grade = Grade::findOrFail($gradeId);
        return view('grades.edit', compact('teacher', 'grade'));
    }

    /**
     * تحديث الفصل الدراسي المرتبط بالمعلم
     */
public function showStudentsGradeTeacher(Teacher $teacher)
{
    // جلب جميع الطلاب المرتبطين بهذا المعلم (مثلاً)
    $students = $teacher->students()->get();

    return view('teachers.show_students', compact('teacher', 'students'));
}


}
