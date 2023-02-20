<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        
        return view('fe.home.index');
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->get()->first();
        return view('fe.home.product', compact('product'));
    }

    public function addCart(Request $request)
    {
        $pid = $request->pid;
        $qty = $request->quantity;

        $product = Product::find($pid);
        $cartItem = new CartItem($product, $qty);

        if (session('cart')) {
            $cart = session('cart');
        } else {
            $cart = [];
        }

        $existedKey = null;
        if ($cart) {
            foreach ($cart as $cartKey => $cartVal) {
                if ($cartKey == $pid) {
                    $existedKey = $cartKey;
                    break;
                }
            }
        }

        if ($existedKey) {
            if ($cart[$existedKey]->quantity !== $qty) {
                $cart[$existedKey]->quantity = $qty;
            }
        } else {
            $cart[$pid] = $cartItem;
            session()->put('cart', $cart);
        }

        $total = HomeController::totalCart();

        $res = array(
            'key' => $existedKey,
            'totalQty' => $total['qty']
        );
        return $res;
    }

    public function updateCart(Request $request)
    {
        $cart = session('cart');
        if (!$cart) {
            return false;
        }

        $key = $request->pid;
        $qty = $request->quantity;

        $cart[$key]->quantity = $qty;
        $value = $qty * $cart[$key]->product->price;

        $total = HomeController::totalCart();

        $res = array(
            'curVal' => number_format($value, 0, ',', '.'),
            'totalVal' => number_format($total['value'], 0, ',', '.'),
            'totalQty' => $total['qty']
        );
        return $res;
    }

    public function viewCart(Request $request)
    {
        $total = HomeController::totalCart();
        return view('fe.home.viewCart', ['total' => $total]);
    }

    public static function totalCart()
    {
        $total = array('value' => 0, 'qty' => 0);
        if (session('cart')) {
            $total = array_reduce(session('cart'), function ($values, $current) {
                $values['value'] += $current->product->price * $current->quantity;
                $values['qty'] += $current->quantity;
                return $values;
            }, $total);
        }
        return $total;
    }

    public function removeCart(Request $request)
    {
        $cart = session('cart');
        $key = $request->pid;
        if ($cart) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        $total = HomeController::totalCart();
        $res = array(
            'totalVal' => number_format($total['value'], 0, ',', '.'),
            'totalQty' => $total['qty']
        );
        return $res;
    }

    public function clearCart()
    {
        session()->forget('cart');
    }

    public function checkout()
    {
        $total = HomeController::totalCart();
        $res = array(
            'totalVal' => number_format($total['value'], 0, ',', '.'),
            'totalQty' => $total['qty']
        );
        return view('fe.home.checkout', compact('res'));
    }

    public function processCheckout(Request $request)
    {
        if (session('cart')) {
            // Save Order
            $orderInfo = $request->all();
            $orderInfo['order_date'] = date('Y-m-d', time());
            $orderInfo['user_id'] = session('user')->id;
            $order = Order::create($orderInfo);

            // Save Order Details
            $cart = session('cart');
            $details = [];
            foreach ($cart as $item) {
                $details[] = [
                    'product_id' => $item->product->id,
                    'price_id' => $item->product->price_id,
                    'quantity' => $item->quantity,
                ];

                // $orderDetail = new OrderDetail();
                // $orderDetail->product_id = $item->product->id;
                // $orderDetail->price = $item->product->price;
                // $orderDetail->quantity = $item->quantity;
                // $order->details()->save($orderDetail);
            }

            $order->details()->createMany($details);

            $this->clearCart();
            return view('fe.thankyou');
        }
    }

    public function displayCheckout()
    {
        // $orders = Order::withCount('details')->get();
        // foreach ($orders as $order) {
        //     echo 'OrderID: ' . $order->id . ' - Details records: ' . $order->details_count . ' <br> ';
        // }

        // $user = User::find(3);
        // dd($user->latestOrder);

        $product = Product::find(1);
        $images = $product->images;
        dd($images);
        foreach($images as $image) {
            echo $image->url;
        }
    }

    public function contact(){
        return view('fe.home.contact');
    }

    public function shop(){
        $products = Product::all();
        return view('fe.home.shop', compact('products'));
    }

}
