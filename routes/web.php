<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('aura.home');
});

Auth::routes(['register' => false]);

Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return redirect('/admin');
    });

    Route::get('/admin', function () {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Akses khusus admin.');
        }

        return view('admin.dashboard');
    });
});
