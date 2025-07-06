<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolClass extends Model
{
    protected $table = 'classes';

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
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function teachers()
{
    return $this->belongsToMany(Teacher::class, 'class_teacher');
}

}

