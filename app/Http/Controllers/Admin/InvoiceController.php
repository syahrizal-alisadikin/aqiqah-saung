<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::with('products.product')->paginate(10);

        $products = Product::all();

        return view('admin.invoices.index', compact('products', 'invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Create a new invoice
        $invoice = Invoice::create([
            'supplier' => $request->supplier,
            'total' => $request->total,
        ]);

        // Create a new invoice product
        foreach ($request->product_id  as $data => $product) {
            $invoice->products()->create([
                'product_id' => $product,
                'qty' => $request->quantity[$data],
                'harga' => $request->harga[$data], // price per unit
            ]);
            $increment = Product::find($product)->increment('stock', $request->quantity[$data]);
        }
        activity(auth()->user()->name)->log('Menambah Invoice  '.$invoice->supplier);

        return redirect()->route('invoice.index')->with('success', 'Invoice berhasil disimpan!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
