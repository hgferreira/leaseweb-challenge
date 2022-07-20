<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServersController;
use App\Http\Controllers\Api\LocationsController;
use App\Http\Controllers\Api\StorageTypesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('servers', ServersController::class);
Route::apiResource('locations', LocationsController::class);
Route::apiResource('storage-types', StorageTypesController::class);