<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function Allorders()
    {
        $all = DB::table('orders')->get();



        return view('admin.oders.allorders', compact('all'));
    }

    public function userAllOrders()
    {
        $user = auth()->user();
        if ($user) {
            $uId = $user->id;
            $orders = Order::where('user_id', $uId)->orderByDesc('id')->get();
            return view('fe.home.userOrders', compact('orders'));
        } else {
            return redirect()->route('login');
        }
    }


    public function afterCheckOut()
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->get()->last();
        $orderItems = OrderDetail::where('order_id', $order->id)->get();
        return view('fe.home.orderDetails', compact('order', 'orderItems'));
    }

}
