<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    public function adminRights(Request $request){
        $orderId = $request->id;
        $orderItems = OrderDetail::where('order_id', $orderId)->get();
        $order = Order::find($orderId);
        return view('admin.oders.orderDetails', compact('orderItems', 'order'));
    }

    public function userRights(Request $request){
        $orderId = $request->id;
        if($orderId){
            $order = Order::find($orderId);
            $orderItems = OrderDetail::where('order_id', $orderId)->get();
            return view('fe.home.orderDetails', compact('orderItems', 'order'));
        }
        else{
            return 'Order giùm tao cái, không mua mà thích coi hả bưởi.';
        }
    }
}
