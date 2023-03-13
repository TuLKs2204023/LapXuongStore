<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Traits\ProcessModelData;
use App\Models\HistoryUser;
use App\Models\Order;
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
        if
        (auth()->user()->role == 'Admin'){
            $now= Carbon::now();
            $time=auth()->user()->created_at;
            $duration= $this->duration($now, $time);
            $allproduct = Product::all();
            $history= HistoryUser::all();
            $order= Order::all();
            $totalUser= DB::table('users')->where('role','Customer')->where('created_at','>',$now->subDays(30))->count();
            $totalProduct= DB::table('products')->count();
            $totalItem= DB::table('order_details')->where('created_at','>',$now->subDays(30))->count();

            return view('admin.dashboard', compact('totalUser','totalProduct','totalItem','allproduct','order','history','time','duration'));
        }

        else{
            return redirect()->route('fe.home');
        }
    }
    public function manager()
    {
        $order= Order::all();
        $history= HistoryUser::all();
        $allproduct = Product::all();
        $top= DB::table('stocks')->get()->sortByDesc('out_qty');
        return view('admin.dashboard',compact('allproduct','top','order','history'));

    }
    public function customer()
    {

        return view('fe.home.profile');

    }

    public function backFromError(){
        return redirect()->route('fe.home');
    }
}
