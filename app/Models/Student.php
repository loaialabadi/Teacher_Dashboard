<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // استخدم Authenticatable للمصادقة
use Laravel\Sanctum\HasApiTokens;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\ParentModel;
use App\Models\Grade;
class Student extends Authenticatable
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['name', 'phone', 'password', 'teacher_id', 'parent_id'];

    protected $hidden = ['password'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }


public function parent()
{
    return $this->belongsTo(ParentModel::class, 'parent_id'); // أو 'parent_id' حسب العمود
}


    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

        public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_student');
    }

public function group()
{
    return $this->belongsTo(Group::class);
}
public function lectures()
{
    return $this->belongsToMany(Lecture::class, 'lecture_student');
}


public function appointments()
{
    return $this->hasMany(Appointment::class);
}


// Student.php
public function grade()
{
    return $this->belongsTo(SchoolGrade::class, 'school_grade_id');
}


public function subject()
{
    return $this->belongsTo(Subject::class);
}








// في موديل Student
public function studentTeacher()
{
    return $this->hasMany(StudentTeacher::class, 'student_id');
}






public function groupStudents()
{
    return $this->hasMany(GroupStudent::class);
}

public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'student_teacher')
                ->withPivot('subject_id')
                ->withTimestamps();
}



public function grades()
{
    return $this->belongsToMany(Grade::class, 'student_grade'); // مثال
}


}

