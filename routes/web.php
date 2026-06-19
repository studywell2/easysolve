<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PlanController as AdminPlanController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\SettingsController;
// Platform Admin Controllers
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PlanController;
// School Portal Controllers
use App\Http\Controllers\School\AcademicSessionController;
use App\Http\Controllers\School\AnnouncementController;
use App\Http\Controllers\School\AttendanceController;
use App\Http\Controllers\School\BillingController;
use App\Http\Controllers\School\DashboardController as SchoolDashboardController;
use App\Http\Controllers\School\FeeController;
use App\Http\Controllers\School\GradeController;
use App\Http\Controllers\School\MessageController;
use App\Http\Controllers\School\PaymentController;
use App\Http\Controllers\School\ReportController;
use App\Http\Controllers\School\SchoolClassController;
use App\Http\Controllers\School\SchoolSettingController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\TermsController;
use App\Http\Controllers\School\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/help', fn () => view('help'))->name('help');
Route::get('/terms', fn () => view('terms'))->name('terms');
Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');

/*
|--------------------------------------------------------------------------
| Guest Routes (Login / Register)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store'])->middleware('throttle:5,1');
    Route::get('register/success', fn () => view('auth.success'))->name('register.success');
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->middleware('throttle:5,1');

    // Password Reset
    Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->middleware('throttle:5,1')->name('password.email');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');

    // Root dashboard — redirects to the correct portal based on role
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Platform Admin Panel (super_admin only) ──────────────
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('schools', SchoolController::class);
        Route::resource('plans', AdminPlanController::class)->except(['show']);
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    // ── School Portal (any user belonging to a school) ───────
    Route::middleware('school')->prefix('school')->name('school.')->group(function () {
        // Terms & Conditions (outside subscription & terms middleware to avoid redirect loops)
        Route::get('terms', [TermsController::class, 'show'])->name('terms.show');
        Route::post('terms/accept', [TermsController::class, 'accept'])->name('terms.accept');

        // Billing (outside subscription & terms middleware so expired users can upgrade)
        Route::get('billing', [BillingController::class, 'index'])->name('billing.index');

        // All routes below require active subscription AND T&C acceptance
        Route::middleware('subscription')->group(function () {
            // All routes below require T&C acceptance
            Route::middleware('terms')->group(function () {
                Route::get('dashboard', [SchoolDashboardController::class, 'index'])->name('dashboard');

                // Users
                Route::resource('users', UserController::class);

                // Classes
                Route::resource('classes', SchoolClassController::class);

                // Subjects
                Route::resource('subjects', SubjectController::class)->except(['show']);

                // Academic Sessions & Terms
                Route::resource('sessions', AcademicSessionController::class)->except(['show']);
                Route::post('terms/{term}/set-current', [AcademicSessionController::class, 'setCurrentTerm'])->name('terms.set-current');

                // Attendance
                Route::resource('attendance', AttendanceController::class)->only(['index', 'create', 'store']);
                Route::get('attendance/students', [AttendanceController::class, 'getStudents'])->name('attendance.students');

                // Grades
                Route::resource('grades', GradeController::class)->except(['show']);

                // Fees
                Route::resource('fees', FeeController::class)->except(['show']);

                // Payments
                Route::resource('payments', PaymentController::class)->except(['destroy']);

                // Settings
                Route::get('settings', [SchoolSettingController::class, 'index'])->name('settings.index');
                Route::put('settings', [SchoolSettingController::class, 'update'])->name('settings.update');
                Route::put('terms', [SchoolSettingController::class, 'updateTerms'])->name('terms.update');

                // Reports
                Route::get('reports', [ReportController::class, 'index'])->name('reports.index');

                // Announcements
                Route::resource('announcements', AnnouncementController::class);

                // Messages
                Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
                Route::get('messages/create', [MessageController::class, 'create'])->name('messages.create');
                Route::post('messages', [MessageController::class, 'store'])->name('messages.store');
                Route::get('messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
                Route::post('messages/{conversation}/reply', [MessageController::class, 'reply'])->name('messages.reply');
            });
        });
    });
});
