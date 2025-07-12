<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Lecture;
use Illuminate\Http\Request;

class TeachersController extends Controller
{
    // ✅ عرض جميع المعلمين مع المادة الخاصة بهم
    public function index()
    {
        $teachers = Teacher::with('subject', 'groups')->get();
        return view('teachers.index', compact('teachers'));
    }

    // ✅ عرض نموذج إضافة معلم جديد
    public function create()
    {
        $subjects = Subject::all();
        return view('teachers.create', compact('subjects'));
    }

    // ✅ تخزين معلم جديد مع التحقق من البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers',
            'phone'      => 'nullable|string',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        try {
            Teacher::create($request->only(['name', 'email', 'phone', 'subject_id']));
            return redirect()->route('teachers.index')->with('success', 'تم إضافة المعلم بنجاح');
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ: ' . $e->getMessage());
        }
    }

    // ✅ عرض نموذج تعديل معلم محدد
    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('teachers.edit', compact('teacher', 'subjects'));
    }

    // ✅ تحديث بيانات معلم محدد
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:teachers,email,' . $teacher->id,
            'phone'      => 'nullable|string|max:20',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        $teacher->update($request->only(['name', 'email', 'phone', 'subject_id']));

        return redirect()->route('teachers.index')->with('success', 'تم تحديث بيانات المعلم بنجاح.');
    }

    // ✅ حذف معلم
    public function destroy(Teacher $teacher)
    {
        $teacher->delete();
        return redirect()->route('teachers.index')->with('success', 'تم حذف المعلم بنجاح');
    }

    // ✅ لوحة تحكم المعلم
    public function dashboard($id)
    {
        $teacher = Teacher::with(['students', 'lectures', 'groups'])->findOrFail($id);

        $group = $teacher->groups->first(); // جلب أول مجموعة
        $groupId = $group ? $group->id : null;

        $lectures = $teacher->lectures->sortBy('start_time'); // ترتيب الحصص

        return view('teacher.dashboard', compact('teacher', 'lectures', 'groupId'));
    }

    // ✅ عرض الحصص الخاصة بالمعلم
    public function showlectures($teacherId)
    {
        $teacher = Teacher::with(['lectures.student', 'groups'])->findOrFail($teacherId);

        $lectures = $teacher->lectures()->orderBy('lecture_date')->orderBy('lecture_time')->get();

        $groupId = $teacher->groups->first()?->id;

        return view('teachers.dashboard', [
            'teacher' => $teacher,
            'lectures' => $lectures,
            'groups' => $teacher->groups,
            'groupId' => $groupId,
        ]);
    }
}
