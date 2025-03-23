<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'login'])->name('auth.login');
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('auth.logout');
Route::get('/register', [App\Http\Controllers\HomeController::class, 'register'])->name('auth.register');
Route::post('/check-login', [App\Http\Controllers\HomeController::class, 'check'])->name('auth.check');
Route::get('/dashboardAD', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.dashboard');
Route::get('/HR_Manager', [App\Http\Controllers\AdminController::class, 'HR_Manager'])->name('admin.HR_Manager');
Route::post('/dashboardAD', [App\Http\Controllers\AdminController::class, 'store'])->name('admin.store');
Route::put('/dashboardAD/{id}', [App\Http\Controllers\AdminController::class, 'update'])->name('admin.update');
Route::delete('/dashboardAD/{id}', [App\Http\Controllers\AdminController::class, 'destroy'])->name('admin.delete');
Route::get('/dashboardAC', [App\Http\Controllers\AccountingController::class, 'index'])->name('Accounting.dashboard');
Route::get('/salaryAC', [App\Http\Controllers\AccountingController::class, 'salary'])->name('Accounting.salary');
Route::get('/salaryAC/add', [App\Http\Controllers\AccountingController::class, 'salaryAdd'])->name('Accounting.salaryAdd');
Route::get('/paymentAC', [App\Http\Controllers\AccountingController::class, 'payment'])->name('Accounting.payment');
Route::get('/payment', [App\Http\Controllers\AccountingController::class, 'payment'])->name('Accounting.payment');
Route::get('/get-salaries-by-department', [App\Http\Controllers\AccountingController::class, 'getSalariesByDepartment'])->name('Accounting.getSalariesByDepartment');
Route::post('/pay-salary', [App\Http\Controllers\AccountingController::class, 'paySalary'])->name('Accounting.paySalary');
Route::get('/dashboardHM', [App\Http\Controllers\HumanController::class, 'index'])->name('Human.dashboard');
Route::get('/ChartHuman', [App\Http\Controllers\HumanController::class, 'ChartHuman'])->name('Human.chartHuman');
Route::get('/ManagerHM', [App\Http\Controllers\HumanController::class, 'ManagerHM'])->name('Human.Manager');
Route::post('/ManagerHM', [App\Http\Controllers\HumanController::class, 'ManagerAdd'])->name('Human.ManagerAdd');
Route::put('/ManagerHM/{id}', [App\Http\Controllers\HumanController::class, 'ManagerUpdate'])->name('Human.ManagerUpdate');
Route::delete('/ManagerHM/{id}', [App\Http\Controllers\HumanController::class, 'ManagerDelete'])->name('Human.ManagerDelete');
Route::post('/ManagerHMContract', [App\Http\Controllers\HumanController::class, 'FileAdd'])->name('Human.FileAdd');
Route::delete('/ManagerHMContract/{id}', [App\Http\Controllers\HumanController::class, 'FileDelete'])->name('Human.FileDelete');
Route::get('/ManagerHMFind', [App\Http\Controllers\HumanController::class, 'ManagerHMFindDeparment'])->name('Human.ManagerFind');
Route::get('/ManagerDP', [App\Http\Controllers\HumanController::class, 'ManagerDP'])->name('Human.ManagerDP');
Route::post('/ManagerDP', [App\Http\Controllers\HumanController::class, 'DepartmentAdd'])->name('Human.departmentAdd');
Route::put('/ManagerDP/{id}', [App\Http\Controllers\HumanController::class, 'DepartmentEdit'])->name('Human.departmentEdit');
Route::delete('/ManagerDP/{id}', [App\Http\Controllers\HumanController::class, 'DepartmentDelete'])->name('Human.departmentDelete');
Route::get('/ManagerPS', [App\Http\Controllers\HumanController::class, 'ManagerPS'])->name('Human.ManagerPS');
Route::post('/ManagerPS', [App\Http\Controllers\HumanController::class, 'ManagerPSAdd'])->name('Human.positionAdd');
Route::put('/ManagerPS/{id}', [App\Http\Controllers\HumanController::class, 'ManagerPSEdit'])->name('Human.positionEdit');
Route::delete('/ManagerPS/{id}', [App\Http\Controllers\HumanController::class, 'ManagerPSDelete'])->name('Human.positionDelete');
Route::get('/Timekeeping', [App\Http\Controllers\HumanController::class, 'Timekeeping'])->name('Human.Timekeeping');
Route::get('/WorkSchedule', [App\Http\Controllers\HumanController::class, 'WorkSchedule'])->name('Human.WorkSchedule');
Route::post('/WorkSchedule', [App\Http\Controllers\HumanController::class, 'WorkScheduleAdd'])->name('Human.WorkScheduleAdd');
Route::put('/WorkSchedule/{id}', [App\Http\Controllers\HumanController::class, 'WorkScheduleUpdate'])->name('Human.WorkScheduleUpdate');
Route::delete('/WorkSchedule/{id}', [App\Http\Controllers\HumanController::class, 'WorkScheduleDelete'])->name('Human.WorkScheduleDelete');
Route::get('/ShiftManager', [App\Http\Controllers\HumanController::class, 'ShiftManager'])->name('Human.ShiftManager');
Route::post('/ShiftManager', [App\Http\Controllers\HumanController::class, 'ShiftManagerAdd'])->name('Human.ShiftManagerAdd');
Route::put('/ShiftManager/{id}', [App\Http\Controllers\HumanController::class, 'ShiftManagerUpdate'])->name('Human.ShiftManagerUpdate');
Route::delete('/ShiftManager/{id}', [App\Http\Controllers\HumanController::class, 'ShiftManagerDelete'])->name('Human.ShiftManagerDelete');
Route::get('/ManagerCTO', [App\Http\Controllers\CTOController::class, 'dashboard'])->name('CTO.dashboard');
Route::get('/ManagerCTOadmin', [App\Http\Controllers\CTOController::class, 'Admin'])->name('CTO.Admin');
