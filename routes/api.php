<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('productStock/{id}',[ApiController::class, 'productStock']);
Route::get('product/{id}',[ApiController::class, 'product']);
Route::get('rekanan/{id}',[ApiController::class, 'rekanan']);
Route::get('order/{id}',[ApiController::class, 'order']);
