<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShortenController;

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

Route::get('/', [ShortenController::class, 'index']);
Route::get('/top', [ShortenController::class, 'top']);
Route::get('/{shortURL}', [ShortenController::class, 'map']);

Route::post('/shorten', [ShortenController::class, 'shorten']);

