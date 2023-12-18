<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Warehouse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Json;

class CreateCategoryController extends Controller
{

    public function __construct(){
        $this->middleware('Admin_Role') ;
    }
    public function createCategory(Request $request) : JsonResponse
    {
         $request->validate([
             'name' => 'required' ,
             'image' => 'image|mimes:png,jpg,jpeg|max:2048',
         ]);
         $AdminUser = $request->user() ;

        $imageName = time() . '.' . $request['image']->extension();
        $request['image']->storeAs('images', $imageName);

        $category =  Category::query()->create([
             'name' => $request['name'],
             'warehouse_id' => $AdminUser['warehouse_id'],
             'image' => $imageName ,
         ]);

         return response()->json([
            'status' => 1 ,
            'data' =>  $category ,
            'message' => 'category has been created successfully' ,
         ]);

    }

    public function showCategory() : JsonResponse
    {
        $warehouse = Auth::user() ;
        $category = Category::query()->where('warehouse_id' , '=' , $warehouse['warehouse_id'])->get() ;

        return response()->json([
            'status' => 1 ,
            'data' => $category ,
            'message' => 'all category'
        ]);
    }

    public function showCategoryItem($id) : JsonResponse
    {

        $data = [] ;
        $medicines = Medicine::all() ;

        if($id < 0 || $id > count($medicines)){
            return response()->json([
                'status' => 0 ,
                'data' => [] ,
                'message' => 'invalid ID '
            ]);
        }
        $count = 0 ;
        foreach ($medicines as $medicine){
            if($medicine['category_id'] == $id){
                $data[$count] = $medicine ;
                $count += 1 ;
            }
        }
        return response()->json([
           'status' => 1 ,
           'data' => $data ,
           'message' => 'all the Item for the category with id  : ' .$id ,
        ]);
    }
}
