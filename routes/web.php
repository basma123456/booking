<?php

use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/m',  function (){
    return view('calendar');
});

Route::get('/dashboard',  function (){
    return view('dashboard');
});

Route::get('/choose-date',  function (){
    return view('calendar2');
});


Route::post('hhhhhhhhhhh' ,[App\Http\Controllers\HomeController::class, 'mmm']);
Route::post('caculateTime' ,[App\Http\Controllers\HomeController::class, 'submitDate'])->name('submitDates.now');
Route::post('reserve-now/{fromDate}/{toDate}' ,[App\Http\Controllers\HomeController::class, 'reserveRoomNow'])->name('reserve.now');
