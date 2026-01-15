<?php

use App\Http\Controllers\Admin\TransferController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\CarController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response()->json(['message' => 'API works!']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//route publiques
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/transfers', [\App\Http\Controllers\PublicTransferController::class, 'index']);

//protected route token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('/admin/cars', CarController::class); //seul les personnes authentifiés peuvent créer/supp les voitures
    Route::apiResource('/admin/transfers', TransferController::class);
});

Route::middleware('auth:sanctum')->post('/reservations', [ReservationController::class, 'store']);
Route::get('/vehicles', [\App\Http\Controllers\PublicVehicleController::class, 'index']);
Route::get('/vehicles/{car}', [\App\Http\Controllers\PublicVehicleController::class, 'show']);
Route::get('/catalog', [\App\Http\Controllers\PublicVehicleController::class, 'catalog']);






