<?php

use App\Http\Controllers\AdvanceFeePaymentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\FeeTypeController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->prefix('/datatables')->group(function(){
    Route::get('/students', [StudentController::class, 'datatable']);
    Route::get('/staffs', [StaffController::class, 'datatable']);
    Route::get('/guardians', [GuardianController::class, 'datatable']);
    Route::get('/users', [UserController::class, 'datatable']);
    Route::get('/classes', [ClassesController::class, 'datatable']);
    Route::get('/courses', [CourseController::class, 'datatable']);
    Route::get('/fees', [FeeController::class, 'datatable']);
    Route::get('/expenses', [ExpenseController::class, 'datatable']);
    Route::get('/expense-reports', [ExpenseReportController::class, 'datatable']);
    Route::get('/bills', [BillController::class, 'datatable']);
    Route::get('/payments', [PaymentController::class, 'datatable']);
    Route::get('/attendances', [AttendanceController::class, 'datatable']);
    Route::get('/attendance-related-students', [AttendanceController::class, 'related_students_datatable']);
    Route::get('/class-related-students', [ClassesController::class, 'related_students_datatable']);
    Route::get('/guardian-related-students', [GuardianController::class, 'related_students_datatable']);
    Route::get('/student-related-bills', [StudentController::class, 'related_bills_datatable']);
    Route::get('/guardian-related-bills', [GuardianController::class, 'related_bills_datatable']);
});

Route::middleware('auth:api')->prefix('/json')->group(function(){
    Route::get('/attendance-related-students', [AttendanceController::class, 'related_students_json']);
    Route::put('/attendance-related-students', [AttendanceController::class, 'update_related_students_json']);
    Route::put('/student-advance-payment', [AdvanceFeePaymentController::class, 'make_payments_json']);
    Route::put('/student-balance', [StudentController::class, 'student_balance_json']);
});
Route::middleware('auth:api')->prefix('/datatable-actions')->group(function(){
    Route::put('/students', [StudentController::class, 'datatable_action']);
    Route::put('/staffs', [StaffController::class, 'datatable_action']);
    Route::put('/guardians', [GuardianController::class, 'datatable_action']);
    Route::put('/users', [UserController::class, 'datatable_action']);
    Route::put('/classes', [ClassesController::class, 'datatable_action']);
    Route::put('/courses', [CourseController::class, 'datatable_action']);
    Route::put('/fees', [FeeController::class, 'datatable_action']);
    Route::put('/expenses', [ExpenseController::class, 'datatable_action']);
    Route::put('/bills', [BillController::class, 'datatable_action']);
    Route::put('/payments', [PaymentController::class, 'datatable_action']);
    Route::put('/attendances', [AttendanceController::class, 'datatable_action']);
});

Route::middleware('auth:api')->prefix('/select2')->group(function(){
    Route::get('/students', [StudentController::class, 'select2']);
    Route::get('/staffs', [StaffController::class, 'select2']);
    Route::get('/guardians', [GuardianController::class, 'select2']);
    Route::get('/users', [UserController::class, 'select2']);
    Route::get('/approval-users', [UserController::class, 'expense_select2']);
    Route::get('/classes', [ClassesController::class, 'select2']);
    Route::get('/courses', [CourseController::class, 'select2']);
    Route::get('/fees', [FeeController::class, 'select2']);
    Route::get('/attendance-fees', [FeeController::class, 'attendance_select2']);
    Route::get('/expense-reports', [ExpenseReportController::class, 'select2']);
    Route::get('/expenses', [ExpenseReportController::class, 'select2']);
    Route::get('/fee-types', [FeeTypeController::class, 'select2']);
    Route::get('/attendance-fee-types', [FeeTypeController::class, 'attendance_select2']);
    Route::get('/bills', [BillController::class, 'select2']);
    Route::get('/payments', [PaymentController::class, 'select2']);
    Route::get('/attendances', [AttendanceController::class, 'select2']);

});