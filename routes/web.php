<?php

use App\Http\Controllers\CheckStatusBackupController;
use App\Http\Controllers\DownloadBackupController;
use App\Http\Controllers\RunManualFolderBackup;
use App\Http\Controllers\ServerController;
use App\Http\Controllers\ServerFolderController;
use Illuminate\Foundation\Application;
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


Route::resource('servers', ServerController::class)->middleware('auth');
Route::resource('servers.folders', ServerFolderController::class)->shallow()->middleware('auth');
Route::post('/folders/{folder}/backups/run', RunManualFolderBackup::class)->middleware('auth');
Route::get('/backups/{backup}/download', DownloadBackupController::class)->middleware('auth');
Route::post('/backups/{backup}/check', CheckStatusBackupController::class)->middleware('auth');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
