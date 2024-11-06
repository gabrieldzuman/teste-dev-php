<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command(signature: 'inspire', callback: function (): void {
    $this->comment(Inspiring::quote());
})->purpose(description: 'Display an inspiring quote')->hourly();
