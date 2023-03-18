<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\FE\HomeController;
use App\Http\Traits\ProcessMail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Http\Traits\ProcessModelData;
use App\Models\Promotion;

class CheckoutController extends HomeController
{
    use ProcessModelData;
    use ProcessMail;

    public function checkout()
    {
        $total = HomeController::totalCart();
        $res = array(
            'totalAmt' => $total['value'],
            'totalVal' => number_format($total['value'], 0, ',', '.'),
            'totalQty' => $total['qty']
        );
        return view('fe.home.checkOut', compact('res'));
    }

    public function couponCheck(Request $request)
    {
        $code = $request->couponCode;
        $coupon = Promotion::where('code', $code)->first();
        if ($coupon === null) {
            return array('status' => null);
        }
        if (!$coupon->isAvailable()) {
            return array('status' => false);
        }
        return array(
            'status' => 'success',
            'coupon' => $coupon
        );
    }

    public function processCheckout(Request $request)
    {
        if (session('cart')) {
            // Check out-of-stock
            $cart = collect(session('cart'));
            $errors =
                $cart->filter(function ($item, $key) {
                    $stock = $this->stockBalance($item->product, $item->quantity);
                    return $stock < 0;
                })->map(function ($item, $key) {
                    return '"' . $item->product->name . '" is currently out-of-stock.';
                })->toArray();
            if (count($errors) > 0) {
                return back()->withErrors($errors);
            }

            // Save Order
            $orderInfo = $request->all();
            $orderInfo['order_date'] = date('Y-m-d H:i:s', time());
            $orderInfo['user_id'] = auth()->user()->id;
            $order = Order::create($orderInfo);

            // Save Coupon
            $res = $this->couponCheck($request);
            if ($res['status'] === 'success') {
                $coupon = $res['coupon'];
                $order->usedPromotion()->create(['promotion_id' => $coupon->id]);
                $order->refresh();
                $order->usedPromotion->promotion->status = 0;
                $order->push();
            }

            // Save Order Details
            $details = [];
            foreach ($cart as $item) {
                // Out stock
                $proData['out_qty'] = $item->quantity;
                $stock = $this->processOutStock($item->product, $proData);

                $details[] = [
                    'product_id' => $item->product->id,
                    'quantity' => $item->quantity,
                    'stock_id' => $stock->id,
                ];

                // $orderDetail = new OrderDetail();
                // $orderDetail->product_id = $item->product->id;
                // $orderDetail->price = $item->product->price;
                // $orderDetail->quantity = $item->quantity;
                // $order->details()->save($orderDetail);
            }
            $order->details()->createMany($details);
            $this->completeOrder($order);
            $this->clearCart();
            return view('fe.home.thankyou');
        } else {
            $errors = ['msg' => 'Your cart is currently empty.'];
            if (count($errors) > 0) {
                return back()->withErrors($errors);
            }
        }
    }
}
