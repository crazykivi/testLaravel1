<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', [MainController::class, 'index'])->name('index');

// Маршрут для главной страницы
Route::get('/', [MainController::class, 'index'])->name('index');

// Маршрут для выбора города
Route::get('/{city}', [MainController::class, 'city'])->name('select-city');

// Маршрут для страницы "О нас"
Route::get('/about', [MainController::class, 'about'])->name('about');

// Маршрут для страницы "Новости"
Route::get('/news', [MainController::class, 'news'])->name('news');
