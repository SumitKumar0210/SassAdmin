<?php

namespace App\Http\Controllers\backend\audit;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\Reservation;
use Illuminate\Http\Request;

class FoodBanquetAuditController extends Controller
{
    public function index(){
        $today = date('Y-m-d');
        $total_item_order = KotItem::distinct('item_id')->whereRaw('DATE(created_at) = ?', [$today])->count();
        $kotStats = Kot::where('status', 1)->where('date',$today)->selectRaw("
                        SUM(CASE WHEN order_status = 'Delivered' THEN total_paid ELSE 0 END) as total_revenue,
                        COUNT(*) as total_kot,
                        SUM(CASE WHEN order_status = 'Cancelled' THEN 1 ELSE 0 END) as total_cancel_order,
                        SUM(CASE WHEN payment_type = 'Cash' THEN total_paid ELSE 0 END) as kots_cash,
                        SUM(CASE WHEN payment_type = 'Cheque' THEN total_paid ELSE 0 END) as kots_cheque,
                        SUM(CASE WHEN payment_type = 'Card' THEN total_paid ELSE 0 END) as kots_card,
                        SUM(CASE WHEN payment_type = 'UPI' THEN total_paid ELSE 0 END) as kots_upi,
                        SUM(CASE WHEN is_complimentary = 1 THEN 1 ELSE 0 END) as is_complimentary
                    ")->first();

        $total_revenue      = $kotStats->total_revenue;
        $total_kot          = $kotStats->total_kot;
        $total_cancel_order = $kotStats->total_cancel_order;
        $kots_cash          = $kotStats->kots_cash;
        $kots_cheque        = $kotStats->kots_cheque;
        $kots_card          = $kotStats->kots_card;
        $kots_upi           = $kotStats->kots_upi;
        $is_complimentary   = $kotStats->is_complimentary;
        $avg_cash = ($kotStats->total_revenue > 0) ? round($kotStats->kots_cash / $kotStats->total_revenue): 0;
        $avg_card = ($kotStats->total_revenue > 0) ? round($kotStats->kots_card / $kotStats->total_revenue): 0;
        $avg_upi = ($kotStats->total_revenue > 0) ? round($kotStats->kots_upi / $kotStats->total_revenue): 0;

        $kots = Kot::where('type', 'Room')->where('date',$today)->get(['kot_id', 'type_number', 'grand_total', 'total_paid']);
        $groupedKots = $kots->groupBy(['kot_id', 'type_number']);
        $kotIds = $groupedKots->keys()->toArray();
        $reservations = Reservation::whereIn('reservation_id', $kotIds)->pluck('first_name', 'reservation_id'); 

        $roomKot = [];
        foreach ($groupedKots as $kotId => $rooms) {
            foreach ($rooms as $roomNumber => $details) {
                $total_bill = $details->sum('grand_total');
                $paid_bill = $details->sum('total_paid');
                $due = $total_bill - $paid_bill;
                $cal_status = $due > 0 ? 'Un-Paid' : 'Paid';

                $roomKot[] = [
                    'kot_id'      => $kotId,
                    'room'        => $roomNumber,
                    'name'        => $reservations[$kotId] ?? '',
                    'status'      => $cal_status,
                    'grand_total' => $total_bill,
                    'paid_amount' => $paid_bill,
                    'due' => $due,
                    'kot_rooms'   => $roomNumber
                ];
            }
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.kot-audit',compact('total_revenue','total_kot','total_item_order','total_cancel_order','kots_cash','kots_cheque','kots_card','kots_upi','is_complimentary','roomKot','avg_cash','avg_card','avg_upi','hotlr'));
    }

    public function print(){
        $today = date('Y-m-d');
        $total_item_order = KotItem::distinct('item_id')->whereRaw('DATE(created_at) = ?', [$today])->count();
        $kotStats = Kot::where('status', 1)->where('date',$today)->selectRaw("
                        SUM(CASE WHEN order_status = 'Delivered' THEN total_paid ELSE 0 END) as total_revenue,
                        COUNT(*) as total_kot,
                        SUM(CASE WHEN order_status = 'Cancelled' THEN 1 ELSE 0 END) as total_cancel_order,
                        SUM(CASE WHEN payment_type = 'Cash' THEN total_paid ELSE 0 END) as kots_cash,
                        SUM(CASE WHEN payment_type = 'Cheque' THEN total_paid ELSE 0 END) as kots_cheque,
                        SUM(CASE WHEN payment_type = 'Card' THEN total_paid ELSE 0 END) as kots_card,
                        SUM(CASE WHEN payment_type = 'UPI' THEN total_paid ELSE 0 END) as kots_upi,
                        SUM(CASE WHEN is_complimentary = 1 THEN 1 ELSE 0 END) as is_complimentary
                    ")->first();

        $total_revenue      = $kotStats->total_revenue;
        $total_kot          = $kotStats->total_kot;
        $total_cancel_order = $kotStats->total_cancel_order;
        $kots_cash          = $kotStats->kots_cash;
        $kots_cheque        = $kotStats->kots_cheque;
        $kots_card          = $kotStats->kots_card;
        $kots_upi           = $kotStats->kots_upi;
        $is_complimentary   = $kotStats->is_complimentary;
        $avg_cash = ($kotStats->total_revenue > 0) ? round($kotStats->kots_cash / $kotStats->total_revenue): 0;
        $avg_card = ($kotStats->total_revenue > 0) ? round($kotStats->kots_card / $kotStats->total_revenue): 0;
        $avg_upi = ($kotStats->total_revenue > 0) ? round($kotStats->kots_upi / $kotStats->total_revenue): 0;

        $kots = Kot::where('type', 'Room')->where('date',$today)->get(['kot_id', 'type_number', 'grand_total', 'total_paid']);
        $groupedKots = $kots->groupBy(['kot_id', 'type_number']);
        $kotIds = $groupedKots->keys()->toArray();
        $reservations = Reservation::whereIn('reservation_id', $kotIds)->pluck('first_name', 'reservation_id'); 

        $roomKot = [];
        foreach ($groupedKots as $kotId => $rooms) {
            foreach ($rooms as $roomNumber => $details) {
                $total_bill = $details->sum('grand_total');
                $paid_bill = $details->sum('total_paid');
                $due = $total_bill - $paid_bill;
                $cal_status = $due > 0 ? 'Un-Paid' : 'Paid';

                $roomKot[] = [
                    'kot_id'      => $kotId,
                    'room'        => $roomNumber,
                    'name'        => $reservations[$kotId] ?? '',
                    'status'      => $cal_status,
                    'grand_total' => $total_bill,
                    'paid_amount' => $paid_bill,
                    'due' => $due,
                    'kot_rooms'   => $roomNumber
                ];
            }
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.nightaudit.kot-audit-print',compact('total_revenue','total_kot','total_item_order','total_cancel_order','kots_cash','kots_cheque','kots_card','kots_upi','is_complimentary','roomKot','avg_cash','avg_card','avg_upi','hotlr'));
    }
}
