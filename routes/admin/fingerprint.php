<?php


use App\Http\Controllers\Employees\Resign\ResignManagementController;
use App\Http\Controllers\Fingerprint\FringerprintController;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Fingerprint Routes
|--------------------------------------------------------------------------
|
| Here is where you can register fingerprint related routes for your application.
|
*/

Route::prefix('fingerprint')->name('fingerprint.')->group(function () {
    Route::controller(FringerprintController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('get-data', 'getData')->name('getdata');
        Route::delete('{id}', 'deleteFingerprint')->name('delete');
        Route::put('{id}/update-data', 'editFingerprint')->name('update');
        Route::post('create', 'createFingerprint')->name('create');
    });
});
