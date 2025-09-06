<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Teacher\Group\GroupController;
use App\Http\Controllers\Teacher\Subject\SubjectController;
use App\Http\Controllers\Teacher\Grade\GradeController;
use App\Http\Controllers\Teacher\Lecture\LectureController;
use App\Http\Controllers\Teacher\Attendance\AttendanceController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeachersController;
use App\Http\Controllers\Teacher\TeacherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ParentController;

// الصفحة الرئيسية
Route::get('/', fn() => view('welcome'));

// بيانات طالب
Route::get('/data-students/{student}', [StudentController::class, 'show'])
    ->name('students.data.show');

// لوحة تحكم الأدمن
Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

// 🟢 الطلاب
Route::prefix('students')->name('students.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/{student}', [StudentController::class, 'show'])->name('show');
    Route::get('/{student}/teacher/{teacher}', [StudentController::class, 'teacherDetails'])->name('teacher.details');
    Route::get('/{student}/schedule-groups', [StudentController::class, 'scheduleAndGroups'])->name('schedule-groups');
});

// موارد أساسية
Route::resources([
    'teachers' => TeachersController::class,
    'students' => StudentController::class,
    'parents'  => ParentController::class,
]);

Route::resource('classes', ClassController::class)->only(['index', 'create', 'store']);

// البروفايل
Route::prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

// الحضور للفصول والطلاب
Route::prefix('attendance')->name('attendance.')->group(function () {
    Route::get('class/{classId}', [AttendanceController::class, 'showClassAttendance'])->name('class.show');
    Route::post('class/{classId}', [AttendanceController::class, 'storeAttendance'])->name('class.store');
    Route::get('student/{studentId}/monthly-summary', [AttendanceController::class, 'studentMonthlySummary'])->name('student.monthly_summary');
});

// 🟣 لوحة تحكم المدرس وكل ما يخص المدرس
Route::prefix('teachers/{teacher}')->name('teachers.')->group(function () {

    // لوحة التحكم
    Route::get('/dashboard', [TeachersController::class, 'dashboard'])->name('dashboard');

    
    // المجموعات
    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/', [GroupController::class, 'index'])->name('index');
        Route::get('/create', [GroupController::class, 'create'])->name('create');
        Route::post('/', [GroupController::class, 'store'])->name('store');
        Route::get('/{group}', [GroupController::class, 'show'])->name('show');
        Route::get('/{group}/edit', [GroupController::class, 'edit'])->name('edit');
        Route::put('/{group}', [GroupController::class, 'update'])->name('update');

        // نقل الطلاب
        Route::get('{sourceGroup}/transfer', [GroupController::class, 'transferForm'])->name('transfer.form');
        Route::post('{sourceGroup}/transfer', [GroupController::class, 'transfer'])->name('transfer');

        // إضافة طالب
        Route::get('{group}/add-student', [GroupController::class, 'showAddStudentForm'])->name('add-student.form');
        Route::post('{group}/add-student', [GroupController::class, 'addStudentToGroup'])->name('add-student');

        // حضور المجموعة
        Route::get('{group}/attendance', [AttendanceController::class, 'groupAttendance'])->name('attendance.index');
        Route::post('{group}/attendance', [AttendanceController::class, 'storeForGroup'])->name('attendance.store');
    });

    // الطلاب
    Route::resource('students', TeacherStudentController::class);

    // المواد
    Route::resource('subjects', SubjectController::class);

    // المحاضرات
    Route::prefix('lectures')->name('lectures.')->group(function () {
        Route::get('/', [LectureController::class, 'index'])->name('index');
        Route::get('/create', [LectureController::class, 'create'])->name('create');
        Route::post('/', [LectureController::class, 'store'])->name('store');
        Route::post('/multiple', [LectureController::class, 'storeMultiple'])->name('storeMultiple');
        Route::get('/{lecture}/edit', [LectureController::class, 'edit'])->name('edit');
        Route::put('/{lecture}', [LectureController::class, 'update'])->name('update');
        Route::delete('/{lecture}', [LectureController::class, 'destroy'])->name('destroy');

        // حضور المحاضرات
        Route::get('/{lecture}/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('/{lecture}/attendance', [AttendanceController::class, 'storeForLecture'])->name('attendance.store');
        Route::get('/{lecture}/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
        Route::get('/{lecture}/attendance/{student}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
        Route::put('/{lecture}/attendance/{student}', [AttendanceController::class, 'update'])->name('attendance.update');
    });

    // عرض الطلاب وتقييماتهم
    Route::get('show-grades', [TeacherController::class, 'showGrades'])->name('showgrades');
        Route::get('/teacher/settings', [TeacherController::class, 'settings'])->name('teacher.settings');

    Route::get('attendance-overview', [TeachersController::class, 'showAttendance'])->name('attendance.overview');
    // إعدادات المدرس
});

// الدرجات
Route::resource('teachers.grades', GradeController::class);

// محاضرات اليوم للمدرس
Route::get('/teachers/{teacher}/today-lectures', [TeacherController::class, 'todayLectures'])
    ->name('teacher.today_lectures');



    

    Route::prefix('teachers/{teacher}/students')->name('teachers.students.')->group(function () {

    // عرض كل الطلاب
    Route::get('/', [TeacherController::class, 'showStudents'])->name('index');

    // إنشاء طالب جديد
    Route::get('/create', [TeacherController::class, 'createStudent'])->name('create');
    Route::post('/', [TeacherController::class, 'storeStudent'])->name('store');

    // عرض طالب معين
    Route::get('/{student}', [TeacherController::class, 'showStudent'])->name('show');

    // تعديل طالب
    Route::get('/{student}/edit', [TeacherController::class, 'editStudent'])->name('edit');
    Route::put('/{student}', [TeacherController::class, 'updateStudent'])->name('update');

    // حذف طالب
    Route::delete('/{student}', [TeacherController::class, 'destroyStudent'])->name('destroy');
});
require __DIR__ . '/api.php';
