<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $quantity = Order::where('status', '!=', 'PENDING')->sum('quantity');
        $totalMonth = Order::where('status', '!=', 'PENDING')->whereMonth('tanggal_potong', date('m'))->sum('total_harga');
        $totalYears = Order::where('status', '!=', 'PENDING')->whereYear('tanggal_potong', date('Y'))->sum('total_harga');

        $start = Carbon::now()->startOfMonth();
        $startweeks = $start->endOfWeek()->locale('id');
        $startweeks1 = CarbonImmutable::parse($startweeks->addDays(1))->locale('id');
        $endweeks1 = $startweeks1->endOfWeek()->format('Y-m-d');
        $startweek2 = new Carbon($endweeks1);
        $startweeks2 = CarbonImmutable::parse($startweek2->addDays(1))->locale('id');
        $endweeks2 = $startweeks2->endOfWeek()->format('Y-m-d');
        $startweek3 = new Carbon($endweeks2);
        $startweeks3 = CarbonImmutable::parse($startweek3->addDays(1))->locale('id');
        $endweeks3 = $startweeks3->endOfWeek()->format('Y-m-d');
        $startweek4 = new Carbon($endweeks3);
        $startweeks4 = CarbonImmutable::parse($startweek4->addDays(1))->locale('id');
        $endweeks4 = $startweeks4->endOfWeek()->format('Y-m-d');
        $startweek5 = new Carbon($endweeks4);
        $startweeks5 = CarbonImmutable::parse($startweek5->addDays(1))->locale('id');
        $endweeks5 = $startweeks5->endOfWeek()->format('Y-m-d');
        if (Auth::user()->roles == 'ADMIN') {
            $orderWeeks1 = Order::whereBetween('tanggal_potong', [$startweeks1, $endweeks1])->where('status', '!=', 'PENDING')->sum('total_harga');
            $orderWeeks2 = Order::whereBetween('tanggal_potong', [$startweeks2, $endweeks2])->where('status', '!=', 'PENDING')->sum('total_harga');
            $orderWeeks3 = Order::whereBetween('tanggal_potong', [$startweeks3, $endweeks3])->where('status', '!=', 'PENDING')->sum('total_harga');
            $orderWeeks4 = Order::whereBetween('tanggal_potong', [$startweeks4, $endweeks4])->where('status', '!=', 'PENDING')->sum('total_harga');
            $orderWeeks5 = Order::whereBetween('tanggal_potong', [$startweeks5, $endweeks5])->where('status', '!=', 'PENDING')->sum('total_harga');
            $ordersChart = (new LarapexChart())->areaChart()
                ->setTitle('Laporan Order')
                ->setSubtitle('Periode '.date('F Y'))
                ->addData('Orders', [$orderWeeks1, $orderWeeks2, $orderWeeks3, $orderWeeks4, $orderWeeks5])
                ->setXAxis([
                    TanggalID($startweeks1).' - '.TanggalID($endweeks1),
                    TanggalID($startweeks2).' - '.TanggalID($endweeks2),
                    TanggalID($startweeks3).' - '.TanggalID($endweeks3),
                    TanggalID($startweeks4).' - '.TanggalID($endweeks4),
                    TanggalID($startweeks5).' - '.TanggalID($endweeks5),

                ]);
        } else {
            $quantity = Order::where('user_id', Auth::user()->id)->sum('quantity');
            $totalMonth = Order::where('user_id', Auth::user()->id)->where('status', '!=', 'PENDING')->whereMonth('tanggal_potong', date('m'))->sum('total_harga');
            $totalYears = Order::where('user_id', Auth::user()->id)->where('status', '!=', 'PENDING')->whereYear('tanggal_potong', date('Y'))->sum('total_harga');
            $orderWeeks1 = Order::whereBetween('tanggal_potong', [$startweeks1, $endweeks1])->where('status', '!=', 'PENDING')->where('user_id', Auth::user()->id)->sum('total_harga');
            $orderWeeks2 = Order::whereBetween('tanggal_potong', [$startweeks2, $endweeks2])->where('status', '!=', 'PENDING')->where('user_id', Auth::user()->id)->sum('total_harga');
            $orderWeeks3 = Order::whereBetween('tanggal_potong', [$startweeks3, $endweeks3])->where('status', '!=', 'PENDING')->where('user_id', Auth::user()->id)->sum('total_harga');
            $orderWeeks4 = Order::whereBetween('tanggal_potong', [$startweeks4, $endweeks4])->where('status', '!=', 'PENDING')->where('user_id', Auth::user()->id)->sum('total_harga');
            $orderWeeks5 = Order::whereBetween('tanggal_potong', [$startweeks5, $endweeks5])->where('status', '!=', 'PENDING')->where('user_id', Auth::user()->id)->sum('total_harga');
            $ordersChart = (new LarapexChart())->areaChart()
                ->setTitle('Laporan Order')
                ->setSubtitle('Periode '.date('F Y'))
                ->addData('Orders', [$orderWeeks1, $orderWeeks2, $orderWeeks3, $orderWeeks4, $orderWeeks5])
                ->setXAxis([
                    TanggalID($startweeks1).' - '.TanggalID($endweeks1),
                    TanggalID($startweeks2).' - '.TanggalID($endweeks2),
                    TanggalID($startweeks3).' - '.TanggalID($endweeks3),
                    TanggalID($startweeks4).' - '.TanggalID($endweeks4),
                    TanggalID($startweeks5).' - '.TanggalID($endweeks5),

                ]);
        }

        return view('admin.dashboard', compact('quantity', 'totalMonth', 'totalYears', 'ordersChart'));
    }
}
