<?php

namespace App\Models;
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $table = 'attendances';

protected $fillable = ['lecture_id', 'student_id', 'status'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

       public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }


    // ...

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }

}


