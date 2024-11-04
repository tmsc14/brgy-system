<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\BarangayCaptainController;
use App\Http\Controllers\Auth\BarangayRoleController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\BarangayResidentController;
use App\Http\Controllers\BarangayStaffController;
use App\Http\Controllers\BarangayOfficialController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\API\DocumentsController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\HomeController;
use App\Livewire\Announcements\AnnouncementProfile;
use App\Livewire\Announcements\Announcements;
use App\Livewire\Announcements\AnnouncementView;
use App\Livewire\BarangayInformation\AddBarangayOfficial;
use App\Livewire\BarangayInformation\BarangayInformation;
use App\Livewire\BarangayInformation\BarangayOfficialProfile;
use App\Livewire\BarangaySetup\BarangaySetup;
use App\Livewire\Customize\Customize;
use App\Livewire\Home\Home;
use App\Livewire\Household\AddResident;
use App\Livewire\Household\EditResident;
use App\Livewire\Household\Household;
use App\Livewire\Login\Login;
use App\Livewire\Login\LoginResident;
use App\Livewire\Login\LoginStaff;
use App\Livewire\Register\Register;
use App\Livewire\Register\RegisterBarangayCaptain;
use App\Livewire\Register\RegisterResident;
use App\Livewire\Register\RegisterStaff;
use App\Livewire\SignupRequests\History;
use App\Livewire\SignupRequests\SignupRequests;
use App\Livewire\Statistics\Statistics;

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
// Route::get('login/barangay-captain', [BarangayCaptainController::class, 'showLogin'])->name('barangay_captain.login');
// Route::post('login/barangay-captain', [BarangayCaptainController::class, 'login'])->name('barangay_captain.login.post');

// Barangay Captain Dashboard
Route::get('dashboard/barangay-captain', [BarangayCaptainController::class, 'showDashboard'])->name('barangay_captain.dashboard')->middleware('auth:barangay_captain');
Route::get('dashboard/barangay-captain/main', [BarangayCaptainController::class, 'showBcDashboard'])->name('bc-dashboard')->middleware('auth:barangay_captain');

//create barangay
Route::middleware(['auth:barangay_captain'])->group(function () {
    // Route::get('barangay-captain/create-barangay-info', [BarangayCaptainController::class, 'showCreateBarangayInfo'])->name('barangay_captain.create_barangay_info_form');
    // Route::post('barangay-captain/create-barangay-info', [BarangayCaptainController::class, 'createBarangayInfo'])->name('barangay_captain.create_barangay_info');

    // Route::get('barangay-captain/appearance-settings', [BarangayCaptainController::class, 'showAppearanceSettings'])->name('barangay_captain.appearance_settings');
    // Route::post('barangay-captain/appearance-settings', [BarangayCaptainController::class, 'saveAppearanceSettings'])->name('barangay_captain.appearance_settings.post');

    // Route::get('barangay-captain/features-settings', [BarangayCaptainController::class, 'showFeaturesSettings'])->name('barangay_captain.features_settings');
    // Route::post('barangay-captain/features-settings', [BarangayCaptainController::class, 'saveFeaturesSettings'])->name('barangay_captain.features_settings.post');

    // Route::get('/customize-barangay', [BarangayCaptainController::class, 'showCustomizeBarangay'])->name('barangay_captain.customize_barangay');
    // //bc-statistics
    // Route::get('/barangay-captain/statistics', [BarangayCaptainController::class, 'showCaptainStatistics'])->name('barangay_captain.statistics');
    // //bc-admins
    // Route::get('barangay-captain/admins', [BarangayCaptainController::class, 'showAdmins'])->name('barangay_captain.admins');
    // Route::post('barangay-captain/toggle-role-status/{roleId}', [BarangayCaptainController::class, 'toggleRoleStatus'])
    // ->name('barangay_captain.toggle_role_status');

});

// Routes for accessing through the dashboard's sidebar
Route::prefix('barangay-captain')->middleware(['auth:barangay_captain'])->group(function () {
    Route::get('dashboard/create-barangay-info', [BarangayCaptainController::class, 'showCreateBarangayDashboard'])->name('bc-dashboard-create-barangay-info');
    Route::get('dashboard/appearance-settings', [BarangayCaptainController::class, 'showAppearanceSettingsDashboard'])->name('bc-dashboard-appearance-settings');
    Route::get('dashboard/features-settings', [BarangayCaptainController::class, 'showFeaturesSettingsDashboard'])->name('bc-dashboard-features-settings');
});

// Logout
Route::post('logout', [BarangayCaptainController::class, 'logout'])->name('logout');

// Unified signup
Route::get('/auth/select-role', [BarangayRoleController::class, 'showSelectRole'])->name('barangay_roles.showSelectRole');
Route::post('/auth/select-role', [BarangayRoleController::class, 'selectRole'])->name('barangay_roles.selectRole');

Route::get('/auth/find-barangay', [BarangayRoleController::class, 'showFindBarangay'])->name('barangay_roles.showFindBarangay');
Route::post('/auth/find-barangay', [BarangayRoleController::class, 'findBarangay'])->name('barangay_roles.findBarangay');

Route::get('/auth/user-details', [BarangayRoleController::class, 'showUserDetails'])->name('barangay_roles.showUserDetails');
Route::post('/auth/user-details', [BarangayRoleController::class, 'userDetails'])->name('barangay_roles.userDetails');

Route::middleware(['ensureSignupFlow'])->group(function () {
    Route::get('/auth/account-details', [BarangayRoleController::class, 'showAccountDetails'])->name('barangay_roles.showAccountDetails');
    Route::post('/auth/account-details', [BarangayRoleController::class, 'accountDetails'])->name('barangay_roles.accountDetails');
});

// Unified login
Route::get('/auth/login', [BarangayRoleController::class, 'showUnifiedLogin'])->name('barangay_roles.showUnifiedLogin');
Route::post('/auth/login', [BarangayRoleController::class, 'unifiedLogin'])->name('barangay_roles.unifiedLogin');

Route::middleware(['auth:barangay_official'])->group(function () {
    Route::get('dashboard/barangay_official', [BarangayRoleController::class, 'showBarangayOfficialDashboard'])->name('barangay_official.dashboard');
    Route::get('documents/barangay_official', [DocumentsController::class, 'showBarangayOfficialDocuments'])->name('barangay_official.documents');
    Route::get('documents/barangay_official/requests', [DocumentsController::class, 'listDocumentRequests'])->name('barangay_official.documents.list');
    Route::get('documents/barangay_official/certificate_of_residency/preview/{id}', [DocumentsController::class, 'previewCertificateOfResidencyForBarangayOfficial'])->name('barangay_official.documents.preview');
    Route::get('documents/barangay_official/certificate_of_residency/print/{id}', [DocumentsController::class, 'generatePdfCertificateOfResidencyForBarangayOfficial'])->name('barangay_official.documents.print');
});

Route::middleware(['auth:barangay_staff'])->group(function () {
    Route::get('dashboard/barangay_staff', [BarangayRoleController::class, 'showStaffDashboard'])->name('barangay_staff.dashboard');
});

Route::middleware(['auth:barangay_resident'])->group(function () {
    Route::get('dashboard/barangay_resident', [BarangayRoleController::class, 'showResidentDashboard'])->name('barangay_resident.dashboard');
    Route::get('documents/request', [DocumentsController::class, 'listDocumentRequestTypes'])->name('barangay_resident.documentrequests.types');
    Route::get('documents/request/certificate_of_residency', [DocumentsController::class, 'previewCertificateOfResidency'])->name('barangay_resident.documentrequests.certificate_of_residency');
    Route::get('documents/request/certificate_of_residency/success', [DocumentsController::class, 'showCertificateOfResidencyRequestSuccess'])->name('barangay_resident.documentrequests.certificate_of_residency.success');
    Route::get('documents/request/certificate_of_indigency', [DocumentsController::class, 'listDocumentRequestTypes'])->name('barangay_resident.documentrequests.certificate_of_indigency');
    Route::get('documents/request/barangay_clearance', [DocumentsController::class, 'listDocumentRequestTypes'])->name('barangay_resident.documentrequests.barangay_clearance');
    Route::get('documents/request/business_permit', [DocumentsController::class, 'listDocumentRequestTypes'])->name('barangay_resident.documentrequests.business_permit');
    Route::get('documents/request/barangay_id', [DocumentsController::class, 'listDocumentRequestTypes'])->name('barangay_resident.documentrequests.barangay_id');
    Route::get('documents/request/death_certificate', [DocumentsController::class, 'listDocumentRequestTypes'])->name('barangay_resident.documentrequests.death_certificate');

    // API for documents
    Route::post('/api/document', [DocumentsController::class, 'createDocumentRequest']);
});


// API (find barangay)
Route::get('/api/provinces', [BarangayRoleController::class, 'getProvinces']);
Route::get('/api/cities', [BarangayRoleController::class, 'getCities']);
Route::get('/api/barangays', [BarangayRoleController::class, 'getBarangays']);

// Request page (barangay_captain)
Route::prefix('barangay-captain')->middleware(['auth:barangay_captain'])->group(function () {
    Route::get('requests', [BarangayCaptainController::class, 'showRequests'])->name('bc-requests');
    Route::post('requests/approve/{id}', [BarangayCaptainController::class, 'approveRequest'])->name('bc-requests.approve');
    Route::post('requests/deny/{id}', [BarangayCaptainController::class, 'denyRequest'])->name('bc-requests.deny');
    Route::get('requests/history', [BarangayCaptainController::class, 'showRequestHistory'])->name('bc-request-history');

});

//Settings routes
Route::get('barangay-captain/settings', [BarangayCaptainController::class, 'showSettings'])->name('barangay_captain.settings')->middleware('auth:barangay_captain');
Route::get('barangay-captain/settings/turnover', [BarangayCaptainController::class, 'showTurnover'])->name('barangay_captain.show_turnover')->middleware('auth:barangay_captain');
Route::post('/barangay-captain/initiate-turnover', [BarangayCaptainController::class, 'initiateTurnover'])->name('barangay_captain.initiate_turnover');
Route::get('/barangay-captain/pending-turnover', [BarangayCaptainController::class, 'showPendingTurnover'])->name('barangay_captain.pending_turnover');

//notifications
Route::post('/clear-notifications', [NotificationController::class, 'clearNotifications'])->name('clear-notifications');

//household management
Route::middleware(['auth:barangay_resident'])->group(function () {
    Route::get('/settings/households', [BarangayResidentController::class, 'index'])->name('households.index');
    Route::get('/settings/households/create', [BarangayResidentController::class, 'create'])->name('households.create');
    Route::post('/settings/households', [BarangayResidentController::class, 'store'])->name('households.store');
});

// For Barangay Staff Statistics
Route::middleware(['auth:barangay_staff'])->group(function () {
    Route::get('/barangay_staff/statistics', [BarangayStaffController::class, 'showStaffStatistics'])->name('barangay_staff.statistics');
});

// For Barangay Official Statistics
Route::middleware(['auth:barangay_official'])->group(function(){
    Route::get('/barangay-official/statistics', [BarangayOfficialController::class, 'showOfficialStatistics'])->name('barangay_official.statistics');
});

//Mails
Route::get('/send-test-email', function() {
    \Mail::to('ctereemari@gmail.com')->send(new \App\Mail\TestEmail());
    return 'Test email sent!';
});

// NEW ROUTES BY REFACTOR
// Home
Route::middleware(['auth'])->group(function(){
    Route::get('/home', Home::class)->name('dashboard');

    Route::get('documents', Home::class)->name('documents');

    Route::get('barangay-information', BarangayInformation::class)->name('barangay-information');
    Route::get('barangay-information/barangay-official/{id?}', BarangayOfficialProfile::class)->name('barangay-information.barangay-official-profile');

    Route::get('announcements', Announcements::class)->name('announcements');
    Route::get('announcements/view/{id}', AnnouncementView::class)->name('announcements.view');
    Route::get('announcements/profile/{id?}', AnnouncementProfile::class)->name('announcements.profile');
    
    Route::get('settings', Home::class)->name('settings');

    Route::get('admins', Home::class)->name('admins');

    Route::get('statistics', Statistics::class)->name('statistics');

    Route::get('customize', Customize::class)->name('customize');

    Route::get('household', Household::class)->name('household');
    Route::get('household/resident', AddResident::class)->name('household.add-resident');
    Route::get('household/resident/{id}', EditResident::class)->name('household.edit-resident');
});

Route::get('register/staff', RegisterStaff::class)->name('register.staff');
Route::get('register/resident', RegisterResident::class)->name('register.resident');
Route::get('register/barangay-captain', RegisterBarangayCaptain::class)->name('register.barangay-captain');

Route::get('login/{role}', Login::class)->name('login');

//Barangay Setup
Route::middleware(['auth', 'role:captain'])->group(function ()
{
    Route::get('photos/{barangayId}/validIds/{role}/{userId}/{fileName}', [FileController::class, 'getValidIdPhoto']);

    Route::get('requests', SignupRequests::class)->name('requests');
    Route::get('requests/history', History::class)->name('requests.history');
    Route::post('requests/approve/{id}', [BarangayCaptainController::class, 'approveRequest'])->name('bc-requests.approve');
    Route::post('requests/deny/{id}', [BarangayCaptainController::class, 'denyRequest'])->name('bc-requests.deny');

    Route::get('barangay/setup', BarangaySetup::class)->name('barangay.setup');

    Route::get('barangay-captain/create-barangay-info', [BarangayCaptainController::class, 'showCreateBarangayInfo'])->name('barangay_captain.create_barangay_info_form');
    Route::post('barangay-captain/create-barangay-info', [BarangayCaptainController::class, 'createBarangayInfo'])->name('barangay_captain.create_barangay_info');

    Route::get('barangay-captain/appearance-settings', [BarangayCaptainController::class, 'showAppearanceSettings'])->name('barangay_captain.appearance_settings');
    Route::post('barangay-captain/appearance-settings', [BarangayCaptainController::class, 'saveAppearanceSettings'])->name('barangay_captain.appearance_settings.post');

    Route::get('barangay-captain/features-settings', [BarangayCaptainController::class, 'showFeaturesSettings'])->name('barangay_captain.features_settings');
    Route::post('barangay-captain/features-settings', [BarangayCaptainController::class, 'saveFeaturesSettings'])->name('barangay_captain.features_settings.post');

    Route::get('/customize-barangay', [BarangayCaptainController::class, 'showCustomizeBarangay'])->name('barangay_captain.customize_barangay');
    //bc-statistics
    Route::get('/barangay-captain/statistics', [BarangayCaptainController::class, 'showCaptainStatistics'])->name('barangay_captain.statistics');
    //bc-admins
    Route::get('barangay-captain/admins', [BarangayCaptainController::class, 'showAdmins'])->name('barangay_captain.admins');
    Route::post('barangay-captain/toggle-role-status/{roleId}', [BarangayCaptainController::class, 'toggleRoleStatus'])
        ->name('barangay_captain.toggle_role_status');
});
