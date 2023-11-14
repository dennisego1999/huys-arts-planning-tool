<?php

use App\Http\Controllers\DanceGroupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

    Route::name('translations.')->prefix('translations')->group(function () {
        Route::get('/', [TranslationController::class, 'index'])->name('index');
        Route::post('/scan', [TranslationController::class, 'scan'])->name('scan');
        Route::post('/import', [TranslationController::class, 'import'])->name('import');
        Route::get('/export', [TranslationController::class, 'export'])->name('export');
        Route::put('/{language_line}/update ', [TranslationController::class, 'update'])->name('update');
        Route::delete('/{language_line}/delete', [TranslationController::class, 'destroy'])->name('destroy');
    });
});
