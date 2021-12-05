<?php

use App\Http\Controllers\DashboardController;
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

Route::redirect('/', '/works');

Route::resource('/works', WorksController::class)
    ->except(['edit']);
Route::post('/works/{work}/tags', [WorksController::class, 'addTag'])
    ->name('works.tags.add');
Route::delete('/works/{work}/tags/{tag}', [WorksController::class, 'removeTag'])
    ->name('works.tags.remove');

Route::resource('/tags', TagsController::class)
    ->only(['index']);

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

require __DIR__ . '/auth.php';
