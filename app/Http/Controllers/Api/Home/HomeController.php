<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(){
        $this->middleware('User_Role') ;
    }
    public function GetAllCategory() : JsonResponse
    {
        $category = Category::all() ;

        return response()->json([
            'status' => 1 ,
            'data' => $category  ,
            'message' => 'all categories'
        ]);

    }

    public function GetAllMedicine() : JsonResponse
    {
       $medicine = Medicine::all() ;

       return response()->json([
          'status' => 1 ,
          'data' => $medicine ,
          'message' => 'all medicines' ,
       ]);

    }

    public function searchForMedicineName(string $name) : JsonResponse
    {
         $medicines = Medicine::filterName($name) ;

         return response()->json([
            'status' => 1 ,
            'data' => $medicines ,
            'message' => 'result'  ,
         ]);
    }










}
