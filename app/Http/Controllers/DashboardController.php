<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function lastweek(){
        $now= Carbon::now();

        // for($i = 0; $i < 7;$i++)
        // {

        //     $user= DB::table('users')->where('role','Customer')->where('created_at',$now->subDays($i))->count();
        //     dd($user);
        //     $total= $total + $user;
        // }
        $user= DB::table('users')->where('role','Customer')->where('created_at','>',$now->subDays(7))->count();
       

            return view('admin.dashboard', compact('user'));
    }
}
