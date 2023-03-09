<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;


class AdminHomeController extends Controller
{
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
            $allproduct = Product::all();

            $order= Order::all();
            $totalUser= DB::table('users')->where('role','Customer')->where('created_at','>',$now->subDays(30))->count();
            $totalProduct= DB::table('products')->count();
            $totalItem= DB::table('order_details')->where('created_at','>',$now->subDays(30))->count();

            return view('admin.dashboard', compact('totalUser','totalProduct','totalItem','allproduct','order'));
        }

        else{
            return redirect()->route('fe.home');
        }
    }
    public function manager()
    {
        $allproduct = Product::all();
        $top= DB::table('stocks')->get()->sortByDesc('out_qty');
        return view('admin.dashboard',compact('allproduct','top'));

    }
    public function customer()
    {

        return view('fe.home.profile');

    }

    public function backFromError(){
        return redirect()->route('fe.home');
    }
}
