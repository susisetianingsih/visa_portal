<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\VendorController;

Route::group(['middleware' => 'user'], function () {
    // login
    Route::get('/', [AuthController::class, 'index'])->name('login');
    Route::post('/', [AuthController::class, 'login_store'])->name('login_post');
});

Route::group(['middleware' => 'auth'], function () {
    // logout
    Route::post('logout-visa-portal-halodoc-2024', [AuthController::class, 'destroy'])->name('logout');
});

// admin
Route::group(['middleware' => 'admin'], function () {
    // dashboard
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');

    // search user
    Route::get('admin/dashboard/search', [AdminController::class, 'searchUser'])->name('search_user');

    // user hapus 
    Route::delete('admin/dashboard/{id}', [AdminController::class, 'userDelete'])->name('user_delete');

    // user edit 
    Route::get('admin/dashboard/{id}', [AdminController::class, 'userUpdate'])->name('user_update');
    Route::put('admin/dashboard/{id}', [AdminController::class, 'userUpdatePost'])->name('user_update_post');

    // profile
    Route::get('admin/profile/', [AdminController::class, 'profile'])->name('admin_profile');
    Route::put('admin/profile/{id}', [AdminController::class, 'profilePost'])->name('admin_profile_post');

    // assessment
    Route::get('admin/assessment', [AdminController::class, 'assessment'])->name('admin_assessment');

    // search assessment
    Route::get('admin/assessment/search', [AdminController::class, 'searchAssessment'])->name('search_assessment');

    // assessment hapus 
    Route::delete('admin/assessment/{id}', [AdminController::class, 'assessmentDelete'])->name('assessment_delete');

    // assessment edit 
    Route::get('admin/assessment/{id}', [AdminController::class, 'assessmentUpdate'])->name('assessment_update');
    Route::put('admin/assessment/{id}', [AdminController::class, 'assessmentUpdatePost'])->name('assessment_update_post');

    // add assessment
    Route::get('admin/assessment-add', [AdminController::class, 'assessmentAdd'])->name('assessment_add');
    Route::post('admin/assessment-add', [AdminController::class, 'assessmentAddPost'])->name('assessment_add_post');

    // label
    Route::get('admin/label', [AdminController::class, 'label'])->name('admin_label');

    // search label
    Route::get('admin/label/search', [AdminController::class, 'searchLabel'])->name('search_label');

    // label hapus 
    Route::delete('admin/label/{id}', [AdminController::class, 'labelDelete'])->name('label_delete');

    // label edit 
    Route::get('admin/label/{id}', [AdminController::class, 'labelUpdate'])->name('label_update');
    Route::put('admin/label/{id}', [AdminController::class, 'labelUpdatePost'])->name('label_update_post');

    // add label
    Route::get('admin/label-add', [AdminController::class, 'labelAdd'])->name('label_add');
    Route::post('admin/label-add', [AdminController::class, 'labelAddPost'])->name('label_add_post');

    // result
    Route::get('admin/result', [AdminController::class, 'result'])->name('admin_result');
    Route::get('admin/result/view/{user_id}', [AdminController::class, 'resultView'])->name('admin_result_view');

    // search result
    Route::get('admin/result/search', [AdminController::class, 'searchResult'])->name('admin_search_result');

    // result comment
    Route::get('admin/result/comment/{user_id}', [AdminController::class, 'resultComment'])->name('admin_result_comment');
    Route::post('admin/result/comment/{user_id}', [AdminController::class, 'resultCommentEnough'])->name('admin_result_comment_enough');
    Route::put('admin/result/comment/{user_id}', [AdminController::class, 'resultCommentPost'])->name('admin_result_comment_post');

    // result hapus 
    Route::delete('admin/result/{user_id}', [AdminController::class, 'resultDelete'])->name('result_delete');

    // download
    Route::get('admin/result/view/{user_id}/download', [AdminController::class, 'resultDownload'])->name('admin_download_result');

    // email
    Route::get('admin/result/email/{user_id}', [AdminController::class, 'resultEmail'])->name('admin_email');
    Route::get('admin/result/email/finish/{user_id}', [AdminController::class, 'resultEmailFinish'])->name('admin_email_finish');
    Route::post('admin/result/email/{user_id}', [AdminController::class, 'resultEmailPost'])->name('admin_email_post');

    // form
    Route::get('admin/form', [AdminController::class, 'form'])->name('admin_form');

    // form overview
    Route::get('admin/form/overview', [AdminController::class, 'formOverview'])->name('admin_form_overview');
    Route::post('admin/form/overview', [AdminController::class, 'formOverviewPost'])->name('admin_form_overview_post');

    // form visa
    Route::get('admin/form/visa', [AdminController::class, 'formVisa'])->name('admin_form_visa');
    Route::post('admin/form/visa', [AdminController::class, 'formVisaPost'])->name('admin_form_visa_post');

    // form visa feedback
    Route::get('admin/form/visa/feedback', [AdminController::class, 'formVisaFeedback'])->name('admin_form_visa_feedback');
    Route::put('admin/form/visa/feedback', [AdminController::class, 'formVisaFeedbackPost'])->name('admin_form_visa_feedback_post');

    // register
    Route::get('admin/register-halodoc', [AuthController::class, 'register'])->name('register');
    Route::post('admin/register-halodoc', [AuthController::class, 'register_store'])->name('register_post');
});

// vendor
Route::group(['middleware' => 'vendor'], function () {
    // dashboard
    Route::get('vendor/home', [VendorController::class, 'index'])->name('vendor_dashboard');

    // profile
    Route::get('vendor/profile', [VendorController::class, 'profile'])->name('vendor_profile');
    Route::put('vendor/profile/{id}', [VendorController::class, 'profilePost'])->name('vendor_profile_post');

    // form
    Route::get('vendor/form', [VendorController::class, 'form'])->name('vendor_form');

    // form overview
    Route::get('vendor/form/overview', [VendorController::class, 'formOverview'])->name('vendor_form_overview');
    Route::post('vendor/form/overview', [VendorController::class, 'formOverviewPost'])->name('vendor_form_overview_post');

    // form visa
    Route::get('vendor/form/visa', [VendorController::class, 'formVisa'])->name('vendor_form_visa');
    Route::post('vendor/form/visa', [VendorController::class, 'formVisaPost'])->name('vendor_form_visa_post');

    // form visafeedback
    Route::get('vendor/form/visa/feedback', [VendorController::class, 'formVisaFeedback'])->name('vendor_form_visa_feedback');
    Route::put('vendor/form/visa/feedback', [VendorController::class, 'formVisaFeedbackPost'])->name('vendor_form_visa_feedback_post');
});

// guest
Route::group(['middleware' => 'guest'], function () {
    // dashboard
    Route::get('guest/home', [GuestController::class, 'index'])->name('guest_dashboard');

    // profile
    Route::get('guest/profile', [GuestController::class, 'profile'])->name('guest_profile');
    Route::put('guest/profile/{id}', [GuestController::class, 'profilePost'])->name('guest_profile_post');

    // result
    Route::get('guest/result', [GuestController::class, 'result'])->name('guest_result');
    Route::get('guest/result/view/{user_id}', [GuestController::class, 'resultView'])->name('guest_result_view');

    // search result
    Route::get('guest/result/search', [GuestController::class, 'searchResult'])->name('guest_search_result');

    // download
    Route::get('guest/result/view/{user_id}/download', [GuestController::class, 'resultDownload'])->name('guest_download_result');
});
