<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SchoolGradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\StudentAllsController;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// لوحة تحكم الأدمن
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/students/all', [StudentAllsController::class, 'index'])->name('students.all');

Route::get('/teacher/{teacher}/settings', [TeacherController::class, 'settings'])->name('teacher.settings');

// موارد أساسية: المعلمين، الطلاب، أولياء الأمور، الفصول
Route::resource('teachers', TeachersController::class);
Route::resource('students', StudentController::class);
Route::resource('parents', ParentController::class);
Route::resource('classes', ClassController::class)->only(['index', 'create', 'store']);

// البروفايل الشخصي
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

// الحضور للفصول والطلاب
Route::get('/attendance/class/{classId}', [AttendanceController::class, 'showClassAttendance'])->name('attendance.show');
Route::post('/attendance/class/{classId}', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');
Route::get('/attendance/student/{studentId}/monthly-summary', [AttendanceController::class, 'studentMonthlySummary'])->name('attendance.monthly_summary');

// جدول الحصص والمجموعات لطالب معين
Route::get('/students/{student}/schedule-groups', [StudentController::class, 'scheduleAndGroups'])->name('students.schedule-groups');

// تسجيل حضور الحصة
Route::get('appointments/{appointment}/attendance', [AttendanceController::class, 'markAttendanceForm'])->name('attendance.mark');
Route::post('appointments/{appointment}/attendance', [AttendanceController::class, 'saveAttendance'])->name('attendance.save');


Route::get('/teacher/{teacher}', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');

// كل ما يخص المدرس بمجموعاته وطلابه ودرجاته ومحاضراته داخل Prefix واحد
Route::prefix('teachers/{teacher}')->group(function () {

    // لوحة تحكم المدرس
    Route::get('/dashboard', [TeachersController::class, 'dashboard'])->name('teachers.dashboard');

    // المجموعات
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/create-old', [GroupController::class, 'createGroup'])->name('groups.create.old'); // نسخة قديمة للتوافق
    Route::post('/groups/store-old', [GroupController::class, 'storeGroup'])->name('groups.store.old');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');

    // تحويل الطلاب بين المجموعات
    Route::get('/groups/{sourceGroup}/transfer', [GroupController::class, 'transferForm'])->name('groups.transferForm');
    Route::post('/groups/{sourceGroup}/transfer', [GroupController::class, 'transfer'])->name('groups.transfer');
    Route::get('/groups/{sourceGroup}/transfer-students', [GroupController::class, 'showTransferForm'])->name('groups.transferForm.old');
    Route::post('/groups/{sourceGroup}/transfer-students', [GroupController::class, 'transferStudents'])->name('groups.transferStudents');

    // إضافة طالب لمجموعة
    Route::get('/groups/{group}/add-student', [GroupController::class, 'addStudentForm'])->name('groups.addStudentForm');
    Route::post('/groups/{group}/add-student', [GroupController::class, 'addStudentStore'])->name('groups.addStudentStore');
    Route::get('/groups/{group}/add-student-form', [GroupController::class, 'showAddStudentForm'])->name('groups.add-student.form');
    Route::post('/groups/{group}/add-student-to-group', [GroupController::class, 'addStudentToGroup'])->name('groups.add-student');

    // الطلاب
    Route::resource('students', StudentController::class);




    // المواد
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    // الحصص
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/groups/{group}/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create.group');
    Route::post('/groups/{group}/appointments', [AppointmentController::class, 'store'])->name('appointments.store.group');

    // عرض الطلاب وتقييماتهم
    Route::get('/showstudents', [TeacherController::class, 'showStudents'])->name('teachers.showstudents');
    Route::get('/show-grades', [TeacherController::class, 'showGrades'])->name('teachers.showgrades');

    // عرض الحضور
    Route::get('/attendance', [TeachersController::class, 'showAttendance'])->name('teachers.showattendance');

    // المحاضرات
    Route::prefix('lectures')->controller(LectureController::class)->group(function () {
        Route::get('/', 'index')->name('lectures.index');
        Route::get('/create', 'create')->name('lectures.create');
        Route::post('/', 'store')->name('lectures.store');
        Route::get('/{lecture}/edit', 'edit')->name('lectures.edit');
        Route::put('/{lecture}', 'update')->name('lectures.update');
        Route::delete('/{lecture}', 'destroy')->name('lectures.destroy');
    });

    // إضافة محاضرات متعددة
    Route::post('/lectures/multiple', [LectureController::class, 'storeMultiple'])->name('lectures.storeMultiple');
});





 

Route::get('/teachers/{teacher}/grades/create', [GradeController::class, 'create'])->name('grades.create');
Route::post('/teachers/{teacher}/grades', [GradeController::class, 'store'])->name('grades.store');
Route::get('/teachers/{teacher}/grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
Route::put('/teachers/{teacher}/grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
Route::delete('/teachers/{teacher}/grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
Route::get('/teachers/{teacher}/grades', [GradeController::class, 'index'])->name('grades.index');
Route::get('/teachers/{teacher}/grades/{grade}/students', [GradeController::class, 'showStudentsGradeTeacher'])->name('grades.showStudents');











Route::get('lectures/{lecture}/attendance/create', [AttendanceController::class, 'create'])->name('attendances.create');
Route::post('lectures/{lecture}/attendance', [AttendanceController::class, 'store'])->name('attendances.store');

// موارد العلاقة بين المدرس والطلاب
Route::resource('teachers.students', StudentController::class);







// routes/web.php

Route::prefix('teachers/{teacher}')->name('teachers.')->group(function () {
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');

    Route::get('groups/{group}/attendance', [AttendanceController::class, 'groupAttendance'])->name('groups.attendance.index');
    Route::post('groups/{group}/attendance', [AttendanceController::class, 'storeForGroup'])->name('groups.attendance.store');

    Route::get('lectures/{lecture}/attendance/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('lectures/{lecture}/attendance', [AttendanceController::class, 'storeForLecture'])->name('attendances.store');

    Route::get('lectures/{lecture}/attendance/report', [AttendanceController::class, 'report'])->name('attendances.report');
    Route::get('lectures/{lecture}/attendance/{student}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('lectures/{lecture}/attendance/{student}', [AttendanceController::class, 'update'])->name('attendances.update');
});



Route::get('/teachers/{teacher}/today-lectures', [TeacherController::class, 'todayLectures'])->name('teachers.attendance.today');


// تضمين ملفات الراوتات الإضافية
require __DIR__ . '/auth.php';
require __DIR__ . '/api.php';
