<?php

use App\Http\Controllers\Admin\CreateCategoryController;
use App\Http\Controllers\Admin\CreateMedicine;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Cart\CartController;
use App\Http\Controllers\Api\Home\HomeController;
use App\Http\Controllers\Api\Home\ProfileController;
use App\Http\Controllers\Api\Orders\Ordercontroller;
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

//user Route
Route::post('/register' ,[AuthController::class ,'Register' ]);
Route::post('/login' ,[AuthController::class ,'Login' ]);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout' , [AuthController::class , 'logout']) ;
    //HomeController :
    Route::post('/search' , [HomeController::class , 'searchForMedicineName']);
    Route::get('/getCategory' , [HomeController::class , 'GetAllCategory']);
    Route::get('/getCategory/{id}' , [HomeController::class , 'GetCategoryItem']) ;
    Route::get('/getMedicine' , [HomeController::class , 'GetAllMedicine']) ;
    //ProfileController :
    Route::get('/getUser' , [ProfileController::class , 'GetUserData']);
    Route::post('/addFavorite' , [ProfileController::class , 'addFavorite']) ;
    Route::get('/getFavorite' , [ProfileController::class , 'GetFavorite']) ;
    Route::delete('/deleteFavorite/{ID}' , [ProfileController::class , 'DeleteFavorite']) ;
    //CartController :
    Route::post('/addToCart' , [CartController::class , 'AddToCart']);
    Route::get('/getCartItem' , [CartController::class , 'ShowCartItem']);
    Route::delete('/deleteCartItem/{ID}' , [CartController::class , 'deleteCartItem']) ;
    //OrderController :
    Route::post('/order' , [Ordercontroller::class , 'OrderAllCartItem']) ;
    Route::get('/getOrder' , [Ordercontroller::class , 'GetAllOrder']) ;
    Route::get('/order/details/{ID}' , [Ordercontroller::class , 'GetOrderDetails']) ;
    Route::delete('/delete/{DEL_ID}' , [Ordercontroller::class , 'deleteOrder']);

});

//we are going to make another middleware  for the Admin.
Route::post('/admin' ,[LoginController::class ,'Login' ]);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/logout' , [LoginController::class,'Logout']);
    //MedicineController :
    Route::post('/createMedicine' , [CreateMedicine::class , 'create']) ;
    Route::delete('/deleteMedicine/{med_id}' , [CreateMedicine::class , 'deleteMedicine']) ;
    Route::get('/getMedicine' , [CreateMedicine::class , 'GetMedicine']);
    Route::post('/editQuantity' , [CreateMedicine::class , 'editQuantity']) ;
    Route::post('/editPrice' , [CreateMedicine::class , 'editPrice']);

    //CategoryController:
    Route::get('/showCategory' , [CreateCategoryController::class , 'showCategory']) ;
    Route::get('/showCategoryName' , [CreateCategoryController::class , 'GetAllCategoryName']) ;
    Route::post('/category' , [CreateCategoryController::class , 'createCategory']) ;
    Route::get('/category/{id}' , [CreateCategoryController::class , 'showCategoryItem']) ;

});



//test api ::
Route::middleware('auth:sanctum')->post('/data' , [testController::class , 'user_data']) ;
Route::middleware('auth:sanctum')->post('/ware' , [testController::class , 'ware']) ;
Route::middleware('auth:sanctum')->post('/med' , [testController::class , 'med']) ;
Route::get('/del' , [testController::class , 'delete']) ;
Route::get('/print' , [testController::class , 'print']) ;
Route::middleware('auth:sanctum')->post('/test' , [testController::class , 'test']);
Route::middleware('auth:sanctum')->get('/collection' , [testController::class , 'collection']);
Route::get('/image' , [testController::class , 'GetImage']) ;

