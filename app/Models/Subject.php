<?php

namespace App\Models;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
 use HasFactory;  // تأكد من إضافة هذه الس

    protected $fillable = ['name'];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    
public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'subject_teacher', 'subject_id', 'teacher_id');
}

}
