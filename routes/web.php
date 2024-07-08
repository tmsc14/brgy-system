<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangayCaptainController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [BarangayCaptainController::class, 'showStep1'])->name('register.step1');
Route::post('/register-step1', [BarangayCaptainController::class, 'postStep1'])->name('register.postStep1');

Route::get('/register-step2', [BarangayCaptainController::class, 'showStep2'])->name('register.step2');
Route::post('/register-step2', [BarangayCaptainController::class, 'postStep2'])->name('register.postStep2');

Route::get('/register-step3', [BarangayCaptainController::class, 'showStep3'])->name('register.step3');
Route::post('/register-step3', [BarangayCaptainController::class, 'postStep3'])->name('register.postStep3');