<?php

use App\Http\Controllers\Admin\CreateCategoryController;
use App\Http\Controllers\Admin\CreateMedicine;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Home\HomeController;
use App\Http\Controllers\Api\Home\ProfileController;
use App\Http\Controllers\test\testController;
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

//user Route
Route::post('/register' ,[AuthController::class ,'Register' ]);
Route::post('/login' ,[AuthController::class ,'Login' ]);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout' , [AuthController::class , 'logout']) ;
    Route::get('/getCategory' , [HomeController::class , 'GetAllCategory']);
    Route::get('/getMedicine' , [HomeController::class , 'GetAllMedicine']) ;
    Route::get('/addFavorite/{ID}' , [ProfileController::class , 'addFavorite']) ;
    Route::get('/getFavorite' , [ProfileController::class , 'GetFavorite']) ;

});

//we are going to make another middleware  for the Admin.
Route::post('/admin' ,[LoginController::class ,'Login' ]);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create' , [CreateMedicine::class , 'create']) ;
    Route::post('/delete' , [CreateMedicine::class , 'delete']) ;
    Route::post('/edit' , [CreateMedicine::class , 'editQuantity']) ;
    Route::get('/show' , [CreateCategoryController::class , 'showCategory']) ;
    Route::post('/category' , [CreateCategoryController::class , 'createCategory']) ;
    Route::get('/category/{id}' , [CreateCategoryController::class , 'showCategoryItem']) ;
});



//test api ::
Route::middleware('auth:sanctum')->post('/data' , [testController::class , 'user_data']) ;
Route::middleware('auth:sanctum')->post('/ware' , [testController::class , 'ware']) ;
Route::middleware('auth:sanctum')->post('/med' , [testController::class , 'med']) ;
Route::get('/del' , [testController::class , 'delete']) ;

