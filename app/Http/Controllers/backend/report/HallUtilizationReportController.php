<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\BanquetBooking;
use App\Models\Hall;
use App\Models\HotlrConfiguration;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HallUtilizationReportController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.hall_utilization_report',compact('hotlr'));
    }

    public function hallReportView(Request $request){
        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $halls = Hall::all();
        $bookings = BanquetBooking::select(
                'hall_id',
                DB::raw('COUNT(*) as booking_count'),
                DB::raw('SUM(grand_total) as total_revenue')
            )
            ->whereBetween('event_date', [$dateFrom, $dateTo])
            ->groupBy('hall_id')
            ->get()
            ->keyBy('hall_id');

        $dateFromObj = new DateTime($dateFrom);
        $dateToObj   = new DateTime($dateTo);
        $totalDays   = $dateFromObj->diff($dateToObj)->days + 1; // +1 if you want to count both start & end

        return DataTables::of($halls)
            ->addIndexColumn()
            ->addColumn('hall', fn($row) => $row->name)
            ->addColumn('capacity', fn($row) => $row->capacity)
            ->addColumn('area', fn($row) => $row->area)
            ->addColumn('rate', fn($row) => $row->rate)
            ->addColumn('booking', function($row) use ($bookings) {
                return $bookings[$row->id]->booking_count ?? 0;
            })
            ->addColumn('booking_days', function($row) use ($bookings) {
                return $bookings[$row->id]->booking_count ?? 0;
            })
            ->addColumn('available_days', function($row) use ($bookings, $totalDays) {
                $booked = $bookings[$row->id]->booking_count ?? 0;
                return $totalDays - $booked;
            })
            ->addColumn('occupancy_rate', function($row) use ($bookings, $totalDays) {
                $booked = $bookings[$row->id]->booking_count ?? 0;
                return $totalDays > 0 ? round(($booked / $totalDays) * 100, 2) . '%' : '0%';
            })
            ->addColumn('revenue_generated', function($row) use ($bookings) {
                return $bookings[$row->id]->total_revenue ?? 0;
            })
            ->addColumn('avg_booking', function($row) use ($bookings, $totalDays) {
                $booked = $bookings[$row->id]->booking_count ?? 0;
                return $totalDays > 0 ? round($booked / $totalDays, 2) : 0;
            })
            ->addColumn('performance_rate', fn($row) => 0)
            ->make(true);
    }
}
