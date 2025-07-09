<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Subject;


class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades'; // اسم الجدول الصحيح

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'grade_teacher');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'grade_student');
    }
        public function subject()
    {
        // إذا العلاقة One-to-One أو Many-to-One
        // مثلاً كل فصل دراسي (Grade) مرتبط بمادة واحدة (Subject)
        return $this->belongsTo(Subject::class);
    }
}
