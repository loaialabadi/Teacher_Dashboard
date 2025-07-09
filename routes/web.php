<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\TeachersController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SchoolGradeController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\LectureController;

Route::get('/', function () {
    return view('welcome');
});

// صفحة لوحة التحكم الرئيسية مع حماية middleware auth & verified


    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // موارد CRUD للمعلمين، الطلاب، أولياء الأمور، والفصول
    Route::resource('teachers', TeachersController::class);
    Route::resource('students', StudentController::class);
    Route::resource('parents', ParentController::class);
    Route::resource('classes', ClassController::class)->only(['index', 'create', 'store']);

    // البروفايل
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // الحضور
    Route::get('/attendance/class/{classId}', [AttendanceController::class, 'showClassAttendance'])->name('attendance.show');
    Route::post('/attendance/class/{classId}', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');

    Route::get('/attendance/student/{studentId}/monthly-summary', [AttendanceController::class, 'studentMonthlySummary'])->name('attendance.monthly_summary');

    // لوحة تحكم المعلم الخاصة
    Route::get('/teacher-dashboard/{teacher}', [TeachersController::class, 'dashboard'])->name('teachers.dashboard');

    // مسارات خاصة بالمعلم: المجموعات، الحصص، الطلاب، الحضور
    Route::prefix('teachers/{teacher}')->group(function () {

        // المجموعات
        Route::get('/groups', [GroupController::class, 'showGroups'])->name('groups.index');
        Route::get('/groups/create', [GroupController::class, 'createGroup'])->name('groups.create');
        Route::post('/groups/store', [GroupController::class, 'storeGroup'])->name('groups.store');

        // الحصص
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');

        // عرض الطلاب
        Route::get('/showstudents', [TeacherController::class, 'showStudents'])->name('teachers.showstudents');
Route::get('/show-grades', [TeacherController::class, 'showGrades'])->name('teachers.showgrades');
        // الحضور الخاص بالمعلم
        Route::get('/attendance', [TeachersController::class, 'showAttendance'])->name('teachers.showattendance');
    });



    // تسجيل حضور الحصة
    Route::get('appointments/{appointment}/attendance', [AttendanceController::class, 'markAttendanceForm'])->name('attendance.mark');
    Route::post('appointments/{appointment}/attendance', [AttendanceController::class, 'saveAttendance'])->name('attendance.save');

    // صفحة جدول الحصص والمجموعات لطالب معين
    Route::get('/students/{student}/schedule-groups', [StudentController::class, 'scheduleAndGroups'])->name('students.schedule-groups');



  

// إنشاء حصة جديدة في مجموعة معينة (افترض أنك تملك هذا الراوت مسبقًا)
Route::get('teachers/{teacher}/groups/{group}/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('teachers/{teacher}/groups/{group}/appointments', [AppointmentController::class, 'store'])->name('appointments.store');



Route::get('teachers/{teacher}/groups/{sourceGroup}/transfer-students', [GroupController::class, 'showTransferForm'])->name('groups.transferForm');

Route::post('teachers/{teacher}/groups/{sourceGroup}/transfer-students', [GroupController::class, 'transferStudents'])->name('groups.transferStudents');
    // نموذج إضافة طالب جديد للمجموعة
Route::get('teachers/{teacher}/groups/{group}/add-student', [GroupController::class, 'addStudentForm'])->name('groups.addStudentForm');

// حفظ الطالب الجديد في المجموعة
Route::post('teachers/{teacher}/groups/{group}/add-student', [GroupController::class, 'addStudentStore'])->name('groups.addStudentStore');

  Route::get('teachers/{teacher}/groups/{group}', [GroupController::class, 'show'])->name('groups.show');




Route::prefix('teachers/{teacher}')->group(function () {
    Route::resource('students', StudentController::class);
});


// Route::resource('grades', GradeController::class);

Route::prefix('teachers/{teacher}')->group(function () {
    Route::resource('grades', GradeController::class);
});


Route::get('/teachers/{teacher}/subjects', [SubjectController::class, 'index'])->name('subjects.index');
Route::get('/teachers/{teacher}/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
Route::post('/teachers/{teacher}/subjects', [SubjectController::class, 'store'])->name('subjects.store');
Route::get('/teachers/{teacher}/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
Route::put('/teachers/{teacher}/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
Route::delete('/teachers/{teacher}/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');




Route::prefix('teachers/{teacher}/lectures')->controller(LectureController::class)->group(function () {
    Route::get('/', 'index')->name('lectures.index');
    Route::get('/create', 'create')->name('lectures.create');
    Route::post('/', 'store')->name('lectures.store');
    Route::get('/{lecture}/edit', 'edit')->name('lectures.edit');
    Route::put('/{lecture}', 'update')->name('lectures.update');
    Route::delete('/{lecture}', 'destroy')->name('lectures.destroy');

});





Route::prefix('teachers/{teacher}')->group(function () {
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
});


Route::resource('teachers.students', StudentController::class);

require __DIR__.'/auth.php';
require __DIR__.'/api.php';
