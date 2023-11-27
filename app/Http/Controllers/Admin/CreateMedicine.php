<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\medicine;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreateMedicine extends Controller
{
    public function create(Request $request) : JsonResponse
    {
        $request->validate([
            'scientific_name' => 'required',
            'trade_name' => 'required',
            'price' => 'required' ,
            'company' => 'required' ,
            'quantity_available' => 'required' ,
            'expiration_date' => 'required' ,
        ]);

        $medicine = medicine::query()->create([
           'scientific_name' => $request['scientific_name'] ,
           'trade_name' => $request['trade_name'] ,
           'price' => $request['price'] ,
           'company' => $request['quantity_available'] ,
           'quantity_available' => $request['quantity_available'] ,
           'expiration_date' => $request['expiration_date'] ,
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

        medicine::query()->where('id' , '=' , $request['id'])->delete() ;

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

         medicine::query()->where('id','=' ,$request['id'])
             ->update([
                 'quantity_available' => $request['quantity']
             ]);
         $newMedicine  = medicine::query()->find($request['id']) ;

        return response()->json([
           'status'  => 1 ,
           'data' => $newMedicine ,
           'message' => 'has been updated successfully ' ,
        ]);
    }


}
