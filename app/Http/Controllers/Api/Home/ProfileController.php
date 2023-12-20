<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineCollection;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function __construct(){
        $this->middleware('User_Role') ;
    }
    public function GetUserData(Request $request): JsonResponse
    {
        $userData = $request->user();

        $cart = Cart::query()->where('user_id' , '=' , $userData['id'])->first();

        $data = [
            'user' => $userData ,
            'cart_id' => $cart['id'] ,
        ] ;

        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => 'User data',
        ]);
    }

    public function addFavorite(Request $request): JsonResponse
    {
        $id = $request['medicine_id'] ;
        $user = $request->user();
        $medicine = Medicine::query()->find($id);

        if (!$medicine) {
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'invalid',
            ]);
        }
        $favorite = Favorite::query()->where('user_id' , '=' , $user['id'] )
                                     ->where('medicine_id' , '=' , $id)->first();
        if($favorite){
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'it is already in favorite',
            ]);
        }

        Favorite::query()->create([
            'user_id' => $user['id'],
            'medicine_id' => $id,
        ]);

        return response()->json([
            'status' => 1,
            'data' => [],
            'message' => 'add successfully',
        ]);
    }

    public function GetFavorite(Request $request): JsonResponse
    {
        $data = [];
        $user = $request->user();
        $favorites = Favorite::query()->where('user_id', '=', $user['id'])->get();

        if (!$favorites) {
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'you do not have any Favorites items :)',
            ]);
        }

        $count = 0 ;
        foreach ($favorites as $favorite) {
            $medicine = Medicine::query()->find($favorite['medicine_id']);
            $data[$count] = $medicine;
            $count += 1;
        }

        $data = new MedicineCollection($data) ;

        return response()->json([
            'status' => 1,
            'data' => $data,
            'message' => 'all Favorites',
        ]);

    }

    public function DeleteFavorite(Request $request) : JsonResponse
    {
        $request->validate([
            'medicine_id' => 'required' ,
        ]);
        $user = $request->user() ;
        $medicine = Medicine::query()->find($request['medicine_id']) ;
        if(!$medicine){
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'invalid..... :)',
            ]);
        }
        $favorite = Favorite::query()->where('user_id' , '=' , $user['id'])
                                     ->where('medicine_id' , '=' , $medicine['id']);
        if(!$favorite){
            return response()->json([
                'status' => 0,
                'data' => [],
                'message' => 'already not exist..... :)',
            ]);
        }

        $favorite->delete();

        return response()->json([
           'status' => 1 ,
           'data'  => [] ,
           'message' => 'deleted successfully' ,
        ]);

    }
}

