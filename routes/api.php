<?php

use App\Http\Controllers\Admin\CreateMedicine;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register' ,[AuthController::class ,'Register' ]);
Route::post('/login' ,[AuthController::class ,'Login' ]);
Route::middleware('auth:sanctum')->get('/logout' , [AuthController::class , 'logout']) ;

//we are going to make another middleware  for the type of user .
Route::middleware('auth:sanctum')->post('/create' , [CreateMedicine::class , 'create']) ;
Route::middleware('auth:sanctum')->post('/delete' , [CreateMedicine::class , 'delete']) ;
Route::middleware('auth:sanctum')->post('/edit' , [CreateMedicine::class , 'editQuantity']) ;

