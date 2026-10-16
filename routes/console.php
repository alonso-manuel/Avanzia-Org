<?php

use Illuminate\Support\Facades\Schedule;

// Hosting compartido: no hay worker permanente. El cron de cPanel ejecuta
// `php artisan schedule:run` cada minuto y esto vacía la cola en cada pasada.
Schedule::command('queue:work --stop-when-empty --max-time=50 --tries=3')
    ->everyMinute()
    ->withoutOverlapping();
