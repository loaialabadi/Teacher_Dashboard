<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\schoolGrades;  // تأكد من استيراد الكلاس الصحيح
class SchoolGrade extends Model  // كان ينقص كلمة 'extends' واسم الكلاس كان خاطئ
{
    use HasFactory;  // مهم جداً

protected $table = 'school_grades';

    protected $fillable = ['teacher_id', 'subject_id', 'date', 'start_time', 'end_time', 'description'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'class_id');  // تأكد أن عمود 'class_id' في جدول الحضور مرتبط هنا
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'class_teacher');
    }

    public function groups()
    {
        return $this->hasMany(Group::class, 'school_grade_id');  // تأكد من أن عمود 'Grade_id' في جدول المجموعات مرتبط هنا
    }

    public function schoolGrades()
{
    return $this->belongsToMany(SchoolGrade::class, 'grade_teacher', 'teacher_id', 'grade_id');
}

    
}
