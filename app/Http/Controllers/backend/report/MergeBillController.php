<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\HotlrConfiguration;
use App\Models\Invoice;
use App\Models\Kot;
use App\Models\KotInvoice;
use App\Models\KotItem;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\RoomType;
use App\Models\Tariff;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MergeBillController extends Controller
{
    public function index(Request $request){
        
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.merge_bill',compact('hotlr'));
    }

    public function mergeBillReservation(Request $request){
        $rooms = [];
        $kots = Kot::where('type', 'Room')->where('order_status', 'Delivered')->distinct()->get(['kot_id']);
        foreach($kots as $kot){
            $reservations = ReservationRoom::where('reservation_id',$kot->kot_id)->get();
            $invoice = Invoice::where('reservation',$kot->kot_id)->count();
            if($invoice > 0){
                array_push($rooms,$reservations);
            }
        }
        
        return DataTables::of($rooms)
        ->addIndexColumn()
        ->addColumn('reservation_id',function($row){
            return $row[0]->reservation_id;
        })
        ->addColumn('first_name',function($row){
            $first_name = Reservation::where('reservation_id',$row[0]->reservation_id)->value('first_name');
            return $first_name;
        })
        ->addColumn('last_name',function($row){
            $last_name = Reservation::where('reservation_id',$row[0]->reservation_id)->value('last_name');
            return $last_name;
        })
        ->addColumn('room_number',function($row){
            return $row[0]->room_alloted;
        })
        ->addColumn('bill_number',function($row){
            $bill = Invoice::where('reservation',$row[0]->reservation_id)->value('invoice_id');
            return $bill;
        })
        ->addColumn('checkout_date',function($row){
            if($row[0]->checkedout_at != null){
                return date('d-m-Y H:i:s',strtotime($row[0]->checkedout_at));
            }else{
                return '';
            }
        })
        ->addColumn('updated_at',function($row){
            return date('d-m-Y H:i:s',strtotime($row[0]->updated_at));
        })
        ->addColumn('action',function($row){
            return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon icon-eye" onclick="selectOptionToMerge(`'.$row[0]->reservation_id.'`)"></i></a></li>
                    </ul>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function mergeBillPrint($detail){
        parse_str($detail, $params);

        $id = $params['id'] ?? null;
        $type_merge = $params['type'] ?? '';
        $hotlr = HotlrConfiguration::get();

        $reservations = Reservation::where('reservation_id',$id)->get();
        $reservation_rooms = ReservationRoom::where('reservation_id',$id)->get();
        $invoices = Invoice::where('reservation',$id)->get();
        
        $no_of_days = $invoices[0]->no_of_nights;
        $total = $invoices[0]->total;
        $dis_per = $invoices[0]->dis_per;
        $dis_amount = $invoices[0]->dis_amount;
        $cgst_per = $invoices[0]->cgst_per;
        $sgst_per = $invoices[0]->sgst_per;
        $cgst_amount = $invoices[0]->cgst_amount;
        $sgst_amount = $invoices[0]->sgst_amount;
        $round_off = $invoices[0]->round_off;
        $kots_amount = Kot::where('kot_id',$id)->sum('total');
        $kots_gst = Kot::where('kot_id',$id)->sum('total_gst');
        $kots_grandtotal = Kot::where('kot_id',$id)->sum('grand_total');
        $kot = Kot::where('kot_id',$id)->value('id');
        $gst = KotItem::where('kot_id',$kot)->value('gst');

        $room_name = RoomType::where('id',$reservation_rooms[0]->room_category_id)->value('room_category');
        $tariff = $reservation_rooms[0]->amount;

        return view('backend.modules.report.merge_bill_print',compact('hotlr','reservation_rooms','invoices','kots_amount','kots_gst','kots_grandtotal','reservations','no_of_days','total','dis_per','dis_amount','cgst_per','cgst_amount','round_off','gst','room_name','tariff','type_merge'));
    }
}
