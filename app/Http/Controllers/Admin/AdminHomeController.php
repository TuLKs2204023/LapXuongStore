<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\HistoryProduct;
use App\Models\HistoryUser;
use App\Models\Cates\Manufacture;
use App\Models\Order;
use App\Models\Rating;
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
            $order = Order::all()->sortByDesc('created_at');
            $allproduct = Product::all();
            $history = HistoryUser::all()->sortByDesc('id');
            $historyProduct = HistoryProduct::all()->sortByDesc('id');
            $dataManu = [];
            $manufactures = Manufacture::all();
            foreach ($manufactures as $key => $manu) {
                $name = $manu->name;
                $value = $manu->products->count();
                $dataManu[] = (object) ['name' => $name, 'value' => $value];
            }

            $dayData = [];
            $dayData[0] = Carbon::now();
            for ($i = 1; $i <= 6; $i++) {
                $day = Carbon::now()->subDays($i);
                $dayData[$i] = $day;
            }


            $productData = [];
            $proToday = DB::table('stocks')
                ->where('created_at', '>', Carbon::today())
                ->sum('out_qty');
            $productData[0] = $proToday;

            $proYes = DB::table('stocks')
                ->where('created_at', '>', Carbon::yesterday())
                ->where('created_at', '<', Carbon::today())
                ->sum('out_qty');

            $productData[1] = $proYes;

            for ($i = 1; $i < 6; $i++) {
                $data = 0;
                $data = DB::table('stocks')
                    ->where('created_at', '>', Carbon::yesterday()->subDays($i))
                    ->where('created_at', '<', Carbon::today()->subDays($i))
                    ->sum('out_qty');
                $productData[$i + 1] = $data;
            }



            $revenue = [];
            $today = Stock::where('created_at', '>', Carbon::today()->subDays(1))->where('out_qty', '>', 0)->get();

            $revToday = 0;
            foreach ($today as $key => $item) {
                $rev = $item->out_qty * isset($item->price->sale_discounted) ? $item->price->sale_discounted : '0';
                $revToday += $rev;
            }

            $revenue[0] = $revToday;
            $yesDay = Stock::where('created_at', '>', Carbon::today()->subDays(2))
                ->where('created_at', '>', Carbon::today()->subDays(1))
                ->where('out_qty', '>', 0)->get();

            $revYesDay = 0;
            foreach ($yesDay as $key => $item) {
                $rev = $item->out_qty * isset($item->price->sale_discounted) ? $item->price->sale_discounted : '0';
                $revYesDay += $rev;
            }

            $revenue[1] = $revYesDay - $revToday;

            for ($i = 3; $i <= 7; $i++) {

                $out = Stock::where('created_at', '>', Carbon::today()->subDays($i + 1))
                    ->where('created_at', '>', Carbon::today()->subDays($i))
                    ->where('out_qty', '>', 0)->get();
                $revP = 0;

                foreach ($out as $key => $item) {
                    $rev = $item->out_qty * isset($item->price->sale_discounted) ? $item->price->sale_discounted : '0';
                    $revP += $rev;
                    $a[$i] = $revP;
                }
            }
            for ($i = 4; $i <= 8; $i++) {

                $out = Stock::where('created_at', '>', Carbon::today()->subDays($i + 1))
                    ->where('created_at', '>', Carbon::today()->subDays($i))
                    ->where('out_qty', '>', 0)->get();
                $revQ = 0;

                foreach ($out as $key => $item) {
                    $rev = $item->out_qty * isset($item->price->sale_discounted) ? $item->price->sale_discounted : '0';
                    $revQ += $rev;
                    $b[$i] = $revQ;
                }
            }
            for ($i = 2; $i <= 6; $i++) {
                $revenue[$i] = $b[$i + 2] - $a[$i + 1];
            }

            $interaction = [];
            $inteToday = DB::table('ratings')
                ->where('created_at', '>', Carbon::today())
                ->sum('count');
            $inteYes = DB::table('ratings')
                ->where('created_at', '>', Carbon::yesterday())
                ->where('created_at', '<', Carbon::today())
                ->sum('count');

            $interaction[0] = $inteToday;
            $interaction[1] = $inteYes;

            // $data = DB::table('ratings')
            //     ->where('created_at', '>', Carbon::yesterday()->subDays(2))
            //     ->where('created_at', '<', Carbon::today()->subDays(2))->get('count');
            // if (!$data) {
            //     $data = '0';
            // } else {
            //     $data = DB::table('ratings')
            //         ->where('created_at', '>', Carbon::yesterday()->subDays(2))
            //         ->where('created_at', '<', Carbon::today()->subDays(2))->sum('count');
            // }

            // dd($data);

            //

            for ($i = 2; $i <= 6; $i++) {
                $data = DB::table('ratings')
                    ->where('created_at', '>', Carbon::yesterday()->subDays($i))
                    ->where('created_at', '<', Carbon::today()->subDays($i))
                    ->get('created_at');
                if (!$data) {
                    $data = 0;
                    break;
                } else {
                    $data = DB::table('ratings')
                        ->where('created_at', '>', Carbon::yesterday()->subDays(1))
                        ->where('created_at', '<', Carbon::today()->subDays(1))->sum('count');
                }

                $interaction[$i] = $data;
            }


            

            $totalUser = DB::table('users')
                ->where('role', 'Customer')
                ->where('created_at', '>', $now->subDays(30))
                ->count();
            $totalProduct = DB::table('products')->count();
            $totalItem = DB::table('order_details')
                ->where('created_at', '>', $now->subDays(30))
                ->count();

            return view('admin.dashboard', compact('totalUser', 'totalProduct', 'totalItem', 'allproduct', 'order', 'history', 'historyProduct', 'dataManu', 'dayData', 'productData', 'revenue', 'interaction'));
        } else {
            return redirect()->route('fe.home');
        }
    }

    public function customer()
    {
        return view('fe.home.profile');
    }
    public function historyProduct()
    {
        $hisPro = HistoryProduct::all()->sortByDesc('id');
        return view('admin.users.product-history', compact('hisPro'));
    }
    public function backFromError()
    {
        return redirect()->route('fe.home');
    }
}
