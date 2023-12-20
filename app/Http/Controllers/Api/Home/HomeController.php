<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineCollection;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Warehouse;
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
       $medicine = new MedicineCollection(Medicine::all())  ;
       return response()->json([
          'status' => 1 ,
          'data' => $medicine ,
          'message' => 'all medicines' ,
       ]);

    }

    public function searchForMedicineName(Request $request) : JsonResponse
    {
        $text = $request['text'] ;
        $medicines = Medicine::query()->where('trade_name' , 'LIKE' , '%'.$text.'%')->get() ;
        $data = new MedicineCollection($medicines) ;

         return response()->json([
            'status' => 1 ,
            'data' => $data ,
            'message' => 'result'  ,
         ]);
    }

    public function GetAllCategoryMedicine(Request $request) : JsonResponse
    {
        $category_id = $request['category_id'] ;
        $category = Category::query()->where('id' , '=' , $category_id) ;
        if(!$category){
            return response()->json([
               'status' => 0 ,
               'data' =>  [] ,
               'message' => 'invalid...'
            ]);
        }
        $categoryItems = Medicine::query()->where('category_id' , '=' , $category['id']);
        $data = new MedicineCollection($categoryItems) ;
        return response()->json([
           'status' => 1 ,
           'data' => $data ,
           'message' => 'all category items' ,
        ]);
    }


    public function GetWarehouseCategory(Request $request) : JsonResponse
    {
        $warehouse_id = $request['warehouse_id'] ;
        $warehouse = Warehouse::query()->where('id' , '=' , $warehouse_id) ;
        if(!$warehouse){
            return response()->json([
               'status' => 0 ,
               'data' => [] ,
               'message' => 'invalid....' ,
            ]);
        }

        $category = Category::query()->where('warehouse_id' , '=' , $warehouse['id']);
        return response()->json([
           'status' => 0 ,
           'data' => $category ,
           'message' => 'all category' ,
        ]);
    }

}
