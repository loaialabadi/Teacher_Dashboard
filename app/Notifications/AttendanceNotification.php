<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AttendanceNotification extends Notification
{
    use Queueable;

    protected $student;
    protected $class;

    public function __construct($student, $class)
    {
        $this->student = $student;
        $this->class = $class;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('إشعار حضور الحصة')
                    ->greeting('السلام عليكم')
                    ->line('تم تسجيل حضور ابنكم الطالب: ' . $this->student->name)
                    ->line('في الحصة الخاصة بالمادة: ' . $this->class->subject->name)
                    ->line('مع المعلم: ' . $this->class->teacher->name)
                    ->line('بتاريخ: ' . $this->class->date->format('Y-m-d') . ' من الساعة ' . $this->class->start_time . ' إلى ' . $this->class->end_time)
                    ->line('شكراً لتعاونكم.');
    }
}
