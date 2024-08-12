<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BobotController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SupplierController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect(route('index'));
});


Route::controller(AuthController::class)->group(function () {
    Route::get('/index', 'viewIndex')->middleware('auth')->name('index');
    Route::get('/login', 'viewLogin')->middleware('guest')->name('login');

    Route::post('/auth', 'authenticate')->middleware('guest')->name('authenticate');
    Route::post('/logout', 'logout')->middleware('auth')->name('logout');
});

Route::controller(ItemController::class)->group(function () {
    Route::get('/item', 'viewItem')->middleware('auth')->name('view-item');
    Route::post('/item/create', 'createItem')->middleware('auth')->name('create-item');
    Route::post('/item/update', 'updateItem')->middleware('auth')->name('update-item');
    Route::post('/item/delete', 'deleteItem')->middleware('auth')->name('delete-item');
});

Route::controller(SupplierController::class)->group(function () {
    Route::get('/supplier', 'viewsupplier')->middleware('auth')->name('view-supplier');
    Route::post('/supplier/create', 'createsupplier')->middleware('auth')->name('create-supplier');
    Route::post('/supplier/update', 'updatesupplier')->middleware('auth')->name('update-supplier');
    Route::post('/supplier/delete', 'deletesupplier')->middleware('auth')->name('delete-supplier');

    Route::get('/supplier/get-item', 'getItem')->middleware('auth')->name('get-item-supplier');

    Route::post('/supplier/create-item', 'createItemSupplier')->middleware('auth')->name('create-item-supplier');
    Route::get('/delete-item-supplier', 'deleteItemSupplier')->middleware('auth')->name('delete-item-supplier');
});

Route::controller(BobotController::class)->group(function () {
    Route::post('/bobot/create', 'createBobot')->middleware('auth')->name('create-bobot');
});
