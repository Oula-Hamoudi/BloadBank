<?php

use App\Http\Controllers\BackendController;
use App\Http\Controllers\BloodRequestController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DonorController;

use App\Http\Controllers\FrontendController;

use App\Http\Controllers\SuperAdminController;
use App\Models\BloodRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Routing\RouteRegistrar;
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


Route::prefix('/')->group(function () {
    Route::controller(FrontendController::class)->group(function () {
        Route::get('/', 'index')->name('welcome');;

    });






});



Route::prefix('dashboard')->middleware(['auth','verified'])->group(function () {

    Route::controller(BackendController::class)->group(function () {
        Route::get('/', 'index')->name('dashboard');
    });
    //download pdf

    //managing admin add routes
    Route::controller(SuperAdminController::class)->group(function () {
        Route::get('/add-admins','userList')->name('userlist');
        Route::get('/add-admins/{id}/make-admin','makeAdmin')->name('makeadmin');
        Route::get('/add-admins/{id}/remove-admin','removeAdmin')->name('removeadmin');
        Route::get('/add-admins/{id}/make-superadmin','makeSuperAdmin')->name('makesuperadmin');
        Route::get('/add-admins/{id}/remove-superadmin','removeSuperAdmin')->name('removesuperadmin');
    });

    //managing profile settings routes
    Route::get('/myprofile',[DonorController::class,'profile'])->name('profile');
    Route::get('/myprofile/donation-status',[DonorController::class,'makeActive'])->name('donationStatusChange');
    Route::post('/myprofile/update',[DonorController::class,'update'])->name('profile.update');
    Route::post('/myprofile/donation',[DonorController::class,'donationStore'])->name('donation.update');
    Route::post('/myprofile/change-password',[ChangePasswordController::class,'store'])->name('change.password');

    Route::get('/events/req/pending',[EventController::class,'eventsPending'])->name('dashboard.events.pending');
    Route::get('/events/req/accept/{id}',[EventController::class,'approve'])->name('event-request-accept');
    Route::get('/events/req/decline/{id}',[EventController::class,'decline'])->name('event-request-decline');
    Route::get('/donor-req',[DonorController::class, 'pendingDonorsRequest'])->name('donor-request');
    Route::get('/donor-req/approve/{id}',[DonorController::class, 'acceptDonors'])->name('donor-request-accept');

    Route::patch('/donor-req/{id}/decline',[DonorController::class, 'rejectDonors'])->name('donor-request-decline');

    Route::get('/active-donor', [DonorController::class, 'activeDonors'])->name('active-donor');

    Route::controller(DonorController::class)->prefix('/donor/blood')->group(function () {
        Route::get('/all','list')->name('donor.list');
        Route::get('/donation-history','donationHistory')->name('donorhistory');
        Route::get('/events-histories','eventHistory')->name('eventhistory');
        Route::get('/requests', 'index')->name('donor-blood-reqs');
        Route::get('/requests/{id}/accept', 'accept')->name('donor-req-accept');
        Route::get('/requests/{id}/donated', 'donated')->name('donor-req-donated');
        Route::post('/requests/{id}/not-donated', 'notDonated')->name('donor-req-notdonated');
    });

    Route::controller(BloodRequestController::class)->group(function () {
        Route::get('/blood-req/not-approved', 'pending')->name('request.notApproved');
        Route::get('/blood-req/approve/{id}', 'approve')->name('blood-approve');
        Route::patch('/blood-req/reject/{id}', 'reject')->name('blood-reject');
        Route::get('/blood-req/assign/{bloodRequest}', 'assignIndex')->name('request-assign');
        Route::post('/blood-req/assign-donor/{bloodRequest}', 'assignDonor')->name('donor-assign');
        Route::get('/blood-req-all', 'allRequests')->name('blood-request-all');
        Route::get('/blood-req', 'create')->name('blood-req');
        Route::post('/blood-req', 'store')->name('blood-store');
        Route::get('/blood-req/{id}', 'show')->name('blood-view');
        Route::get('/blood-req/{id}/edit', 'edit')->name('blood-edit');
        Route::Patch('/blood-req/{bloodRequest}/update', 'update')->name('blood-update');
    });



});











require __DIR__ . '/auth.php';
