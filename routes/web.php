<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\BarangayCaptainController;
use App\Http\Controllers\Auth\BarangayRoleController;
use App\Http\Controllers\API\LocationController;

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
})->name('home');

// Barangay Captain Sign up
Route::get('register/barangay-captain/step1', [BarangayCaptainController::class, 'showStep1'])->name('barangay_captain.register.step1');
Route::post('register/barangay-captain/step1', [BarangayCaptainController::class, 'postStep1'])->name('barangay_captain.register.step1.post');

Route::get('register/barangay-captain/step2', [BarangayCaptainController::class, 'showStep2'])->name('barangay_captain.register.step2');
Route::post('register/barangay-captain/step2', [BarangayCaptainController::class, 'postStep2'])->name('barangay_captain.register.step2.post');

Route::get('register/barangay-captain/step3', [BarangayCaptainController::class, 'showStep3'])->name('barangay_captain.register.step3');
Route::post('register/barangay-captain/step3', [BarangayCaptainController::class, 'postStep3'])->name('barangay_captain.register.step3.post');

// Barangay Captain Login
Route::get('login/barangay-captain', [BarangayCaptainController::class, 'showLogin'])->name('barangay_captain.login');
Route::post('login/barangay-captain', [BarangayCaptainController::class, 'login'])->name('barangay_captain.login.post');

// Barangay Captain Dashboard
Route::get('dashboard/barangay-captain', [BarangayCaptainController::class, 'showDashboard'])->name('barangay_captain.dashboard')->middleware('auth:barangay_captain');
Route::get('dashboard/barangay-captain/main', [BarangayCaptainController::class, 'showBcDashboard'])->name('bc-dashboard')->middleware('auth:barangay_captain');

// Barangay Captain -- Create Barangay Info
Route::get('barangay-captain/create-barangay-info', [BarangayCaptainController::class, 'showCreateBarangayInfo'])->name('barangay_captain.create_barangay_info_form');
Route::post('barangay-captain/create-barangay-info', [BarangayCaptainController::class, 'createBarangayInfo'])->name('barangay_captain.create_barangay_info');

// Appearance Settings
Route::get('barangay-captain/appearance-settings', [BarangayCaptainController::class, 'showAppearanceSettings'])->name('barangay_captain.appearance_settings');
Route::post('barangay-captain/appearance-settings', [BarangayCaptainController::class, 'saveAppearanceSettings'])->name('barangay_captain.appearance_settings.post');

// Features Settings
Route::get('barangay-captain/features-settings', [BarangayCaptainController::class, 'showFeaturesSettings'])->name('barangay_captain.features_settings');
Route::post('barangay-captain/features-settings', [BarangayCaptainController::class, 'saveFeaturesSettings'])->name('barangay_captain.features_settings.post');

// Logout
Route::post('logout', [BarangayCaptainController::class, 'logout'])->name('logout');

// Unified signup
Route::get('/auth/select-role', [BarangayRoleController::class, 'showSelectRole'])->name('barangay_roles.showSelectRole');
Route::post('/auth/select-role', [BarangayRoleController::class, 'selectRole'])->name('barangay_roles.selectRole');

Route::get('/auth/find-barangay', [BarangayRoleController::class, 'showFindBarangay'])->name('barangay_roles.showFindBarangay');
Route::post('/auth/find-barangay', [BarangayRoleController::class, 'findBarangay'])->name('barangay_roles.findBarangay');

Route::get('/auth/user-details', [BarangayRoleController::class, 'showUserDetails'])->name('barangay_roles.showUserDetails');
Route::post('/auth/user-details', [BarangayRoleController::class, 'userDetails'])->name('barangay_roles.userDetails');

Route::get('/auth/account-details', [BarangayRoleController::class, 'showAccountDetails'])->name('barangay_roles.showAccountDetails');
Route::post('/auth/account-details', [BarangayRoleController::class, 'accountDetails'])->name('barangay_roles.accountDetails');

// Unified login
Route::get('/auth/login', [BarangayRoleController::class, 'showUnifiedLogin'])->name('barangay_roles.showUnifiedLogin');
Route::post('/auth/login', [BarangayRoleController::class, 'unifiedLogin'])->name('barangay_roles.unifiedLogin');

Route::middleware(['auth:barangay_official'])->group(function () {
    Route::get('dashboard/barangay_official', [BarangayRoleController::class, 'showBarangayOfficialDashboard'])->name('barangay_official.dashboard');
});

Route::middleware(['auth:barangay_staff'])->group(function () {
    Route::get('dashboard/barangay_staff', [BarangayRoleController::class, 'showStaffDashboard'])->name('barangay_staff.dashboard');
});

Route::middleware(['auth:barangay_resident'])->group(function () {
    Route::get('dashboard/barangay_resident', [BarangayRoleController::class, 'showResidentDashboard'])->name('barangay_resident.dashboard');
});

// API (find barangay)
Route::get('/api/provinces', [BarangayRoleController::class, 'getProvinces']);
Route::get('/api/cities', [BarangayRoleController::class, 'getCities']);
Route::get('/api/barangays', [BarangayRoleController::class, 'getBarangays']);
