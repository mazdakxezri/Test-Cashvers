<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('FetchOffers:cron')->everyFifteenMinutes();
Schedule::command('app:distribute-leaderboard')->daily();
Schedule::command('process-queue')->everyMinute();
