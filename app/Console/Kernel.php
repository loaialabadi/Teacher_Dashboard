<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * قائمة الأوامر التي يجب تسجيلها.
     *
     * @var array
     */
    protected $commands = [
        // أضف هنا الأوامر المخصصة إذا كنت بحاجة لذلك.
    ];

    /**
     * قم بتحديد جدول المهام.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // مثال: تشغيل مهمة يومية كل منتصف الليل.
        $schedule->command('inspire')->hourly();
    }

    /**
     * قم بتسجيل المهام التي يجب تشغيلها.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    protected $routeMiddleware = [
    // Middleware موجودة بالفعل
    'role' => \App\Http\Middleware\RoleMiddleware::class,
];
}
