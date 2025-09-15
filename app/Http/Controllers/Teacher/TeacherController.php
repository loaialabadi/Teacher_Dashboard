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
use App\Models\Subject;

class TeacherController extends Controller
{
    // لوحة تحكم المعلم
    public function dashboard($id)
    {
        $teacher = Teacher::with(['students', 'lectures', 'groups'])->findOrFail($id);
        $groups = $teacher->groups;
    $groups   = $teacher->groups;   // كل الجروبات
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
public function showGrades($teacherId)
{
    $teacher = Teacher::findOrFail($teacherId);

$grades = $teacher->grades->map(function($grade) use ($teacher) {
    $grade->students_count = $teacher->students()
        ->wherePivot('grade_id', $grade->id)
        ->count();
    return $grade;
});

    return view('teacher.students.grades', compact('teacher', 'grades'));
}




public function showStudentsByGrade($teacherId, $gradeId, $subjectId = null)
{
    $teacher = Teacher::findOrFail($teacherId);
    $grade = Grade::findOrFail($gradeId);

    $students = $teacher->students()
        ->wherePivot('grade_id', $grade->id) // جلب الطلاب حسب pivot
        ->when($subjectId, function($q) use ($subjectId) {
            $q->wherePivot('subject_id', $subjectId);
        })
        ->with(['parent', 'studentTeacher' => function($q) use ($teacher, $subjectId) {
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
    public function createStudent(Teacher $teacher, Grade $grade)
    {
        return view('teacher.students.create', compact('teacher','grade'));
    }

public function storeStudent(Request $request, Teacher $teacher, Grade $grade)
{
    $data = $request->validate([
        'name'        => 'required|string|max:255',
        'phone'       => 'required|string|max:20',
        'gender'      => 'required|string|in:ذكر,أنثى',
        'parent_name' => 'required|string|max:255',
        'parent_phone'=> 'required|string|max:20',
        'subject_id'  => 'required|exists:subjects,id',
    ]);

    // ولي الأمر
    $parent = ParentModel::firstOrCreate(
        ['phone' => $data['parent_phone']],
        ['name' => $data['parent_name'], 'password' => bcrypt('defaultpassword123')]
    );

    // إنشاء الطالب
    $student = Student::create([
        'name'      => $data['name'],
        'phone'     => $data['phone'],
        'gender'    => $data['gender'],
        'grade_id'  => $grade->id,
        'parent_id' => $parent->id,
    ]);

    // ربط الطالب بالمعلم (في pivot teacher_student أو student_teacher)
    $teacher->students()->attach($student->id, [
        'subject_id' => $data['subject_id'],
        'grade_id'   => $grade->id,
        'group_id'   => null,
    ]);


    return redirect()->route('teachers.students.grade', [$teacher->id, $grade->id])
        ->with('success', 'تم إضافة الطالب وربطه بالمعلم والفصل بنجاح');
}




    // تعديل طالب
public function editStudent(Teacher $teacher, Student $student)
{
    $parents  = ParentModel::all(); 

    // المواد الخاصة بالمعلم
    $subjects = Subject::whereIn(
        'id',
        $teacher->groups()->pluck('subject_id')->unique()
    )->get();

    // الفصول الخاصة بالمعلم
    $grades = Grade::whereIn(
        'id',
        $teacher->groups()->pluck('grade_id')->unique()
    )->get();

    // المجموعات الخاصة بالمعلم
    $groups = $teacher->groups;

    return view('teacher.students.edit', compact(
        'teacher', 'student', 'parents', 'subjects', 'grades', 'groups'
    ));
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
