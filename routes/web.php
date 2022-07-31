<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\OperationController;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/operations/{operation}',[OperationController::class, 'show']);
});


//Admin Middleware group
Route::middleware('can:Admin')->group(function (){
    //Admin Routes
    Route::get('/admin',[AdminController::class, 'index'])->name('admin');

    //Admin User Routes
    Route::get('/admin/users',[AdminUserController::class,'index'])->name('admin/users');
    Route::delete('admin/users/{user}',[AdminUserController::class, 'destroy']);
    Route::get('/admin/users/{user}/edit',[AdminUserController::class,'edit']);
    Route::patch('/admin/users/{user}',[AdminUserController::class, 'update']);

    //Operation Unregister Route
    Route::post('/operations/{operation}/user/{user}/unregister',[OperationController::class,'unregister']);
});

//Mission Maker Group
Route::middleware('can:MissionMaker')->group(function(){
    Route::get('/operations',[OperationController::class,'index'])->name('missions');
    Route::delete('/operations/{operation}',[OperationController::class,'destroy']);
    Route::patch('/operations/{operation}',[OperationController::class,'update']);
    Route::get('/operations/{operation}/edit',[OperationController::class, 'edit']);
    Route::get('/operation/create',[OperationController::class,'create']);
    Route::post('/operations',[OperationController::class,'store']);
    Route::post('/operations/{operation}/complete',[OperationController::class,'complete']);

});
