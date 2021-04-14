<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/users', [UserController::class, 'index']);
Route::middleware(['auth:sanctum', 'verified'])->get('/selected_user_messages/{id}', [MessageController::class, 'show']);
Route::middleware(['auth:sanctum', 'verified'])->post('/send_message/{selectedUserId}', [MessageController::class, 'store']);
Route::middleware(['auth:sanctum', 'verified'])->post('/set_messages_as_read', [MessageController::class, 'messageIsRead']);
