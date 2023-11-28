<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DanceGroupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\LanguageLineController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', HomeController::class)->name('home');

Route::fallback(fn() => Inertia::render('Errors/404'));

Route::middleware([
    'auth:web',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::impersonate();

    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/impersonate/{user}', ImpersonateController::class)->name('impersonate');
    Route::resource('users', UserController::class);
    Route::resource('dance-groups', DanceGroupController::class);
    Route::get('/calendar/{date?}', [CalendarController::class, 'index'])->name('calendar.index');
    Route::post('/calendar/create-event', [CalendarController::class, 'store'])->name('calendar.store');

    Route::name('translations.')->prefix('translations')->group(function () {
        Route::get('/', [LanguageLineController::class, 'index'])->name('index');
        Route::post('/scan', [LanguageLineController::class, 'scan'])->name('scan');
        Route::post('/import', [LanguageLineController::class, 'import'])->name('import');
        Route::get('/export', [LanguageLineController::class, 'export'])->name('export');
        Route::put('/{language_line}/update ', [LanguageLineController::class, 'update'])->name('update');
        Route::delete('/{language_line}/delete', [LanguageLineController::class, 'destroy'])->name('destroy');
    });

    Route::post('/notification/{notification}/read', [NotificationController::class, 'read'])->name('notification.read');
});
