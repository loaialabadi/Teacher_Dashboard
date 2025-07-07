<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GradeTeacher extends Model
{
    use HasFactory;

    protected $table = 'grade_teacher'; // اسم الجدول بدون شرطات، واحرص أن يتطابق مع اسم جدولك في قاعدة البيانات

    protected $fillable = ['teacher_id', 'grade_id']; // غيرت school_class_id إلى grade_id لتتطابق مع التسمية الجديدة
}
