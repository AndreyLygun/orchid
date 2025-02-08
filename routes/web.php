<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\CompanyController;

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

Route::controller(ImportExportController::class)->group(function() {
    Route::get('/admin/exportmenu', 'ExportMenu')->name('exportmenu');
});

Route::domain('{company_id}.' . env('APP_URL'))->group(function () {
    Route::get('/',  [CompanyController::class, 'showInfo'])->middleware('getCompanyId');
    Route::get('menu', [CompanyController::class, 'showMenu'])->middleware('getCompanyId');
    Route::get('order',  [CompanyController::class, 'showOrder'])->middleware('getCompanyId');
    Route::get('waiter',  [CompanyController::class, 'showWaiter'])->middleware('getCompanyId');
});

Route::get('/', function () {
    return view('welcome');
})->middleware('getCompanyId');





