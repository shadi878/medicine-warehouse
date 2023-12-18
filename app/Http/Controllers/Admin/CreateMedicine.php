<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Warehouse;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CreateMedicine extends Controller
{

    public function __construct(){
        $this->middleware('Admin_Role') ;
    }
    public function create(Request $request) : JsonResponse
    {
        $request->validate([
            'scientific_name' => 'required',
            'trade_name' => 'required',
            'price' => 'required' ,
            'company' => 'required' ,
            'quantity_available' => 'required' ,
            'expiration_date' => 'required' ,
            'category_id' => 'required|integer' ,
            'image' => 'image|mimes:png,jpg,jpeg|max:2048',
        ]);

        $warehouse = Auth::user()  ;
        $category_id = Category::query()->find($request['category_id']);

        $imageName = time() . '.' . $request['image']->extension();
        $request['image']->storeAs('images', $imageName);

        $medicine = Medicine::query()->create([
           'scientific_name' => $request['scientific_name'] ,
           'trade_name' => $request['trade_name'] ,
           'price' => $request['price'] ,
           'company' => $request['quantity_available'] ,
           'quantity_available' => $request['quantity_available'] ,
           'expiration_date' => $request['expiration_date'] ,
           'warehouse_id' => $warehouse['warehouse_id'],
           'category_id' => $category_id['id'],
            'image' => $imageName ,

        ]);

        return response()->json([
           'status' => 1 ,
           'data' => $medicine ,
           'message' => 'created successfully' ,
        ]);

    }

    public function delete(Request $request) : JsonResponse
    {
        $request->validate([
            'id' => 'required' ,
        ]);

        $image  = Medicine::query()->where('id' , '=' ,  $request['id']) ;

        File::delete(public_path('storage/image'.$image['image']));

        Medicine::query()->where('id' , '=' , $request['id'])->delete() ;

        return response()->json([
           'status' => 1 ,
           'data' => [] ,
           'message' => 'deleted successfully' ,
        ]);
    }

    public function editQuantity(Request $request) : JsonResponse
    {
        $request->validate([
            'id' => 'required' ,
            'quantity' => 'required' ,
        ]);

         Medicine::query()->where('id','=' ,$request['id'])
             ->update([
                 'quantity_available' => $request['quantity']
             ]);
         $newMedicine  = Medicine::query()->find($request['id']) ;

        return response()->json([
           'status'  => 1 ,
           'data' => $newMedicine ,
           'message' => 'has been updated successfully ' ,
        ]);
    }

    public function editPrice(Request $request) : JsonResponse
    {
        $request->validate([
            'id' => 'required' ,
            'price' => 'required' ,
        ]);

        Medicine::query()->where('id','=' ,$request['id'])
            ->update([
                'price' => $request['quantity']
            ]);
        $newMedicine  = Medicine::query()->find($request['id']) ;

        return response()->json([
            'status'  => 1 ,
            'data' => $newMedicine ,
            'message' => 'has been updated successfully ' ,
        ]);
    }




}
