<?php

use App\Http\Controllers\Api\BabiesController;
use App\Http\Controllers\Api\ParentsController;
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

Route::post('/parents/login', [ParentsController::class, 'login']);


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::resources([
        'parents' => ParentsController::class,
        'babies' => BabiesController::class,
    ]);
});


Route::get('getPartners/{id}', [\App\Http\Controllers\Api\ParentsController::class, 'getPartners']);
Route::get('getChildrens/{id}', [\App\Http\Controllers\Api\ParentsController::class, 'getChildrens']);
