<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\BanquetBooking;
use App\Models\Hall;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HallRevenueComparisonController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.hall_revenue_comparison',compact('hotlr'));
    }

    public function hallRevenueView(Request $request){
        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $quarters = [
            'Q1' => [''.$dateFrom.'-01-01', ''.$dateTo.'-03-31'],
            'Q2' => [''.$dateFrom.'-04-01', ''.$dateTo.'-06-30'],
            'Q3' => [''.$dateFrom.'-07-01', ''.$dateTo.'-09-30'],
            'Q4' => [''.$dateFrom.'-10-01', ''.$dateTo.'-12-31'],
        ];

        $bookings = BanquetBooking::selectRaw("
                hall_id,
                SUM(CASE WHEN event_date BETWEEN ? AND ? THEN grand_total ELSE 0 END) AS revenue1,
                SUM(CASE WHEN event_date BETWEEN ? AND ? THEN grand_total ELSE 0 END) AS revenue2,
                SUM(CASE WHEN event_date BETWEEN ? AND ? THEN grand_total ELSE 0 END) AS revenue3,
                SUM(CASE WHEN event_date BETWEEN ? AND ? THEN grand_total ELSE 0 END) AS revenue4
            ", [
                $quarters['Q1'][0], $quarters['Q1'][1],
                $quarters['Q2'][0], $quarters['Q2'][1],
                $quarters['Q3'][0], $quarters['Q3'][1],
                $quarters['Q4'][0], $quarters['Q4'][1],
            ])
            ->groupBy('hall_id')
            ->get()
            ->keyBy('hall_id');

        $halls = Hall::get();
        return DataTables::of($halls)
            ->addIndexColumn()
            ->addColumn('hall', fn($row) => $row->name)
            ->addColumn('revenue1', fn($row) => $bookings[$row->id]->revenue1 ?? 0)
            ->addColumn('revenue2', fn($row) => $bookings[$row->id]->revenue2 ?? 0)
            ->addColumn('revenue3', fn($row) => $bookings[$row->id]->revenue3 ?? 0)
            ->addColumn('revenue4', fn($row) => $bookings[$row->id]->revenue4 ?? 0)
            ->addColumn('total_amount', function($row) use ($bookings) {
                $b = $bookings[$row->id] ?? null;
                return $b ? $b->revenue1 + $b->revenue2 + $b->revenue3 + $b->revenue4 : 0;
            })
            ->addColumn('growth_rate', function($row) use ($bookings) {
                $b = $bookings[$row->id] ?? null;
                if (!$b) return 0;
                return ((($b->revenue2 - $b->revenue1) + ($b->revenue3 - $b->revenue2) + ($b->revenue4 - $b->revenue3)) / 3) * 100;
            })
            ->make(true);
    }
}
