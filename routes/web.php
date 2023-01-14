<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\Auth\AccountController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
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
    return view('auth/login');
});
Route::middleware(['auth'])->group(function (){

    Route::get('/dashboard', [DashboardController::class, 'show' ])->name('dashboard');

    Route::prefix('/reporting')->group(function(){ 
        Route::get('/student-balances', [ReportingController::class,'studentBalances'])->name('reporting.student-balances');
        Route::get('/bills-by-class', [ReportingController::class,'billsByClass'])->name('reporting.bills-by-class');
        Route::get('/bills-by-user', [ReportingController::class,'billsByUser'])->name('reporting.bills-by-user');
        Route::get('/income-by-class', [ReportingController::class,'incomeByClass'])->name('reporting.income-by-class');
        Route::get('/income-by-user', [ReportingController::class,'incomeByUser'])->name('reporting.income-by-user');
       
    });
    
    // students and guardians
        Route::resource('students',StudentController::class);
        Route::resource('guardians',GuardianController::class);
        Route::resource('attendances',AttendanceController::class);
        Route::resource('courses',CourseController::class);
        Route::resource('classes',ClassesController::class);

    // accounting and reporting
        Route::resource('fees',FeeController::class);
        Route::resource('bills',BillController::class);
        Route::resource('payments', PaymentController::class);
        Route::resource('expense-reports',PaymentController::class);
        Route::resource('reportings',PaymentController::class);
        Route::resource('staffs',StaffController::class);
        Route::resource('leave',StaffController::class);

    // users and roles
        Route::resource('users',UserController::class);
        Route::resource('sms',UserRoleController::class);

     // logged in user account
     Route::prefix('/account')->group(function (){
        Route::get('profile', [AccountController::class, 'profile'])->name('profile');
        Route::post('update', [AccountController::class, 'update'])->name('update-profile');
    });

    // setup
    Route::prefix('/setup')->group(function (){
        Route::resource('modules',ModuleController::class);
        Route::resource('settings',SettingController::class);
        Route::resource('permissions',PermissionController::class);
        Route::prefix('/attributes')->group(function (){
            Route::resource('expense-types',ExpenseController::class);
            Route::resource('fee-types',FeeTypeController::class);
            Route::resource('semesters',SemesterController::class);  
            Route::resource('user-roles',UserRoleController::class);  
        });
    });
});

require __DIR__.'/auth.php';