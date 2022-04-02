<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use DataTables;
class KeuanganController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $pendapatan = Keuangan::where('user_id', auth()->user()->id)
                                    ->where('type',"PENDAPATAN")
                                    ->orderBy('tanggal','DESC')
                                    ->get();
            
            return Datatables::of($pendapatan)
                ->addIndexColumn()
                ->addColumn('nominal', function ($data) {
                    return moneyFormat($data->nominal);
                
                })
                ->rawColumns(["nominal"])
                ->make(true);
        }
        return view('admin.keuangan.index');
    }

    public function pengeluaran()
    {
            $pendapatan = Keuangan::where('user_id', auth()->user()->id)
                                    ->where('type',"PENGELUARAN")
                                    ->orderBy('tanggal','DESC')
                                    ->get();
            
            return Datatables::of($pendapatan)
                ->addIndexColumn()
                ->addColumn('nominal', function ($data) {
                    return moneyFormat($data->nominal);
                
                })
                ->rawColumns(["nominal"])
                ->make(true);
        
    }
}
