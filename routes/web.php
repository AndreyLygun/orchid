<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportExportController;

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

Route::get('/', function () {
    return view('welcome');
});



