<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\BarangayCaptainController;

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

Route::get('register/barangay-captain/step1', [BarangayCaptainController::class, 'showStep1'])->name('barangay_captain.register.step1');
Route::post('register/barangay-captain/step1', [BarangayCaptainController::class, 'postStep1'])->name('barangay_captain.register.step1.post');

Route::get('register/barangay-captain/step2', [BarangayCaptainController::class, 'showStep2'])->name('barangay_captain.register.step2');
Route::post('register/barangay-captain/step2', [BarangayCaptainController::class, 'postStep2'])->name('barangay_captain.register.step2.post');

Route::get('register/barangay-captain/step3', [BarangayCaptainController::class, 'showStep3'])->name('barangay_captain.register.step3');
Route::post('register/barangay-captain/step3', [BarangayCaptainController::class, 'postStep3'])->name('barangay_captain.register.step3.post');

Route::get('barangay-captain/create-barangay', [BarangayCaptainController::class, 'showCreateBarangay'])->name('barangay_captain.create_barangay_form');
Route::post('barangay-captain/create-barangay', [BarangayCaptainController::class, 'createBarangay'])->name('barangay_captain.create_barangay');
