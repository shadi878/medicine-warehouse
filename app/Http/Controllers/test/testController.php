<?php

namespace App\Http\Controllers\test;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class testController extends Controller
{

    //Laravel Get Logged User Data using Auth Facade
    public function user_data(Request $request)
    {
        $user = $request->user() ;
        return $user ;
    }

    public function ware(){
         $warehouse = Auth::user()  ;
         $id = Warehouse::query()->where('id' , '=' , $warehouse['warehouse_id']) ;
         return response()->json([
            'data' => $warehouse,
         ]);
    }


    public function med() {
        $data = Medicine::latestAddition()->get();
        return $data ;
    }

    public function delete(){

        $isExist = '1700553305.jpg' ;
        return File::delete(public_path('storage/image'.$isExist));

    }
}
