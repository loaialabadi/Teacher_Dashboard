<?php
namespace App\Models;
use App\Notifications\AppointmentScheduled;
use App\Models\Group;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Appointment extends Model
{
        use HasFactory;

protected $casts = [
    'scheduled_at' => 'datetime',
];

    protected $fillable = ['teacher_id', 'student_id', 'appointment_date', 'appointment_time'];

    public function teacher() {
        return $this->belongsTo(Teacher::class);
    }

    public function student() {
        return $this->belongsTo(Student::class);
    }

    public function group()
{
    return $this->belongsTo(Group::class);
}

}
