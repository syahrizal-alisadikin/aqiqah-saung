<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
class OrderController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            if(auth()->user()->roles == "ADMIN"){
                $orders = Order::with('user')
                                ->latest();
                }else{
                $orders = Order::where('user_id', auth()->user()->id)
                                ->latest();

                }
            
            return Datatables::of($orders)
                ->addIndexColumn()
                ->addColumn('harga', function ($data) {
                    return moneyFormat($data->harga);
                
                })
                ->rawColumns(["harga"])
                ->make(true);
        }
        return view('admin.orders.index');
    }

    public function create()
    {
        $users = User::where('roles','USER')->get();
        $products = Product::all();
        return view('admin.orders.create',compact('users','products'));
    } 
}
