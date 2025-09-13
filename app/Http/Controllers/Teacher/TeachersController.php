<?php

namespace App\Http\Controllers\Teacher;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
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
        'name'     => 'required|string|max:255',
        'phone'    => 'nullable|string|max:20',
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    // 1️⃣ إنشاء مستخدم في جدول users
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => bcrypt($request->password),
    ]);

    // 2️⃣ إنشاء معلم مربوط بالمستخدم
    Teacher::create([
        'name'    => $request->name,
        'phone'   => $request->phone,
        'user_id' => $user->id,
    ]);

    return redirect()->route('teachers.index')->with('success', 'تم إضافة المعلم بنجاح.');
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
                'email'      => 'required|email|unique:users,email,' . $teacher->user_id,
                'phone'      => 'nullable|string|max:20',
                'password'   => 'nullable|min:6',
            ]);

            // تحديث teacher (من غير باسورد)
            $teacher->update([
                'name'       => $request->name,
                'phone'      => $request->phone,
            ]);

            // تحديث user المرتبط
            $teacher->user->update([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => $request->filled('password') 
                                ? Hash::make($request->password) 
                                : $teacher->user->password,
            ]);

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
