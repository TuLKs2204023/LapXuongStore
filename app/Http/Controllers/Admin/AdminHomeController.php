<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        if(auth()->user()->role == 'Admin')

            return view('admin.dashboard');

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
        return redirect()->route('feHome');
    }
}
