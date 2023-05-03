<?php

use App\Http\Controllers\Employees\Employee\EmployeeController;
use App\Http\Controllers\Employees\Employee\AttendanceLogController;
use App\Http\Controllers\Employees\Resign\ResignManagementController;


/*
|--------------------------------------------------------------------------
| Fingerprint Routes
|--------------------------------------------------------------------------
|
| Here is where you can register fingerprint related routes for your application.
|
*/

Route::prefix('fingerprint')->name('fingerprint.')->group(function () {
    Route::controller(ApprovalController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('get-data', 'getData')->name('getdata');
        Route::put('{id}/approve', 'approveApproval')->name('approve');
        Route::put('{id}/reject', 'rejectApproval')->name('reject');
    });
});


