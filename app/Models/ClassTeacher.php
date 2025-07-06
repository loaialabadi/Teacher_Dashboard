<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassTeacher extends Model
{
    use HasFactory;

    protected $table = 'class_teacher';

    protected $fillable = ['teacher_id', 'school_class_id'];
}
