<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AlldataController;

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


Route::middleware('auth')->group(function(){

    // Route::get('/animal', [AnimalController::class,'index']);
    // Route::post('/animal', [AnimalController::class,'store']);
    // Route::get('/animal/{animal}', [AnimalController::class,'show']);
    // Route::put('/animal/{animal}', [AnimalController::class,'update']);
    // Route::delete('/animal/{animal}', [AnimalController::class,'destroy']);
    
    
});

