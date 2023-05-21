<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeuanganController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $pendapatan = Keuangan::where('user_id', auth()->user()->id)
                ->where('type', 'PENDAPATAN')
                ->orderBy('tanggal', 'DESC')
                ->get();

            return Datatables::of($pendapatan)
                ->addIndexColumn()
                ->addColumn('nominal', function ($data) {
                    return moneyFormat($data->nominal);

                })
                ->rawColumns(['nominal'])
                ->make(true);
        }

        return view('admin.keuangan.index');
    }

    public function store(Request $request)
    {

        try {
            Keuangan::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'nominal' => $request->nominal,
                'metode' => $request->metode,
                'tanggal' => $request->tanggal,
                'type' => 'PENDAPATAN',
            ]);

            activity(auth()->user()->name)->log('Menambah Pendapatan  '.$request->name);
        } catch (\Exception $e) {
            return redirect()->route('keuangan.index')->with('error', 'data Gagal disimpan! '.$e->getMessage());

        }

         return redirect()->route('keuangan.index')->with('success', 'data berhasil disimpan!');
    }

    public function pengeluaran()
    {
        $pendapatan = Keuangan::where('user_id', auth()->user()->id)
            ->where('type', 'PENGELUARAN')
            ->orderBy('tanggal', 'DESC')
            ->get();

        return Datatables::of($pendapatan)
            ->addIndexColumn()
            ->addColumn('nominal', function ($data) {
                return moneyFormat($data->nominal);

            })
            ->rawColumns(['nominal'])
            ->make(true);

    }

    public function pengeluaranStore(Request $request)
    {

        try {
            Keuangan::create([
                'user_id' => Auth::user()->id,
                'name' => $request->name,
                'nominal' => $request->nominal,
                'metode' => $request->metode,
                'tanggal' => $request->tanggal,
                'type' => 'PENGELUARAN',
            ]);

            activity(auth()->user()->name)->log('Menambah Pengeluaran  '.$request->name);
        } catch (\Exception $e) {
            return redirect()->route('keuangan.index')->with('error', 'data Gagal disimpan! '.$e->getMessage());

        }

         return redirect()->route('keuangan.index')->with([
             'success' => 'data berhasil disimpan!',
             'pengeluaran' => 'berhasil',
         ]);
    }
}
