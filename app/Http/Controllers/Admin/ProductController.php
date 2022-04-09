<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use DataTables;
class ProductController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
           $product = Product::query();
            
            return Datatables::of($product)
                ->addIndexColumn()
                ->addColumn('buy_price', function ($data) {
                    return moneyFormat($data->buy_price);
                
                })
                ->addColumn('sell_price', function ($data) {
                    return moneyFormat($data->sell_price);
                
                })
                ->rawColumns(["sell_price","buy_price"])
                ->make(true);
        }
        return view('admin.product.index');
    }

    public function create()
    {
        return view('admin.product.create');
    }
}
