<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LectureChange extends Model
{
    use HasFactory;

    protected $fillable = [
        'lecture_id',
        'old_date',
        'old_start_time',
        'old_end_time',
        'new_date',
        'new_start_time',
        'new_end_time',
        'reason',
    ];

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}
