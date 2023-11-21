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

Route::get('/{any}', function () {
    if (strpos($_SERVER['REQUEST_URI'], 'admin') !== false) {
        return view('welcome', ['display_type' => "portal"]);
    } else {
        return view('welcome', ['display_type' => "front"]);
    }
})->where('any', '.*');


date_default_timezone_set('Asia/Manila');
