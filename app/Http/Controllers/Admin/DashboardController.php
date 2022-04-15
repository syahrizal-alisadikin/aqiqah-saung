<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->roles == "ADMIN"){
            $quantity = Order::where('status' != "PENDING")->sum('quantity');
            $totalMonth = Order::where('status' != "PENDING")->whereMonth('created_at',date('m'))->sum('total_harga');
            $totalYears = Order::where('status' != "PENDING")->whereYear('created_at',date('Y'))->sum('total_harga');
        }else{
            $quantity = Order::where('user_id',Auth::user()->id)->sum('quantity');
            $totalMonth = Order::where('user_id',Auth::user()->id)->where('status' != "PENDING")->whereMonth('created_at',date('m'))->sum('total_harga');
            $totalYears = Order::where('user_id',Auth::user()->id)->where('status' != "PENDING")->whereYear('created_at',date('Y'))->sum('total_harga');

        }
        return view('admin.dashboard',compact('quantity','totalMonth','totalYears'));
    }

   
}
