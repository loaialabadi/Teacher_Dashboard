<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class AppointmentScheduled extends Notification
{
    protected $appointment;

    public function __construct($appointment)
    {
        $this->appointment = $appointment;
    }

    public function via($notifiable)
    {
        return ['mail']; // أو 'database' أو حسب طريقة الإشعار المطلوبة
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('تم جدولة موعد جديد للطالب')
                    ->line('تم تحديد موعد جديد بتاريخ: ' . $this->appointment->appointment_date)
                    ->line('الوقت: ' . $this->appointment->appointment_time)
                    ->line('يرجى التأكد من حضور الطالب في الوقت المحدد.');
    }
}
