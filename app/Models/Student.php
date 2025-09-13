<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // للمصادقة
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'password',
        'teacher_id',
        'parent_id',
        'subject_id',
        'school_grade_id',
        'group_id',
    ];

    protected $hidden = ['password'];

    /*
    |--------------------------------------------------------------------------
    | العلاقات الأساسية
    |--------------------------------------------------------------------------
    */

    // ولي الأمر
    public function parent()
    {
        return $this->belongsTo(ParentModel::class, 'parent_id');
    }

    // المادة الرئيسية
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // المرحلة/الفصل الدراسي
    public function grade()
    {
        return $this->belongsTo(SchoolGrade::class, 'school_grade_id');
    }

    // المجموعة الحالية
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /*
    |--------------------------------------------------------------------------
    | علاقات إضافية (حسب الحاجة)
    |--------------------------------------------------------------------------
    */

    // لو الطالب ممكن ياخد أكثر من مادة
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject');
    }

    // لو الطالب ممكن ينتمي لأكثر من مجموعة
public function groups()
{
    return $this->belongsToMany(Group::class, 'group_student')->with('teacher', 'subject');
}


    // علاقة مع المعلم الأساسي (إن وجد)
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    // لو الطالب ممكن يدرس مع أكثر من معلم

public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'student_teacher')
                ->withPivot(['subject_id', 'grade_id', 'group_id'])
                ->withTimestamps();
}

    // الحصص/المحاضرات
    public function lectures()
    {
        return $this->belongsToMany(Lecture::class, 'lecture_student');
    }

    // مواعيد خاصة بالطالب
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    // لو عندك جدول student_grade للربط بين الطلاب والفصول
    public function grades()
    {
        return $this->belongsToMany(Grade::class, 'student_grade');
    }

    public function studentTeacher()
    {
        return $this->hasMany(StudentTeacher::class, 'student_id');
    }

    public function payments()
{
    return $this->hasMany(Payment::class);
}



}
