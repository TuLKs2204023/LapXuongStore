<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessMail;
use App\Http\Traits\ProcessModelData;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OdersController extends Controller
{
    use ProcessModelData;
    use ProcessMail;
    //get all orders for admin 
    public function Allorders()
    {
        $all = Order::all()->sortByDesc('id');
        return view('admin.oders.allorders', compact('all'));
    }

    //get orders belong to user
    public function userAllOrders()
    {
        $user = auth()->user();
        if ($user) {
            $uId = $user->id;
            $orders = Order::where('user_id', $uId)->orderByDesc('id')->paginate(10);
            return view('fe.home.userOrders', compact('orders'));
        } else {
            return redirect()->route('login');
        }
    }

    //view order details after checkout successfully
    public function afterCheckOut()
    {
        $user = auth()->user();
        $order = Order::where('user_id', $user->id)->get()->last();
        $orderItems = OrderDetail::where('order_id', $order->id)->get();
        return view('fe.home.orderDetails', compact('order', 'orderItems'));
    }

    //Cancel order
    public function cancelOrder(Request $request)
    {
        $proData = [];
        $oId = $request->oId;
        $order = Order::find($oId);
        try {
            foreach ($order->details as $item) {
                $product = $item->product;
                $proData['in_qty'] = $item->quantity;
                $this->processInStock($product, $proData);
            }
            $order->status = 0;
            $order->push();
            //gởi mail nữa nha
            $this->cancelOrderEmail($order);
            return response()->json([
                'orderMsg' => 'Your order has been cancelled successfully.',
                'emailMsg' => 'An email has just been sent to you.',
                'status' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'orderMsg' => 'Your order cancellation has been dinied.',
                'emailMsg' => 'Failed to send email: ' . $e->getMessage(),
                'status' => false,
            ]);
        }
    }
}
