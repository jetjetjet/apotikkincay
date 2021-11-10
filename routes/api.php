<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatuanController;

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

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::group(['middleware' => 'auth:sanctum'], function() {
	Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
	Route::get('/role-grid', [RoleController::class, 'grid'])->middleware('can:peran-lihat');
	Route::get('/role-permissions', [RoleController::class, 'getPermission']);
	Route::get('/role/{id}', [RoleController::class, 'show'])->middleware('can:peran-lihat');
	Route::post('/role', [RoleController::class, 'store'])->middleware('can:peran-tambah');
	Route::put('/role/{id}', [RoleController::class, 'update'])->middleware('can:peran-ubah');
	Route::delete('/role/{id}',  [RoleController::class, 'destroy'])->middleware('can:peran-hapus');
	
	Route::get('/satuan-grid', [SatuanController::class, 'grid']);
	Route::get('/satuan/{id}', [SatuanController::class, 'show']);
	Route::post('/satuan', [SatuanController::class, 'store']);
	Route::put('/satuan/{id}', [SatuanController::class, 'update']);
	Route::delete('/satuan/{id}', [SatuanController::class, 'destroy']);
});
