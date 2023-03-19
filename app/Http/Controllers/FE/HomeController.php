<?php

namespace App\Http\Controllers\FE;

use App\Http\Controllers\Controller;
use App\Models\HistoryRating;
use App\Models\HistoryUser;
use App\Models\Rating;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\CartItem;
use App\Models\Cates\Demand;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user=User::all();
        $demands = Demand::all();
        $officeProducts = Product::where('demand_id', 1)->get();
        $gamingProducts = Product::where('demand_id', 2)->get();
        $productsHighRate = Product::selectRaw('products.*, COUNT(ratings.id) as ratings_count, ROUND(AVG(ratings.rate), 2) as avg_rating')
            ->leftJoin('ratings', 'products.id', '=', 'ratings.product_id')
            ->groupBy(
                'products.id',
                'products.name',
                'products.slug',
                'products.manufacture_id',
                'products.cpu_id',
                'products.ram_id',
                'products.ssd_id',
                'products.hdd_id',
                'products.screen_id',
                'products.resolution_id',
                'products.series_id',
                'products.demand_id',
                'products.gpu_id',
                'products.color_id',
                'products.created_at',
                'products.updated_at',
            )
            ->havingRaw('AVG(ratings.rate) > 4')
            ->orderByDesc('avg_rating')
            ->limit(10)
            ->get();

        // dd($productsHighRate);
        return view('fe.home.index', compact('demands', 'officeProducts', 'gamingProducts', 'productsHighRate','user'));
    }

    public function product($slug)
    {   $user=User::all();
        $product = Product::where('slug', $slug)->first();
        $ratings = $product->ratings->sortByDesc('id');
        return view('fe.home.product', compact('product', 'ratings','user'));
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
        if ($existedKey) {
            $cart[$existedKey]->quantity += $qty;
        } else {
            $cartItem = new CartItem($product, $qty);
            $cart[$pid] = $cartItem;
            session()->put('cart', $cart);
        }

        // Number of items in Cart
        $total = HomeController::totalCart();

        // Response for HttpRequest
        $res = array(
            'key' => $existedKey,
            'totalQty' => $total['qty'],
            'cartItem' => $cart[$pid],
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

        $cart[$key]->quantity = $qty;
        $value = $qty * $cart[$key]->product->fakePrice();

        $total = HomeController::totalCart();

        $res = array(
            'curVal' => number_format($value, 0, ',', '.'),
            'totalAmt' => $total['value'],
            'totalVal' => number_format($total['value'], 0, ',', '.'),
            'totalQty' => $total['qty'],
            'cartItem' => $cart[$key],
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
                $values['value'] += $current->product->fakePrice() * $current->quantity;
                $values['qty'] += $current->quantity;
                return $values;
            }, $total);
        }
        return $total;
    }

    public function removeCart(Request $request)
    {
        $cart = session('cart');
        $key = $request->id;
        $cartItem = $cart[$key];
        if ($cart) {
            unset($cart[$key]);
            session()->put('cart', $cart);
        }

        $total = HomeController::totalCart();
        $res = array(
            'totalAmt' => $total['value'],
            'totalVal' => number_format($total['value'], 0, ',', '.'),
            'totalQty' => $total['qty'],
            'cartItem' => $cartItem
        );
        return $res;
    }

    public function clearCart()
    {
        session()->forget('cart');
    }

    // Check empty cart
    public function emptyCart(Request $request)
    {
        $cart = session('cart');
        if (!$cart) {
            return [
                'emptyCart' => true,
                'totalQty' => 0,
            ];
        }
        return [
            'route' => route('checkout'),
        ];
    }

    // Check stock availability
    public function stockBalance(Product $product, int $cartQty): int
    {
        return $product->inStock() - $product->outStock() - $cartQty;
    }

    public function contact()
    {
        return view('fe.home.contact');
    }

    public function userProfile()
    {
        $user = auth()->user();
        $rating = HistoryRating::all();

        //warning if yesterday no order

        $ratingWarning = Rating::where('created_at', '>', Carbon::now())
      
        ->where('user_id', $user->id)
        ->get();
        return view('fe.home.profile', compact('user', 'rating','ratingWarning'));
    }
    public function aboutUs()
    {
        return view('fe.home.about-us');
    }
}
