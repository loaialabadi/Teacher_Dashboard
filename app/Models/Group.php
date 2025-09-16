<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Group extends Model
{
        use HasFactory;

protected $fillable = [
    'name',
    'teacher_id',
    'subject_id',
    'grade_id',
];


    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

        public function students()
    {
        return $this->belongsToMany(Student::class, 'group_student');
    }


public function schoolGrade()
{
    return $this->belongsTo(SchoolGrade::class, 'grade_id');  // أو 'school_grade_id'
}

public function lectures()
{
    return $this->hasMany(Lecture::class);
}

public function subject()
{
    return $this->belongsTo(Subject::class);
}

public function grade()
{
    return $this->belongsTo(Grade::class);
}


}

