<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            $totalUser= DB::table('users')->where('role','Customer')->where('created_at','>',$now->subDays(30))->count();
            $totalProduct= DB::table('products')->count();
            $totalItem= DB::table('order_details')->where('created_at','>',$now->subDays(30))->count();

            return view('admin.dashboard', compact('totalUser','totalProduct','totalItem'));
        }

        else{
            return redirect()->route('fe.home');
        }
    }
    public function manager()
    {

        return view('admin.dashboard');

    }
    public function customer()
    {

        return view('fe.home.profile');

    }

    public function backFromError(){
        return redirect()->route('fe.home');
    }
}
