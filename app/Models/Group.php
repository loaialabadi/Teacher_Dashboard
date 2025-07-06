<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Group extends Model
{
        use HasFactory;

    protected $fillable = ['name', 'teacher_id'];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

        public function students()
    {
        return $this->belongsToMany(Student::class, 'group_student');
    }



}

