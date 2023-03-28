<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\HistoryProduct;
use App\Models\HistoryUser;
use App\Models\Cates\Manufacture;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Rating;
use App\Models\Stock;
use Carbon\Carbon;
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
        if (auth()->user()->role == 'Admin') {

            // reccent orders of LapXuongStore
            $order = OrderDetail::orderBy('id', 'desc')->limit(10)->get();
            // create reports for top product sales
            $allproduct = Product::orderBy('id', 'desc')->limit(10)->get();
            // user activity
            $history = HistoryUser::orderBy('id', 'desc')->limit(10)->get();
            //product changes
            $historyProduct = HistoryProduct::orderBy('id', 'desc')->limit(10)->get();
            
            //warning if yesterday no orders
            $orderWarning = Order::where('created_at', '>', Carbon::yesterday())
                ->where('created_at', '<', Carbon::today())
                ->get();
            // dd($orderWarning);

            //warning if yesterday no history of user activity
            $userWarning = HistoryUser::where('created_at', '>', Carbon::yesterday())
                ->where('created_at', '<', Carbon::today())
                ->get();
            // dd($userWarning);

            //warning if yesterday no history of product
            $productWarning = HistoryProduct::where('created_at', '>', Carbon::yesterday())
                ->where('created_at', '<', Carbon::today())
                ->get();
            //dd($productWarning);

            //dataManu for pie
            $dataManu = [];
            $manufactures = Manufacture::orderBy('id', 'DESC')->get();
            foreach ($manufactures as $key => $manu) {
                $name = $manu->name;
                $value = $manu->products->count();
                $dataManu[] = (object) ['name' => $name, 'value' => $value];
            }

            // Data daytime for the chart
            $dayData = [];
            $dayData[0] = Carbon::today()->addDays();
            $dayData[1] = Carbon::today();
            for ($i = 1; $i <= 5; $i++) {
                $day = Carbon::today()->subDays($i);
                $dayData[$i + 1] = $day;
            }
            // dd($dayData);
            //  End Data daytime for the chart

            // Data amount sale of products for the chart
            $productData = [];

            $proToday = OrderDetail::all()->where('created_at', '>', Carbon::today());
            $countTo = 0;
            foreach ($proToday as $key => $val) {
                    $count = $val->PrintQuantity();
                    $countTo += $count;
            }
            $productData[0] = $countTo;
            $proYes = OrderDetail::all()
                ->where('created_at', '>', Carbon::yesterday())
                ->where('created_at', '<', Carbon::today());
            $countYes = 0;
            foreach ($proYes as $key => $val) {
                    $count = $val->printQuantity();
                    $countYes += $count;
            }
            $productData[1] = $countYes;

            for ($i = 1; $i <= 5; $i++) {
                $data = OrderDetail::all()
                    ->where('created_at', '>', Carbon::yesterday()->subDays($i))
                    ->where('created_at', '<', Carbon::today()->subDays($i));
                $countPro = 0;
                foreach ($data as $key => $val) {
                        $count = $val->printQuantity();
                        $countPro += $count;
                }
                $productData[$i + 1] = $countPro;
            }

            // dd($productData);
            // End Data product for the chart


            //  Data revenue for the chart
            $revenue = [];
            $today = OrderDetail::all()->where('created_at', '>', Carbon::today());
            // dd($today);
            $revToday = 0;
            foreach ($today as $key => $val) {
                    $rev = $val->printRevenue();
                    $revToday += $rev;
            }
            // dd($revToday);
            $revenue[0] = $revToday;
            $yesDay = OrderDetail::all()
                ->where('created_at', '>', Carbon::yesterday())
                ->where('created_at', '<', Carbon::today());

            $revYesDay = 0;
            foreach ($yesDay as $key => $val) {
                    $rev = $val->printRevenue();
                    $revYesDay += $rev;

            }
            $revenue[1] = $revYesDay;
            // dd($revenue);
            for ($i = 1; $i <= 5; $i++) {
                $out = OrderDetail::all()
                    ->where('created_at', '>', Carbon::yesterday()->subDays($i))
                    ->where('created_at', '<', Carbon::today()->subDays($i));
                if (!$out) {
                    $revenue[$i] = '0';
                } else {
                    $revP = 0;
                    foreach ($out as $key => $val) {
                            $rev = $val->printRevenue();
                            $revP += $rev;
                    }
                }
                $revenue[$i + 1] = $revP;
            }
            // dd($revenue);
            // End data revenue for the chart

            // Data interaction for the chart
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

            for ($i = 1; $i <= 5; $i++) {
                $data = DB::table('ratings')
                    ->where('created_at', '>', Carbon::yesterday()->subDays($i))
                    ->where('created_at', '<', Carbon::today()->subDays($i))->get();
                if (!$data) {
                    $data == '0';
                } else {
                    $data = DB::table('ratings')
                        ->where('created_at', '>', Carbon::yesterday()->subDays($i))
                        ->where('created_at', '<', Carbon::today()->subDays($i))->sum('count');
                }
                $interaction[$i + 1] = $data;
            }
            // dd($interaction,$productData);
            // end interaction

            // count customer for 1 month
            $totalUser = DB::table('users')
                ->where('role', 'Customer')
                ->where('created_at', '>', Carbon::today()->subDays(30))
                ->count();
            //dd($totalUser);

            //count order for 1 month
            $totalItem = DB::table('order_details')
                ->where('created_at', '>', Carbon::today()->subDays(30))
                ->count();
            //dd($totalItem);

            //count all product
            $totalProduct = DB::table('products')->count();
            //dd($totalProduct);

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
                'orderWarning',
                'userWarning',
                'productWarning',
            ));
        }
        elseif(auth()->user()->role == 'Manager'){
            $products = Product::all();
            return view('admin.product.index', compact('products'));
        }
        else {
            return redirect()->route('admin.backFromError');
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
        return view('wrongRole.wrongRole');
    }
}
