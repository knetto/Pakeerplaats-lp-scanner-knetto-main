<?php

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

Route::get('/', function () {
    return view('home');
});

Route::resource('parkeerplaats',App\Http\Controllers\licenseplateController::class);

Route::resource('parkeerplaatsGeschiedenis',App\Http\Controllers\licenseplateGeschiedenisController::class);

Route::resource('stats',App\Http\Controllers\statsController::class);

Route::resource('parkeerplaatsTeLang',App\Http\Controllers\parkeerplaatsTeLangController::class);


