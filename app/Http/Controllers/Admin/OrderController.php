<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        return view('admin.orders.create');
    } 
}
