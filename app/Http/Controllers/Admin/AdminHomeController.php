<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\HistoryProduct;
use App\Models\HistoryUser;
use App\Models\Cates\Manufacture;

use App\Models\Order;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class AdminHomeController extends Controller
{
    use ProcessModelData;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (auth()->user()->role !== 'Customer') {
            $now = Carbon::now();
            $order = Order::all();
            $allproduct = Product::all();
            $history = HistoryUser::all()->sortByDesc('id');
            $historyProduct = HistoryProduct::all()->sortByDesc('id');

            $dataManu = [];
            $manufactures = Manufacture::all();
            foreach ($manufactures as $key => $manu) {
                $name = $manu->name;
                $value = $manu->products->count();
                $dataManu[] = (object)['name' => $name, 'value' => $value];
            }
            $dayData = [];
            for ($i = 0; $i <= 9; $i++) {
                $day = 0;
                // $day=$now->subDays($i);
                $day = Carbon::today()->subDays($i);
                if (!in_array($day, $dayData)) {
                    array_push($dayData, $day);
                }
            }
            $productData = [];
            for ($i = 0; $i <= 9; $i++) {
                $data = 0;
                $data = DB::table('order_details')
                    ->where('created_at', '>', Carbon::today()->subDays($i))
                    ->count();
                if (!in_array($data, $productData)) {
                    array_push($productData, $data);
                }
            }
            $revenue = [];
            $out = Stock::where('created_at', '>', Carbon::today()->subDays(9))->get();
            foreach ($out as $key => $item) {
                $rev = $item->out_qty * isset($item->price->sale) ? $item->price->sale : '0';
                if (!in_array($rev, $revenue)) {
                    array_push($revenue, $rev);
                }
            }
            $interaction = [];
            for ($i = 0; $i <= 9; $i++) {
                $data = 0;
                $data = DB::table('ratings')
                    ->where('created_at', '>', Carbon::today()->subDays($i))
                    ->count();
                if (!in_array($data, $interaction)) {
                    array_push($interaction, $data);
                }
            }








            // for($i=0;$i<=6;$i++) {
            //     $data=0;

            //     if (!in_array($data, $productData)) {
            //         array_push($productData, $data);
            //     }

            // }



            $totalUser = DB::table('users')
                ->where('role', 'Customer')
                ->where('created_at', '>', $now->subDays(30))
                ->count();
            $totalProduct = DB::table('products')->count();
            $totalItem = DB::table('order_details')
                ->where('created_at', '>', $now->subDays(30))
                ->count();

            return view('admin.dashboard', compact(
                'totalUser',
                'totalProduct',
                'totalItem',
                'allproduct',
                'order',
                'history',
                'historyProduct',
                'dataManu',
                'dayData',
                'productData',
                'revenue',
                'interaction',

            ));
        } else {
            return redirect()->route('fe.home');
        }
    }

    public function customer()
    {
        return view('fe.home.profile');
    }

    public function backFromError()
    {
        return redirect()->route('fe.home');
    }
}
