<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Grade;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
  // app/Models/Teacher.php
protected $fillable = ['name', 'email', 'phone', 'subject_id', 'user_id'];

public function subject()
{
    return $this->belongsTo(Subject::class);
}



public function students()
{
    return $this->belongsToMany(Student::class, 'student_teacher')
                ->withPivot(['subject_id', 'grade_id', 'group_id'])
                ->withTimestamps();
}


protected static function booted()
{
    static::deleting(function ($teacher) {
        $teacher->students()->delete();
    });
}

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }




  public function groups()
{
    return $this->hasMany(Group::class);
}

public function schoolGrades()
{
    return $this->belongsToMany(SchoolGrade::class, 'grade_teacher', 'teacher_id', 'grade_id');
}


public function subjects()
{
    return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
}


public function lectures()
{
    return $this->hasMany(Lecture::class);
}


public function grades()
{
    return $this->belongsToMany(Grade::class, 'grade_teacher', 'teacher_id', 'grade_id');
}


public function payments()
{
    return $this->hasMany(Payment::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}



}
