<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HargaRekanan;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
class ProductController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
           $product = Product::query();
            
            return Datatables::of($product->get())
                ->addIndexColumn()
                ->addColumn('buy_price', function ($data) {
                    return moneyFormat($data->buy_price);
                
                })
                ->addColumn('sell_price', function ($data) {
                    return moneyFormat($data->sell_price);
                
                })
                ->addColumn('stock_sakit', function ($data) {
                    return $data->stock_sakit == 0 ? '-' : $data->stock_sakit;
                
                })
                ->addColumn('stock_mati', function ($data) {
                    return $data->stock_mati == 0 ? '-' : $data->stock_mati;
                
                })
                ->addColumn('aksi', function ($data) {
                    $edit = '<a href="'.route('products.edit',$data->id).'"  class="btn btn-primary btn-sm"> Edit </a>';
                    $harga = '<a href="'.route('products.show',$data->id).'"  class="btn btn-danger btn-sm"> Harga Rekanan </a>';

                    return $edit.' '.$harga;
                
                })
                ->rawColumns(["sell_price","buy_price",'aksi'])
                ->make(true);
        }
        return view('admin.product.index');
    }

    public function create()
    {
        return view('admin.product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'jenis' => 'required',
            'description' => 'required',
            'buy_price' => 'required',
            'sell_price' => 'required',
            'stock' => 'required',
        ]);

       $product = Product::create($request->all());
       activity(auth()->user()->name)->log('Menambah Produk  ' . $product->name);

        return redirect()->route('products.index')->with('success', 'Data berhasil disimpan!!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.edit', compact('product'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        $users = User::where('roles','USER')->get();
        return view('admin.product.show', compact('product','users'));
    }

    public function update(Request $request,$id)
    {
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'jenis' => 'required',
            'description' => 'required',
            'buy_price' => 'required',
            'sell_price' => 'required',
            'stock' => 'required',
        ]);
        $product->update($request->all());
        return redirect()->route('products.index')->with('success', 'Data berhasil disimpan!!');

    }

    public function harga(Request $request,$id)
    {
       
        foreach ($request->user_id as $key => $value) {
             $harga = HargaRekanan::updateOrCreate(
            ['product_id' => $id,'user_id' => $value],
            ['harga' => $request->harga[$key], 'user_id' => $value]
            );
        }
       
        return redirect()->route('products.show',$id)->with('success', 'Data berhasil disimpan!!');
    }
}
