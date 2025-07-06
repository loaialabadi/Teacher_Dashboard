<?php

namespace App\Models;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subject extends Model
{
 use HasFactory;  // تأكد من إضافة هذه الس
public function teachers()
{
    return $this->hasMany(Teacher::class);
}

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    
}
