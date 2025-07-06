<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupStudent extends Model
{
    protected $table = 'group_student';

    protected $fillable = ['group_id', 'student_id'];
}
