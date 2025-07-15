<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Carbon\Carbon;

class Lecture extends Model
{
      use HasFactory;

    protected $fillable = [
        'group_id', 'title', 'description', 'start_time', 'end_time','teacher_id', 'subject_id'
    ];




    public function getStartTimeFormattedAttribute()
    {
        return Carbon::parse($this->start_time)->format('H:i');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function group()
{
    return $this->belongsTo(Group::class);
}

public function students()
{
    return $this->belongsToMany(Student::class, 'lecture_student');
}

// app/Models/Lecture.php
public function subject()
{
    return $this->belongsTo(Subject::class);
}


}
