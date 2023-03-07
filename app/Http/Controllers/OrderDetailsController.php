<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderDetailsController extends Controller
{
    public function adminRights(Request $request){
        $orderId = $request->id;
        $orderItems = OrderDetail::where('order_id', $orderId)->get();
        return view('admin.oders.orderDetails', compact('orderItems'));
    }

    public function userRights(Request $request){
        $orderId = $request->id;
        if($orderId){
            $orderItems = OrderDetail::where('order_id', $orderId)->get();
            return view('fe.home.orderDetails', compact('orderItems'));
        }
        else{
            return 'Order giùm tao cái, không mua mà thích coi hả bưởi.';
        }
    }
}
