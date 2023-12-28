<?php

namespace App\Http\Controllers\Api\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\MedicineCollection;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Medicine;
use App\Models\Warehouse;
use App\Traits\HttpResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    use HttpResponses;
    public function __construct(){
        $this->middleware('User_Role') ;
    }
    public function AddToCart(Request $request) : JsonResponse
    {
        $request->validate([
           'medicine_id' => 'required' ,
        ]);

        $user = $request->user() ;
        $medicine = Medicine::query()->where('id' , '=' , $request['medicine_id']);

        if(!$medicine->exists()){
            $message = 'invalid';
            return $this->error([] , $message , 404) ;
        }

        $medicines = Medicine::query()->where('id' , '=' , $request['medicine_id'])->first();

        $cart = Cart::query()->where('user_id' , '=' , $user['id'])->first();

        $cartItem = CartItem::query()->where('cart_id' , '=' , $cart['id'])
                                     ->where('medicine_id' , '=' , $medicines['id']);
        if($cartItem->exists()){
            $message = 'you have already added it ' ;
            return $this->error([] , $message , 400);
        }

        $cartItem = CartItem::query()->create([
           'cart_id' => $cart['id']  ,
           'medicine_id' => $medicines['id'],
        ]);

        $message  = 'add successfully' ;
        return $this->success([] , $message);


    }

    public function ShowCartItem(Request $request)
    {

        $user = $request->user() ;

        $cart = Cart::query()->where('user_id' , '=' , $user['id'])->first();
        if(!$cart){
            $message = 'invalid' ;
            return $this->error([] , $message , 404);
        }
        $cartItems = CartItem::query()->where('cart_id' , '=' , $cart['id'])->get();

        if(count($cartItems) == 0){
            $message = 'empty cart';
            return $this->error([] , $message , 400);
        }
        $medicines = [] ;
        $count = 0 ;
        foreach ($cartItems as $cartItem)
        {
            $medicine = Medicine::query()->where('id' ,  '=', $cartItem['medicine_id'])->first();
            $medicines[$count] = $medicine ;
            $medicines[$count]['cartItem_id'] = $cartItem['id'];
            $count++;
        }

        $data = new MedicineCollection($medicines) ;
        $message = 'all Cart Item ' ;
        return $this->success($data , $message);


    }

    //todo : WTF fix this please :
    public function EditCartItemQuantity(Request $request) : JsonResponse
    {
        $request->validate([
           'warehouse_id' => 'required' ,
           'medicine_id' => 'required' ,
           'quantity' => 'required' ,
        ]);

        $user = $request->user() ;

        $warehouse = Warehouse::query()->where('id' , '=' , $request['warehouse_id'])->first() ;
        if(!$warehouse){
            return response()->json([
                'status' => 0 ,
                'data' => [] ,
                'message' => 'invalid warehouse_id :)',
            ]) ;
        }
        $cart = Cart::query()->where('user_id' , '=' , $user['id']) ;

        $cartItem = CartItem::query()->where('cart_id' , '=' , $cart['id'])
                              ->where('medicine_id' , '=' , $request['medicine_id']);

        if(!$cartItem){
            return response()->json([
                'status' => 0 ,
                'data' => [] ,
                'message' => 'invalid cartItem :)',
            ]) ;
        }
        $medicine = Medicine::query()->where('id' , '=' , $request['medicine_id'])->first();
        $quantity = $medicine['quantity_available'] ;

        if($quantity < $request['quantity']){
            return response()->json([
                'status' => 0 ,
                'data' => [] ,
                'message' => 'the available quantity is : ' . $quantity,
            ]) ;
        }

        $cartItem->update([
           'quantity' => $request['quantity'],
           'total_price' => $request['quantity'] * $medicine['price'] ,
        ]);

        return response()->json([
           'status' => 1 ,
           'data' => $cartItem,
           'message' => 'updated successfully' ,
        ]);
    }


    public function deleteCartItem(Request $request) : JsonResponse
    {
        $user = $request->user() ;
        //cartItem_id ;
        $id = $request->route('ID');
        $cart = Cart::query()->where('user_id' , '=' , $user['id'])->first();
        $cartItem = CartItem::query()->where('id' , '=' , $id)->first();

        if($cart['id'] != $cartItem['cart_id']){
            $message = 'Unauthorized';
            return $this->error([] , $message , 401);
        }

        $cartItem->delete() ;
        $message = 'cartItem has been deleted successfully';
        return $this->success([],$message);
    }
}
