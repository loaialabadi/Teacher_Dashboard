<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Lecture extends Model
{
      use HasFactory;

    protected $fillable = [
        'teacher_id', 'title', 'description', 'start_time', 'end_time'
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
