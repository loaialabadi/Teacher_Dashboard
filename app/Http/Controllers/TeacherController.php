<?php
namespace App\Http\Controllers;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Lecture;
use App\Models\SchoolGrade;
use App\Models\Group;
use Illuminate\Http\Request;


class TeacherController extends Controller
{
    // ✅ لوحة تحكم المعلم
    public function dashboard($id)
    {
        $teacher = Teacher::with(['students', 'lectures', 'groups'])->findOrFail($id);

        // جلب جميع مجموعات المعلم
        $groups = Group::where('teacher_id', $teacher->id)->get();

        // جلب أول مجموعة لتحديد groupId
        $group = $groups->first();
        $groupId = $group ? $group->id : null;

        // ترتيب الحصص حسب الوقت
        $lectures = $teacher->lectures->sortBy('start_time');

        return view('teacher.dashboard', compact('teacher', 'lectures', 'groupId', 'groups'));
    }

    // ✅ عرض الحصص الخاصة بالمعلم
    public function showLectures($teacherId)
    {
        $teacher = Teacher::with(['lectures.student', 'groups'])->findOrFail($teacherId);

        $lectures = $teacher->lectures()->orderBy('lecture_date')->orderBy('lecture_time')->get();

        $groupId = $teacher->groups->first()?->id;

        return view('teachers.dashboard', compact('teacher', 'groups', 'groupId', 'lectures'));
    }

    // ✅ عرض الطلاب المرتبطين بالمعلم
    public function showStudents($teacherId)
    {
        $teacher = Teacher::with('students')->findOrFail($teacherId);

        return view('teacher.show-students', compact('teacher'));
    }

    // ✅ عرض الصفوف (الفصول الدراسية) الخاصة بالمعلم
    public function showGrades(Teacher $teacher)
    {
        $grades = $teacher->schoolGrades()->with('groups.students')->get();

        return view('teacher.show-grades', compact('teacher', 'grades', 'groups'));
    }

   
    //تسجيل حضور اليوم


        public function todayLectures(Teacher $teacher)
        {
            $today = now()->format('Y-m-d');

            $lectures = Lecture::where('teacher_id', $teacher->id)
                        ->whereDate('start_time', $today)
                        ->with(['group', 'subject'])
                        ->get();

            return view('teacher.attendance.today', compact('lectures', 'teacher'));
        }


        public function settings(Teacher $teacher)
        {
            return view('teacher.settings.index', compact('teacher'));
        }
}
