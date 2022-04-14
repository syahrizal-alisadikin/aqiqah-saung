<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HargaRekanan;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\DB;

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
                    $edit = '<a href="' . route('products.edit', $data->id) . '"  class="btn btn-primary btn-sm"> Edit </a>';
                    $harga = '<a href="' . route('products.show', $data->id) . '"  class="btn btn-danger btn-sm"> Harga Rekanan </a>';
                    $plush = '<a href="javascript:void(0)" onclick="ShowPlush(this.id)" id="' . $data->id . '"  class="btn btn-success btn-sm me-1"> <i class="fa fa-plus fa-lg"></i> </a>';
                    $info = '<a href="' . route('product-stock', $data->id) . '"   class="btn btn-info btn-sm"> <i class="fa fa-pencil fa-lg"></i> </a>';
                    return $edit . ' ' . $harga . ' ' . $plush . '' . $info;
                })
                ->rawColumns(["sell_price", "buy_price", 'aksi'])
                ->make(true);
        }



        $productType = Product::whereNotNull('stock')
            ->groupBy('jenis')
            ->get('jenis');
        $productSakit = Product::whereNotNull('stock_sakit')
            ->sum('stock_sakit');
        $productMati = Product::whereNotNull('stock_sakit')
            ->sum('stock_mati');
        $products = Product::whereNotNull('stock')
            ->sum('stock');
        return view('admin.product.index', compact('productType', 'products', 'productSakit', 'productMati'));
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

        if ($request->stock_sakit) {
            Stock::create([
                'product_id' => $product->id,
                'status' => "Sakit",
                'quantity' => $request->stock_sakit,
                'tanggal' => date('Y-m-d')
            ]);
        }
        if ($request->stock_mati) {
            Stock::create([
                'product_id' => $product->id,
                'status' => "Mati",
                'quantity' => $request->stock_mati,
                'tanggal' => date('Y-m-d')
            ]);
        }
        if ($request->stock) {
            Stock::create([
                'product_id' => $product->id,
                'status' => "Masuk",
                'quantity' => $request->stock,
                'tanggal' => date('Y-m-d')
            ]);
        }
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
        $users = User::where('roles', 'USER')->get();
        return view('admin.product.show', compact('product', 'users'));
    }

    public function stock($id)
    {
        if (request()->ajax()) {
            $stock = Stock::where('product_id', $id)->with('product');
            return Datatables::of($stock->get())
                ->addIndexColumn()
                ->addColumn('tanggal', function ($data) {
                    return TanggalID($data->tanggal);
                })

                ->rawColumns(["tanggal"])
                ->make(true);
        }
        $product = Product::findOrFail($id);

        return view('admin.product.stock', compact('product'));
    }

    public function update(Request $request, $id)
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
        activity(auth()->user()->name)->log('Update Produk  ' . $product->name);

        return redirect()->route('products.index')->with('success', 'Data berhasil disimpan!!');
    }

    public function harga(Request $request, $id)
    {

        foreach ($request->user_id as $key => $value) {
            $harga = HargaRekanan::updateOrCreate(
                ['product_id' => $id, 'user_id' => $value],
                ['harga' => $request->harga[$key], 'user_id' => $value]
            );
        }
        activity(auth()->user()->name)->log('Update OrCreate Harga Rekanan ');

        return redirect()->route('products.show', $id)->with('success', 'Data berhasil disimpan!!');
    }

    public function StockProduct(Request $request)
    {
        DB::beginTransaction();
        try {
            Stock::create([
                'product_id' => $request->product_id,
                'status' => $request->status,
                'quantity' => $request->quantity,
                'tanggal' => date('Y-m-d')
            ]);
            if ($request->status == "Masuk") {
                $product =  Product::findOrFail($request->product_id)->increment('stock', $request->quantity);
            } elseif ($request->status == "Sakit") {
                $product = Product::findOrFail($request->product_id);
                $product->decrement('stock', $request->quantity);
                $product->increment('stock_sakit', $request->quantity);
            } else {
                $product = Product::findOrFail($request->product_id);
                $product->decrement('stock', $request->quantity);
                $product->increment('stock_mati', $request->quantity);
            }

            activity(auth()->user()->name)->log('Produk Stock ' . $request->status . ' ' . $request->quantity . ' ' . $product->name . ' ' . $product->type . ' ' . $product->jenis);

            DB::commit();
            return redirect()->route('products.index')->with('success', 'data berhasil disimpan!!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'data gagal disimpan!!' . $e->getMessage());
        }
    }
}
