<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Group;
use App\Models\Lecture;
use Illuminate\Http\Request;
use App\Models\Grade;

class TeacherController extends Controller
{
    // لوحة تحكم المعلم
    public function dashboard($id)
    {
        $teacher = Teacher::with(['students', 'lectures', 'groups'])->findOrFail($id);
        $groups = $teacher->groups;
        $groupId = $groups->first()?->id;
        $lectures = $teacher->lectures->sortBy('start_time');

        return view('teacher.teacher.dashboard', compact('teacher', 'lectures', 'groupId', 'groups'));
    }

    // عرض الحصص الخاصة بالمعلم
    public function showLectures($teacherId)
    {
        $teacher = Teacher::with(['lectures.group', 'groups'])->findOrFail($teacherId);
        $lectures = $teacher->lectures()->orderBy('lecture_date')->orderBy('lecture_time')->get();
        $groupId = $teacher->groups->first()?->id;

        return view('teachers.dashboard', compact('teacher', 'lectures', 'groupId'));
    }

    // عرض الطلاب المرتبطين بالمعلم
// صفحة الفصول
public function showGrades($teacherId)
{
    $teacher = Teacher::findOrFail($teacherId);
    $grades = Grade::all();

    // جهز كل فصل مع عدد الطلاب
    $gradesWithCount = $grades->map(function($grade) use ($teacher) {
        $grade->students_count = Student::where('grade_id', $grade->id)
            ->whereHas('studentTeacher', function($q) use ($teacher) {
                $q->where('teacher_id', $teacher->id);
            })
            ->count();
        return $grade; // ارجع الكائن نفسه بعد اضافة students_count
    });

    return view('teacher.students.grades', [
        'teacher' => $teacher,
        'grades' => $gradesWithCount
    ]);
}




public function showStudentsByGrade($teacherId, $gradeId, $subjectId = null)
{
    $teacher = Teacher::findOrFail($teacherId);
    $grade = Grade::findOrFail($gradeId);

    $students = Student::where('grade_id', $grade->id)
        ->whereHas('studentTeacher', function($q) use ($teacher, $subjectId) {
            $q->where('teacher_id', $teacher->id);
            if ($subjectId) {
                $q->where('subject_id', $subjectId);
            }
        })
        ->with(['parent', 'groups', 'studentTeacher' => function($q) use ($teacher, $subjectId) {
            $q->where('teacher_id', $teacher->id);
            if ($subjectId) {
                $q->where('subject_id', $subjectId);
            }
            $q->with('subject');
        }])
        ->get();

    return view('teacher.students.index', compact('teacher', 'grade', 'students'));
}



    // عرض نموذج إضافة طالب جديد
    public function createStudent(Teacher $teacher)
    {
        return view('teacher.students.create', compact('teacher'));
    }

    // تخزين طالب جديد
    public function storeStudent(Request $request, Teacher $teacher)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $parent = ParentModel::firstOrCreate(
            ['phone' => $data['parent_phone']],
            ['name' => $data['parent_name'], 'password' => bcrypt('defaultpassword123')]
        );

        $student = Student::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'grade_id' => $data['grade_id'],
            'parent_id' => $parent->id,
        ]);

        $teacher->students()->attach($student->id, [
            'subject_id' => $data['subject_id'],
            'grade_id' => $data['grade_id'],
        ]);

        if ($data['group_id']) {
            $student->groups()->attach($data['group_id']);
        } else {
            $group = Group::firstOrCreate([
                'teacher_id' => $teacher->id,
                'subject_id' => $data['subject_id'],
                'grade_id' => $data['grade_id'],
            ]);
            $student->groups()->attach($group->id);
        }

        return redirect()->route('teachers.students.index', $teacher->id)
            ->with('success', 'تم إضافة الطالب وربطه بالمدرس وولي الأمر بنجاح');
    }

    // عرض بيانات طالب معين
    public function showStudent(Teacher $teacher, Student $student)
    {
        return view('teacher.students.show', compact('teacher', 'student'));
    }


    // تعديل طالب
public function editStudent(Teacher $teacher, Student $student)
{
    $teachers = Teacher::all(); // جلب كل المدرسين
    $parents  = ParentModel::all(); // إذا كنت تستخدم قائمة أولياء الأمور
    return view('teacher.students.edit', compact('teacher', 'student', 'teachers', 'parents'.'subjects'));
}

    public function updateStudent(Request $request, Teacher $teacher, Student $student)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'subject_id' => 'required|exists:subjects,id',
            'grade_id' => 'required|exists:grades,id',
            'group_id' => 'nullable|exists:groups,id',
        ]);

        $student->update($data);

        return redirect()->route('teachers.students.index', $teacher->id)
            ->with('success', 'تم تحديث بيانات الطالب بنجاح');
    }

    // حذف الطالب
    public function destroyStudent(Teacher $teacher, Student $student)
    {
        $student->delete();

        return redirect()->route('teachers.students.index', $teacher->id)
            ->with('success', 'تم حذف الطالب بنجاح');
    }



    // حضور اليوم
    public function todayLectures(Teacher $teacher)
    {
        $today = now()->toDateString();
        $lectures = Lecture::where('teacher_id', $teacher->id)
                    ->whereDate('start_time', $today)
                    ->with(['group', 'subject'])
                    ->get();
        return view('teacher.teacher.attendance.today', compact('lectures', 'teacher'));
    }

    // إعدادات المدرس
    public function settings(Teacher $teacher)
    {
        return view('teacher.teacher.settings.index', compact('teacher'));
    }
}
