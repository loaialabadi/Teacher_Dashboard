<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
  // app/Models/Teacher.php
protected $fillable = ['name', 'email', 'phone', 'subject_id'];

public function subject()
{
    return $this->belongsTo(Subject::class);
}

public function students()
{
    return $this->hasMany(Student::class);
}

protected static function booted()
{
    static::deleting(function ($teacher) {
        $teacher->students()->delete();
    });
}

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

  public function groups()
{
    return $this->hasMany(Group::class);
}



}
