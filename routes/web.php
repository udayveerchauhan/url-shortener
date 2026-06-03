<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ShortUrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::resource('short-urls', ShortUrlController::class)
        ->except(['show', 'edit', 'update']);

    Route::resource('invitations', InvitationController::class)
        ->only(['index', 'create', 'store']);
});

Route::get('/s/{code}', [ShortUrlController::class, 'redirect'])->middleware('auth')->name('short-urls.redirect');
