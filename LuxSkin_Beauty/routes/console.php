<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about-app', function () {
    $this->comment('LuxSkin Beauty is ready.');
})->purpose('Display a short application message');
