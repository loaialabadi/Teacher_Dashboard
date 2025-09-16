<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// App/Models/Quiz.php
class Quiz extends Model
{
    protected $fillable = ['teacher_id', 'group_id', 'title', 'description', 'quiz_date'];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function results()
    {
        return $this->hasMany(QuizResult::class);
    }
}
