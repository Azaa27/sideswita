<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('apriori:calculate --scheduled')->dailyAt('01:00')->withoutOverlapping();

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
