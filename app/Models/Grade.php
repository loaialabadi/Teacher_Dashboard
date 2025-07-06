<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'grade_teacher');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'grade_student');
    }
}