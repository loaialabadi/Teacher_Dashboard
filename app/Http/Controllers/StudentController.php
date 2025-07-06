<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\ParentModel;
use App\Models\Student;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private $stages = [
        'الصف الأول الابتدائي',
        'الصف الثاني الابتدائي',
        'الصف الثالث الابتدائي',
        'الصف الرابع الابتدائي',
        'الصف الخامس الابتدائي',
        'الصف السادس الابتدائي',
        'الصف الأول الإعدادي',
        'الصف الثاني الإعدادي',
        'الصف الثالث الإعدادي',
        'الصف الأول الثانوي',
        'الصف الثاني الثانوي',
        'الصف الثالث الثانوي',
    ];

    public function index()
    {
        $students = Student::with('teacher.subject', 'parent')->paginate(10);
        return view('students.index', compact('students'));
    }

public function create(Teacher $teacher)
{
    $parents = ParentModel::all();
    $stages = $this->stages;
    return view('students.create', compact('teacher', 'parents', 'stages'));
}


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|unique:students,phone',
            'teacher_id' => 'required|exists:teachers,id',
            'parent_id' => 'nullable|exists:parent_models,id',
            'parent_name' => 'nullable|string|max:255',
            'parent_phone' => 'nullable|string|max:255',
            'academic_stage' => 'required|string|max:255',
        ]);

        if ($request->input('createParentToggle') == '1') {
            $parent = ParentModel::create([
                'name' => $request->input('parent_name'),
                'phone' => $request->input('parent_phone'),
                'password' => bcrypt($request->input('parent_password')),
            ]);
        } else {
            $parent = ParentModel::find($request->input('parent_id'));
        }

        Student::create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'teacher_id' => $request->input('teacher_id'),
            'parent_id' => $parent->id,
            'academic_stage' => $request->input('academic_stage'),
        ]);

        return back()->with('success', 'تم إضافة الطالب بنجاح');
    }

    public function edit(Student $student)
    {
        $teachers = Teacher::all();
        $parents = ParentModel::all();
        $stages = $this->stages;
        return view('students.edit', compact('student', 'teachers', 'parents', 'stages'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:students,phone,' . $student->id,
            'teacher_id' => 'required|exists:teachers,id',
            'parent_id' => 'required|exists:parent_models,id',
            'academic_stage' => 'required|string|max:255',
        ]);

        $student->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'teacher_id' => $request->input('teacher_id'),
            'parent_id' => $request->input('parent_id'),
            'academic_stage' => $request->input('academic_stage'),
        ]);

        return redirect()->route('students.index')->with('success', 'تم تحديث بيانات الطالب بنجاح.');
    }

    public function destroy($id)
    {
        $student = Student::find($id);

        if (!$student) {
            return back()->withErrors(['error' => 'الطالب غير موجود في قاعدة البيانات.']);
        }

        try {
            $student->delete();
            return back()->with('success', 'تم حذف الطالب بنجاح.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'حدث خطأ أثناء الحذف: ' . $e->getMessage()]);
        }
    }
}
