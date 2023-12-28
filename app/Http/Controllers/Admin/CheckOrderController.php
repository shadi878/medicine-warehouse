<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\HttpResponses;
use App\Traits\ReturnDataName;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckOrderController extends Controller
{
    use HttpResponses  , ReturnDataName;
    public function __construct(){
        $this->middleware('Admin_Role') ;
    }

    public function GetAllWarehouseOrder(Request $request) : JsonResponse
    {
        $admin = $request->user() ;
        $orders = Order::query()->where('warehouse_id' , '=' , $admin['warehouse_id'])
            ->orderByDesc('order_date')->get();

        if(count($orders) == 0 ){
            $message = 'there is no order';
            return $this->error([] ,$message , 404);
        }

        $count = 0 ;
        foreach ($orders as $order){
            $orders[$count]['warehouse'] = $this->WarehouseName($order['warehouse_id']);
            $orders[$count]['user'] = $this->UserName($order['user_id']);
            $count++;
        }

        $message =' your orders .. ';
        return $this->success($orders , $message);
    }

    public function CheckOrderStatus(Request $request)
    {

    }

    public function ChangeOrderStatus(Request $request)
    {

    }

}
