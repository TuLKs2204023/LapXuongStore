<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('fe.home.index');
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)->get()->first();
        $ratings = $product->ratings->sortByDesc('id');
        return view('fe.home.product', compact('product', 'ratings'));
    }

    public function addCart(Request $request)
    {
        // Get request information
        $pid = $request->pid;
        $qty = $request->quantity;

        // Determine current product
        $product = Product::find($pid);

        // Get session 'Cart'
        session('cart') ? $cart = session('cart') : $cart = [];

        // Find current product in session 'Cart'
        $existedKey = null;
        $cartQty = $qty;
        if ($cart) {
            foreach ($cart as $cartKey => $cartVal) {
                if ($cartKey == $pid) {
                    $existedKey = $cartKey;
                    $cartQty += $cart[$existedKey]->quantity;
                    break;
                }
            }
        }

        // Check stock availability
        if ($this->stockBalance($product, $cartQty) < 0) {
            return $res = array(
                'stockBalance' => $this->stockBalance($product, $cartQty),
            );
        }

        // Add Cart Item
        $cartItem = new CartItem($product, $qty);
        if ($existedKey) {
            $cart[$existedKey]->quantity += $qty;
        } else {
            $cart[$pid] = $cartItem;
            session()->put('cart', $cart);
        }

        // Number of items in Cart
        $total = HomeController::totalCart();

        // Response for HttpRequest
        $res = array(
            'key' => $existedKey,
            'totalQty' => $total['qty'],
            'stockBalance' => $this->stockBalance($product, $cartQty),
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

        // Determine current product
        $product = Product::find($key);

        // Check stock availability
        // if (!$this->stockBalance($product, $qty)) {
        //     return $res = array(
        //         'stockBalance' => false,
        //     );
        // }

        $cart[$key]->quantity = $qty;
        $value = $qty * $cart[$key]->product->price;

        $total = HomeController::totalCart();

        $res = array(
            'curVal' => number_format($value, 0, ',', '.'),
            'totalVal' => number_format($total['value'], 0, ',', '.'),
            'totalQty' => $total['qty'],
            'stockBalance' => $this->stockBalance($product, $qty),
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

    // Check stock availability
    private function stockBalance(Product $product, int $cartQty): int
    {
        return $product->inStock() - $product->outStock() - $cartQty;
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
        foreach ($images as $image) {
            echo $image->url;
        }
    }

    public function contact()
    {
        return view('fe.home.contact');
    }

    public function shop()
    {
        $products = Product::all();
        return view('fe.home.shop', compact('products'));
    }

    public function userProfile()
    {
        $user = auth()->user();
        return view('fe.home.profile', compact('user'));
    }
}
