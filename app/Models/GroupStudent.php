<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Group;

class GroupStudent extends Model
{
    protected $table = 'group_student';

    protected $fillable = ['group_id', 'student_id'];

    // ✅ العلاقة مع الطالب
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // ✅ العلاقة مع المجموعةش
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
