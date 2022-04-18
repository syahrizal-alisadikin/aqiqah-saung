<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {

            if (auth()->user()->roles == "ADMIN") {
                $orders = Order::with('user', 'product')
                    ->whereIn('status', ['PENDING', 'POTONG', 'KIRIM', 'SELESAI', 'LUNAS'])
                    ->when(request('name'), function ($query) {
                        return $query->where('name', 'like', '%' . request('name') . '%');
                    })
                    ->when(request('nama_ayah'), function ($query) {
                        return $query->where('nama_ayah', 'like', '%' . request('nama_ayah') . '%');
                    })
                    ->when(request('ref'), function ($query) {
                        return $query->where('ref', 'like', '%' . request('ref') . '%');
                    })
                    ->when(request('user_id'), function ($query) {
                        return $query->where('user_id', request('user_id'));
                    })
                    ->when(request('created_at'), function ($query) {
                        $time_created   = request('created_at');
                        $arr_date       = explode('-', $time_created);
                        $date_from_trim = trim($arr_date[0]);
                        $date_to_trim   = trim($arr_date[1]);
                        $date_from      = date('Y-m-d', strtotime($date_from_trim));
                        $date_to        = date('Y-m-d', strtotime($date_to_trim));

                        return $query->whereBetween('tanggal_potong', ['' . $date_from . '', '' . $date_to . '']);
                    })
                    ->when(request('status'), function ($query) {
                        return $query->where('status', request('status'));
                    })
                    ->latest();
            } else {
                $orders = Order::where('user_id', auth()->user()->id)
                    ->whereIn('status', ['PENDING', 'POTONG', 'KIRIM', 'SELESAI', 'LUNAS'])
                    ->when(request('name'), function ($query) {
                        return $query->where('name', 'like', '%' . request('name') . '%');
                    })
                    ->when(request('nama_ayah'), function ($query) {
                        return $query->where('nama_ayah', 'like', '%' . request('nama_ayah') . '%');
                    })
                    ->when(request('ref'), function ($query) {
                        return $query->where('ref', 'like', '%' . request('ref') . '%');
                    })
                    ->when(request('user_id'), function ($query) {
                        return $query->where('user_id', request('user_id'));
                    })
                    ->when(request('created_at'), function ($query) {
                        $time_created   = request('created_at');
                        $arr_date       = explode('-', $time_created);
                        $date_from_trim = trim($arr_date[0]);
                        $date_to_trim   = trim($arr_date[1]);
                        $date_from      = date('Y-m-d', strtotime($date_from_trim));
                        $date_to        = date('Y-m-d', strtotime($date_to_trim));

                        return $query->whereBetween('tanggal_potong', ['' . $date_from . '', '' . $date_to . '']);
                    })
                    ->when(request('status'), function ($query) {
                        return $query->where('status', request('status'));
                    })
                    ->with('user', 'product')
                    ->latest();
            }

            return Datatables::of($orders->get())
                ->addIndexColumn()
                ->addColumn('harga', function ($data) {
                    return moneyFormat($data->harga);
                })
                ->addColumn('total_harga', function ($data) {
                    return moneyFormat($data->total_harga);
                })
                ->addColumn('status', function ($data) {
                    if ($data->status == "PENDING") {
                        $status = '<button class="btn btn-warning btn-sm">' . $data->status . '</button>';
                    } elseif ($data->status == "POTONG") {
                        $status = '<button class="btn btn-primary btn-sm">' . $data->status . '</button>';
                    } elseif ($data->status == "BATAL") {
                        $status = '<button class="btn btn-danger btn-sm">' . $data->status . '</button>';
                    } elseif ($data->status == "KIRIM") {
                        $status = '<button class="btn btn-success btn-sm">' . $data->status . '</button>';
                    } elseif ($data->status == "SELESAI") {
                        $status = '<button class="btn btn-info btn-sm">' . $data->status . '</button>';
                    } else {
                        $status = '<button class="btn btn-success btn-sm">' . $data->status . '</button>';
                    }

                    return $status;
                })
                ->addColumn('aksi', function ($data) {
                    $edit = "";
                    if (Auth::user()->roles == "ADMIN") {

                        $edit = '<a href="' . route('orders.edit', $data->id) . '"  class="btn btn-primary btn-sm me-2"> Edit </a>';
                    }
                    if ($data->status == "PENDING") {
                        $aksi = '<a href="javascript:void(0)" onclick="ChangeStatus(this.id)" id="' . $data->id . '" class="btn btn-warning btn-sm"> Potong </a>';
                    } elseif ($data->status == "POTONG") {
                        $aksi = '<a href="javascript:void(0)" onclick="ChangeStatus(this.id)" id="' . $data->id . '" class="btn btn-success btn-sm"> Kirim </a>';
                    } elseif ($data->status == "KIRIM") {
                        $aksi = '<a href="javascript:void(0)" onclick="ChangeStatus(this.id)" id="' . $data->id . '" class="btn btn-success btn-sm"> Selesai </a>';
                    } else {
                        $aksi = "";
                    }

                    $pdf = '<a href="' . route('orders.pdf', $data->id) . '"  class="btn btn-success btn-sm me-2"> <i class="fa fa-download"></i> PDF </a>';
                    return $edit . $aksi . $pdf;
                })
                ->rawColumns(["harga", "aksi", "status"])
                ->make(true);
        }
        $users = User::all();
        return view('admin.orders.index', compact('users'));
    }

    public function create()
    {
        $users = User::where('roles', 'USER')->get();
        $products = Product::all();
        return view('admin.orders.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {

        $user = User::findOrFail($request->user_id ?? Auth::user()->id);
        // Check Stok
        $stock = Product::findOrFail($request->product_id);

        $name = Str::slug($user->name);
        $ref = "PO/" . date('Y-m-d') . "/" . $name . "/" . $this->TrasactionOrder();
        // validate order
        $request->validate([
            'product_id' => 'required',
            'name' => 'required',
            'nama_ayah' => 'required',
            'phone' => 'required',
            'jk' => 'required',
            'harga' => 'required',
            'quantity' => 'required',
            'total_harga' => 'required',
            'tanggal_potong' => 'required',
        ]);

        if ($stock->stock <= 1) {
            return back()->withInput()->with('info', 'Stock Habis Sisa ' . $stock->stock);
        }

        DB::beginTransaction();
        try {

            // create order
            $order = Order::create([
                'user_id' => $request->user_id ?? auth()->user()->id,
                'product_id' => $request->product_id,
                'name' => ucfirst($request->name),
                'nama_ayah' => ucfirst($request->nama_ayah),
                'nama_ibu' => ucfirst($request->nama_ibu),
                'phone' => $request->phone,
                'jk' => $request->jk,
                'harga' => $request->harga,
                'quantity' => $request->quantity,
                'total_harga' => $request->total_harga,
                'tanggal_potong' => $request->tanggal_potong,
                'tanggal_acara' => $request->tanggal_acara,
                'alamat' => $request->alamat,
                'note' => $request->note,
                'ref' => $ref
            ]);
            activity(auth()->user()->name)->log('Menambah Orders  ' . $request->name);
            DB::commit();
            return redirect()->route('orders.index')->with('success', 'data berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('orders.index')->with('error', 'data Gagal disimpan! ' . $e->getMessage());
        }
    }



    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $users = User::where('roles', 'USER')->get();
        return view('admin.orders.edit', compact('order', 'users'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'product_id' => 'required',
            'name' => 'required',
            'nama_ayah' => 'required',
            'phone' => 'required',
            'harga' => 'required',
            'quantity' => 'required',
            'total_harga' => 'required',
            'tanggal_potong' => 'required',
        ]);
        DB::beginTransaction();
        try {

            $order->update([
                'user_id' => $request->user_id ?? auth()->user()->id,
                'product_id' => $request->product_id,
                'name' => ucfirst($request->name),
                'nama_ayah' => ucfirst($request->nama_ayah),
                'nama_ibu' => ucfirst($request->nama_ibu),
                'phone' => $request->phone,
                'jk' => $request->jk,
                'harga' => $request->harga,
                'quantity' => $request->quantity,
                'total_harga' => $request->total_harga,
                'tanggal_potong' => $request->tanggal_potong,
                'tanggal_acara' => $request->tanggal_acara,
                'alamat' => $request->alamat,
                'note' => $request->note,
                'status' => $request->status
            ]);
            activity(auth()->user()->name)->log('Update  Order ' . $order->ref);
            DB::commit();

            return redirect()->route('orders.index')->with('success', 'data berhasil disimpan!!');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Data Gagal di simpan!! ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $order = Order::with('product')->findOrFail($id);

        if ($order->status == "PENDING") {

            $product = Product::findOrFail($order->product_id)->decrement('stock', $order->quantity);

            activity()->log('Update  Stock ' . $order->product->name . ' ' . $order->product->type . ' ' . $order->product->jenis);
        }

        $order->update([
            'status' => request()->status
        ]);

        if ($order) {
            return response()->json([
                'status' => "success",
                'message' => "data berhasil diupdate",
                'data' => $order
            ]);
        } else {
            return response()->json([
                'status' => "error",
                'message' => "data gagal diupdate",
                'data' => null
            ]);
        }
    }

    public function OrderExcel(Request $request)
    {
        if (auth()->user()->roles == "ADMIN") {
            $orders = Order::with('user', 'product')
                ->whereIn('status', ['PENDING', 'POTONG', 'KIRIM', 'SELESAI', 'LUNAS'])
                ->when(request('name'), function ($query) {
                    return $query->where('name', 'like', '%' . request('name') . '%');
                })
                ->when(request('nama_ayah'), function ($query) {
                    return $query->where('nama_ayah', 'like', '%' . request('nama_ayah') . '%');
                })
                ->when(request('ref'), function ($query) {
                    return $query->where('ref', 'like', '%' . request('ref') . '%');
                })
                ->when(request('user_id'), function ($query) {
                    return $query->where('user_id', request('user_id'));
                })
                ->when(request('created_at'), function ($query) {
                    $time_created   = request('created_at');
                    $arr_date       = explode('-', $time_created);
                    $date_from_trim = trim($arr_date[0]);
                    $date_to_trim   = trim($arr_date[1]);
                    $date_from      = date('Y-m-d', strtotime($date_from_trim));
                    $date_to        = date('Y-m-d', strtotime($date_to_trim));

                    return $query->whereBetween('tanggal_potong', ['' . $date_from . '', '' . $date_to . '']);
                })
                ->when(request('status'), function ($query) {
                    return $query->where('status', request('status'));
                })
                ->latest()
                ->get();
        } else {
            $orders = Order::where('user_id', auth()->user()->id)
                ->whereIn('status', ['PENDING', 'POTONG', 'KIRIM', 'SELESAI', 'LUNAS'])
                ->when(request('name'), function ($query) {
                    return $query->where('name', 'like', '%' . request('name') . '%');
                })
                ->when(request('nama_ayah'), function ($query) {
                    return $query->where('nama_ayah', 'like', '%' . request('nama_ayah') . '%');
                })
                ->when(request('ref'), function ($query) {
                    return $query->where('ref', 'like', '%' . request('ref') . '%');
                })
                ->when(request('user_id'), function ($query) {
                    return $query->where('user_id', request('user_id'));
                })
                ->when(request('created_at'), function ($query) {
                    $time_created   = request('created_at');
                    $arr_date       = explode('-', $time_created);
                    $date_from_trim = trim($arr_date[0]);
                    $date_to_trim   = trim($arr_date[1]);
                    $date_from      = date('Y-m-d', strtotime($date_from_trim));
                    $date_to        = date('Y-m-d', strtotime($date_to_trim));

                    return $query->whereBetween('tanggal_potong', ['' . $date_from . '', '' . $date_to . '']);
                })
                ->when(request('status'), function ($query) {
                    return $query->where('status', request('status'));
                })
                ->with('user', 'product')
                ->latest()
                ->get();
        }
        return Excel::download(new OrdersExport($orders), 'order.xlsx');
    }

    public function OrderPdf(Request $request)
    {
        if (auth()->user()->roles == "ADMIN") {
            $orders = Order::with('user', 'product')
                ->whereIn('status', ['PENDING', 'POTONG', 'KIRIM', 'SELESAI', 'LUNAS'])
                ->when(request('name'), function ($query) {
                    return $query->where('name', 'like', '%' . request('name') . '%');
                })
                ->when(request('nama_ayah'), function ($query) {
                    return $query->where('nama_ayah', 'like', '%' . request('nama_ayah') . '%');
                })
                ->when(request('ref'), function ($query) {
                    return $query->where('ref', 'like', '%' . request('ref') . '%');
                })
                ->when(request('user_id'), function ($query) {
                    return $query->where('user_id', request('user_id'));
                })
                ->when(request('created_at'), function ($query) {
                    $time_created   = request('created_at');
                    $arr_date       = explode('-', $time_created);
                    $date_from_trim = trim($arr_date[0]);
                    $date_to_trim   = trim($arr_date[1]);
                    $date_from      = date('Y-m-d', strtotime($date_from_trim));
                    $date_to        = date('Y-m-d', strtotime($date_to_trim));

                    return $query->whereBetween('tanggal_potong', ['' . $date_from . '', '' . $date_to . '']);
                })
                ->when(request('status'), function ($query) {
                    return $query->where('status', request('status'));
                })
                ->latest()
                ->get();
        } else {
            $orders = Order::where('user_id', auth()->user()->id)
                ->whereIn('status', ['PENDING', 'POTONG', 'KIRIM', 'SELESAI', 'LUNAS'])
                ->when(request('name'), function ($query) {
                    return $query->where('name', 'like', '%' . request('name') . '%');
                })
                ->when(request('nama_ayah'), function ($query) {
                    return $query->where('nama_ayah', 'like', '%' . request('nama_ayah') . '%');
                })
                ->when(request('ref'), function ($query) {
                    return $query->where('ref', 'like', '%' . request('ref') . '%');
                })
                ->when(request('user_id'), function ($query) {
                    return $query->where('user_id', request('user_id'));
                })
                ->when(request('created_at'), function ($query) {
                    $time_created   = request('created_at');
                    $arr_date       = explode('-', $time_created);
                    $date_from_trim = trim($arr_date[0]);
                    $date_to_trim   = trim($arr_date[1]);
                    $date_from      = date('Y-m-d', strtotime($date_from_trim));
                    $date_to        = date('Y-m-d', strtotime($date_to_trim));

                    return $query->whereBetween('tanggal_potong', ['' . $date_from . '', '' . $date_to . '']);
                })
                ->when(request('status'), function ($query) {
                    return $query->where('status', request('status'));
                })
                ->with('user', 'product')
                ->latest()
                ->get();
        }
        $pdf = PDF::loadView('admin.orders.order-pdf', compact('orders'));
        return $pdf->stream('orders.pdf');
    }

    public function pdf($id)
    {
        $order = Order::with('user')->findOrFail($id);

        $pdf = PDF::loadView('admin.orders.print-pdf', compact('order'));
        return $pdf->stream('orders.pdf');
    }

    public function TrasactionOrder()
    {
        $get_kode       = DB::table('orders')->limit(1)->orderBy('created_at', 'desc')->get();
        $q              = 0;

        if (count($get_kode) > 0) {
            $kode1      = explode("/", $get_kode[0]->ref);
            $kode       = end($kode1);
            $r          = substr($kode, 1);
            $q          = (int) $r + 1;
        } else {
            $q          = 1;
        }

        return str_pad($q, 3, "0", STR_PAD_LEFT);
    }
}
