<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\WorksController;
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

Route::redirect('/', '/works', 301);

Route::resource('/works', WorksController::class)
    ->except(['edit']);

Route::resource('/tags', TagsController::class)
    ->only(['index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

require __DIR__ . '/auth.php';
