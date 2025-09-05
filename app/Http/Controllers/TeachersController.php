<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Models\User;

class TeachersController extends Controller
{
    // ✅ عرض جميع المعلمين مع المادة الخاصة بهم
    public function index()
    {
        $teachers = Teacher::with('subject', 'groups')->get();
        return view('teacher.teachers.index', compact('teachers'));
    }

    // ✅ عرض نموذج إضافة معلم جديد
    public function create()
    
    {
            $users = User::all(); // جلب جميع المستخدمين لعرضهم في القائمة

        return view('teacher.teachers.create', compact('users'));
    }

    // ✅ تخزين معلم جديد مع التحقق من البيانات
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'nullable|string',
                    'user_id' => 'required|exists:users,id',

        ]);
        Teacher::create([
            'name' => $request->name,
            'phone' => $request->phone,
    'user_id' => $request->user_id,  // هذه قيمة المستخدم المختار من الفورم
        ]);


      return redirect()->route('teacher.teachers.index')->with('success', 'تم إضافة المعلم بنجاح.');

    }       
    

    // ✅ عرض نموذج تعديل معلم محدد
    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('teacher.teachers.edit', compact('teacher', 'subjects'));
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
        return redirect()->route('teacher.teachers.index')->with('success', 'تم حذف المعلم بنجاح');
    }

    // ✅ لوحة تحكم المعلم
    public function dashboard($id)
    {
        $teacher = Teacher::with(['students', 'lectures', 'groups'])->findOrFail($id);

        $group = $teacher->groups->first(); // جلب أول مجموعة
        $groupId = $group ? $group->id : null;

        $lectures = $teacher->lectures->sortBy('start_time'); // ترتيب الحصص

        return view('teacher.teacher.dashboard', compact('teacher', 'lectures', 'groupId'));
    }

    // ✅ عرض الحصص الخاصة بالمعلم
    public function showlectures($teacherId)
    {
        $teacher = Teacher::with(['lectures.student', 'groups'])->findOrFail($teacherId);

        $lectures = $teacher->lectures()->orderBy('lecture_date')->orderBy('lecture_time')->get();

        $groupId = $teacher->groups->first()?->id;

        return view('teacher.teachers.dashboard', [
            'teacher' => $teacher,
            'lectures' => $lectures,
            'groups' => $teacher->groups,
            'groupId' => $groupId,
        ]);
    }
}
