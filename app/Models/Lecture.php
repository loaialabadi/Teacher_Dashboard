<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Lecture extends Model
{
      use HasFactory;

    protected $fillable = [
        'group_id', 'title', 'description', 'start_time', 'end_time'
    ];

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

}
