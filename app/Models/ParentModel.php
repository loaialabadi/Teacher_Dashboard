<?php

namespace App\Models;
use App\Models\Student;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class ParentModel extends Model
{
    use HasFactory, Notifiable;
  // app/Models/ParentModel.php
protected $fillable = ['name', 'phone', 'password'];
    protected $table = 'parents';

public function students()
{
  
    return $this->hasMany(Student::class, 'parent_id');
}

}
