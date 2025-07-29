<?php

use App\Http\Controllers\admin\ArticleCategoryController;
use App\Http\Controllers\admin\ArticleController;
use App\Http\Controllers\admin\CheckinController;
use App\Http\Controllers\admin\CommunicationLogController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\EmailTemplateController;
use App\Http\Controllers\admin\EquipmentController;
use App\Http\Controllers\admin\MemberController;
use App\Http\Controllers\admin\MemberEngagementController;
use App\Http\Controllers\admin\MembershipplanController;
use App\Http\Controllers\admin\MemberSubscriptionController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\RFIDController;
use App\Http\Controllers\admin\TrainerController;
use App\Http\Controllers\admin\VnpayController;
use App\Http\Controllers\auth\LoginController;
use Illuminate\Support\Facades\Route;

// Auth & Dashboard
Route::get('/', [LoginController::class, 'index'])->name('home');
Route::get('/login', [LoginController::class, 'index'])->name('login.index');
Route::post('/login', [LoginController::class, 'login'])->name('login.auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Member routes
Route::prefix('admin/member')->group(function () {
    Route::get('/index', [MemberController::class, 'index'])->name('admin.members.index');
    Route::post('/update', [MemberController::class, 'update'])->name('admin.members.update');
    Route::post('/store', [MemberController::class, 'store'])->name('admin.members.store');
    Route::get('/create', [MemberController::class, 'create'])->name('admin.members.create');
    Route::get('/{id}', [MemberController::class, 'show'])->name('admin.members.show');
    Route::delete('/{id}', [MemberController::class, 'destroy'])->name('admin.members.destroy');

});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('membership-plans', MembershipPlanController::class);

});
// Member Subscription routes
Route::prefix('admin/subscriptions')->group(function () {
    Route::get('/create', [MemberSubscriptionController::class, 'create'])->name('admin.subscriptions.create');
    Route::post('/store', [MemberSubscriptionController::class, 'store'])->name('admin.subscriptions.store');
});

// RFID routes
Route::prefix('admin/rfid')->name('admin.rfid.')->group(function () {
    Route::get('/', [RFIDController::class, 'index'])->name('index');
    Route::put('/{id}', [RFIDController::class, 'update'])->name('update');
    Route::delete('/{id}', [RFIDController::class, 'destroy'])->name('destroy');
});

// Equipment routes
Route::prefix('admin/equipment')->name('admin.equipment.')->group(function () {
    Route::get('/', [EquipmentController::class, 'index'])->name('index');
    Route::get('/create', [EquipmentController::class, 'create'])->name('create');
    Route::post('/', [EquipmentController::class, 'store'])->name('store');
    Route::post('/update', [EquipmentController::class, 'update'])->name('update');

    Route::delete('/{equipment}', [EquipmentController::class, 'destroy'])->name('destroy');
});
// trainers routes
Route::prefix('admin/trainers')->name('admin.trainers.')->group(function () {
    Route::get('/', [TrainerController::class, 'index'])->name('index');
    Route::get('/create', [TrainerController::class, 'create'])->name('create');
    Route::post('/', [TrainerController::class, 'store'])->name('store');
    Route::put('/{trainerProfile}', [TrainerController::class, 'update'])->name('update');
    Route::delete('/{trainerProfile}', [TrainerController::class, 'destroy'])->name('destroy');
});

// Checkin routes
Route::prefix('admin/checkin')->name('admin.checkin.')->group(function () {
    Route::post('/{checkin}/force-checkout', [CheckinController::class, 'forceCheckout'])->name('forceCheckout');
    Route::post('/force-checkout-all', [CheckinController::class, 'forceCheckoutAll'])->name('forceCheckoutAll');
    Route::get('/page', [CheckinController::class, 'checkinPage'])->name('checkinPage');
    Route::get('/index', [CheckinController::class, 'index'])->name('index');
    Route::post('/machine', [CheckinController::class, 'machineCheckin'])->name('machine');

});

Route::prefix('admin')->group(function () {
    Route::get('/engagement', [MemberEngagementController::class, 'index'])->name('admin.engagement.index');
    Route::post('/engagement/send', [MemberEngagementController::class, 'send'])->name('admin.engagement.send');

    Route::get('/email-templates', [EmailTemplateController::class, 'index'])->name('admin.email-templates.index');
    Route::get('/email-templates/create', [EmailTemplateController::class, 'create'])->name('admin.email-templates.create');
    Route::post('/email-templates', [EmailTemplateController::class, 'store'])->name('admin.email-templates.store');
    Route::get('/email-templates/{email_template}', [EmailTemplateController::class, 'show'])->name('admin.email-templates.show');
    Route::get('/email-templates/{email_template}/edit', [EmailTemplateController::class, 'edit'])->name('admin.email-templates.edit');
    Route::put('/email-templates/{email_template}', [EmailTemplateController::class, 'update'])->name('admin.email-templates.update');
    Route::delete('/email-templates/{email_template}', [EmailTemplateController::class, 'destroy'])->name('admin.email-templates.destroy');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('communication-logs', [CommunicationLogController::class, 'index'])->name('communication-logs.index');
    Route::get('communication-logs/{log}', [CommunicationLogController::class, 'show'])->name('communication-logs.show');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('article-categories', ArticleCategoryController::class);
    Route::resource('articles', ArticleController::class);
});
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

Route::get('/vnpay/return', [VnpayController::class, 'handleReturn'])->name('vnpay.return');

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{contact}/resolve', [ContactController::class, 'resolve'])->name('contacts.resolve');
    Route::post('/contacts/{contact}/unresolve', [ContactController::class, 'unresolve'])->name('contacts.unresolve');
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

});
