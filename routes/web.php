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
use App\Http\Controllers\School\EventController;
use App\Http\Controllers\School\ExamController;
use App\Http\Controllers\School\FeeController;
use App\Http\Controllers\School\GradeController;
use App\Http\Controllers\School\HomeworkController;
use App\Http\Controllers\School\LibraryController;
use App\Http\Controllers\School\MessageController;
use App\Http\Controllers\School\PaymentController;
use App\Http\Controllers\School\ReportController;
use App\Http\Controllers\School\SchoolClassController;
use App\Http\Controllers\School\SchoolSettingController;
use App\Http\Controllers\School\SubjectController;
use App\Http\Controllers\School\TermsController;
use App\Http\Controllers\School\TimetableController;
use App\Http\Controllers\School\UserController;
use App\Http\Controllers\Admin\FinanceController;
use App\Http\Controllers\Admin\PaymentRequestController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\School\StaffAttendanceController;
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
        Route::get('payment-requests', [PaymentRequestController::class, 'index'])->name('payment-requests.index');
        Route::get('payment-requests/{paymentRequest}', [PaymentRequestController::class, 'show'])->name('payment-requests.show');
        Route::post('payment-requests/{paymentRequest}/verify', [PaymentRequestController::class, 'verify'])->name('payment-requests.verify');
        Route::post('payment-requests/{paymentRequest}/reject', [PaymentRequestController::class, 'reject'])->name('payment-requests.reject');
        Route::get('settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingsController::class, 'update'])->name('settings.update');

        // User Management
        Route::resource('users', AdminUserController::class)->except(['create', 'store']);
        Route::post('users/{user}/toggle-active', [AdminUserController::class, 'toggleActive'])->name('users.toggle-active');

        // Subscription Control
        Route::post('schools/{school}/extend-trial', [SchoolController::class, 'extendTrial'])->name('schools.extend-trial');
        Route::post('schools/{school}/activate', [SchoolController::class, 'activateSubscription'])->name('schools.activate');
        Route::post('schools/{school}/suspend', [SchoolController::class, 'suspend'])->name('schools.suspend');

        // Finance
        Route::get('finance', [FinanceController::class, 'index'])->name('finance.index');
    });

    // ── School Portal (any user belonging to a school) ───────
    Route::middleware('school')->prefix('school')->name('school.')->group(function () {
        // Terms & Conditions (outside subscription & terms middleware to avoid redirect loops)
        Route::get('terms', [TermsController::class, 'show'])->name('terms.show');
        Route::post('terms/accept', [TermsController::class, 'accept'])->name('terms.accept');

        // Billing (outside subscription & terms middleware so expired users can upgrade)
        Route::get('billing', [BillingController::class, 'index'])->name('billing.index');
        Route::post('billing/payment-request', [BillingController::class, 'store'])->name('billing.store');

        // All routes below require active subscription AND T&C acceptance
        Route::middleware('subscription')->group(function () {
            // All routes below require T&C acceptance
            Route::middleware('terms')->group(function () {
                Route::get('dashboard', [SchoolDashboardController::class, 'index'])->name('dashboard');

                // Users
                Route::resource('users', UserController::class);
                Route::get('users/import', [UserController::class, 'showImportForm'])->name('users.import');
                Route::post('users/import', [UserController::class, 'import'])->name('users.import.store');
                Route::get('users/import/template', [UserController::class, 'downloadTemplate'])->name('users.import.template');

                // Classes
                Route::resource('classes', SchoolClassController::class);

                // Subjects
                Route::resource('subjects', SubjectController::class)->except(['show']);

                // Academic Sessions & Terms
                Route::resource('sessions', AcademicSessionController::class)->except(['show']);
                Route::post('terms/{term}/set-current', [AcademicSessionController::class, 'setCurrentTerm'])->name('terms.set-current');

                // Timetable
                Route::resource('timetable', TimetableController::class)->except(['show']);

                // Attendance
                Route::resource('attendance', AttendanceController::class)->only(['index', 'create', 'store']);
                Route::get('attendance/students', [AttendanceController::class, 'getStudents'])->name('attendance.students');

                // Staff Attendance (Clock In / Clock Out)
                Route::get('staff-attendance', [StaffAttendanceController::class, 'index'])->name('staff-attendance.index');
                Route::post('staff-attendance/clock-in', [StaffAttendanceController::class, 'clockIn'])->name('staff-attendance.clock-in');
                Route::post('staff-attendance/clock-out', [StaffAttendanceController::class, 'clockOut'])->name('staff-attendance.clock-out');

                // Grades
                Route::resource('grades', GradeController::class)->except(['show']);
                Route::get('grades/bulk-entry', [GradeController::class, 'bulkCreate'])->name('grades.bulk');
                Route::post('grades/bulk-entry', [GradeController::class, 'bulkStore'])->name('grades.bulk.store');

                // Homework
                Route::resource('homework', HomeworkController::class);
                Route::post('homework/{homework}/submit', [HomeworkController::class, 'submit'])->name('homework.submit');
                Route::post('homework/submissions/{submission}/grade', [HomeworkController::class, 'grade'])->name('homework.grade');

                // Exams
                Route::resource('exams', ExamController::class);
                Route::post('exams/{exam}/schedules', [ExamController::class, 'storeSchedule'])->name('exams.schedules.store');
                Route::delete('exams/{exam}/schedules/{schedule}', [ExamController::class, 'destroySchedule'])->name('exams.schedules.destroy');
                Route::post('exams/{exam}/publish', [ExamController::class, 'publish'])->name('exams.publish');

                // Events
                Route::resource('events', EventController::class)->except(['show']);

                // Library
                Route::resource('library', LibraryController::class)->except(['show']);
                Route::get('library/{library}/issue', [LibraryController::class, 'issueForm'])->name('library.issueForm');
                Route::post('library/{library}/issue', [LibraryController::class, 'issue'])->name('library.issue');
                Route::post('library/issue/{issue}/return', [LibraryController::class, 'returnBook'])->name('library.return');

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
                Route::get('reports/report-card', [ReportController::class, 'selectReportCard'])->name('reports.report-card');
                Route::post('reports/report-card', [ReportController::class, 'generateReportCard'])->name('reports.report-card.generate');
                Route::post('reports/class-report', [ReportController::class, 'classReport'])->name('reports.class-report');

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
