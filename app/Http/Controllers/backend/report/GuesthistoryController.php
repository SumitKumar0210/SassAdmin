<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\HotlrConfiguration;
use App\Models\Invoice;
use App\Models\InvoiceRoomDetail;
use App\Models\Kot;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\RoomType;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GuesthistoryController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.guest-history',compact('hotlr'));
    }
    public function guestHistoryData(Request $request){
        $customers = Customer::get();
        return DataTables::of($customers)
        ->addIndexColumn()
        ->addColumn('guest_id' ,function($row){
            return $row->guest_id;
        })
        ->addColumn('first_name' ,function($row){
            return $row->first_name;
        })
        ->addColumn('last_name' ,function($row){
            return $row->last_name;
        })
        ->addColumn('mobile' ,function($row){
            return $row->mobile;
        })
        ->addColumn('email' ,function($row){
            return $row->email;
        })
        ->addColumn('city' ,function($row){
            return $row->city;
        })
        ->addColumn('action' ,function($row){
             return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-eye" onclick="getGuestDetails('.$row->id.')"></i></a></li>
                        </ul>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function guestHistoryDetails($id){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $customers = Customer::where('id', $id)->get();
        return view('backend.modules.report.guest-history-details',compact('hotlr','customers'));
    }

    public function guestHistoryListDetails(Request $request){
        $reservations = Reservation::where('guest_id',$request->id)->get();
        return DataTables::of($reservations)
        ->addIndexColumn()
        ->addColumn('reservation_id', function($row){
            return $row->reservation_id;
        })
        ->addColumn('bill_no', function($row){
            return $row->bill_number ?? 'NA';
        })
        ->addColumn('bill_date', function($row){
            return $row->bill_generated_at ?? 'NA';
        })
        ->addColumn('room_num', function($row){
            return $row->reservationRoomData->room_alloted ?? 'NA';
        })
        ->addColumn('room_type', function($row){
            $roomCategoryId = $row->reservationRoomData->room_category_id ?? '';
            $room_category = RoomType::where('id', $roomCategoryId)->value('room_category');
            return $room_category ?? 'NA';
        })
        ->addColumn('tariff_type', function($row){
            $tariff_id =  $row->reservationRoomData->tariff_id ?? '';
            $tariff_name = Tariff::where('id',$tariff_id)->value('tariff_type');
            return $tariff_name ?? 'NA';
        })
        ->addColumn('created_at', function($row){
            return $row->created_at->format('d-m-Y h:s A');
        })
        ->addColumn('action', function($row){
            $html = '';
            $html .='<ul class="action"> 
                        <li class="edit"><a href="#"><i class="icon-eye" onclick="getReservationDetails('.$row->id.')"></i></a> </li>';
                        if($row->bill_number != NULL){
                            $html .= '<li class="edit ms-1"><a href="#"><i class="icofont icofont-print text-info" onclick="printReservationBill('.$row->bill_number.')"></i></a></li>';
                        }
                    $html .= '</ul>';
            return $html;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function guestRestaurantListDetails(Request $request){
        // Get all reservation IDs for the guest
        $reservationIds = Reservation::where('guest_id', $request->id)->pluck('reservation_id');
        $kots = Kot::whereIn('kot_id', $reservationIds)->get();
        return DataTables::of($kots)
        ->addIndexColumn()
        ->addColumn('kot_id', function($row){
            return $row->kot_id;
        })
        ->addColumn('bill_no', function($row){
            return $row->bill_number ?? 'NA';
        })
        ->addColumn('bill_date', function($row){
            return $row->bill_date ?? 'NA';
        })
        ->addColumn('room_num', function($row){
            return $row->type_number;
        })
        ->addColumn('kot_type', function($row){
            return $row->type;
        })
        ->addColumn('assist_by', function($row){
            return $row->user_detail->name ?? 'NA';
        })
        ->addColumn('created_at', function($row){
            return $row->created_at->format('d-m-Y h:s A');
        })
        ->addColumn('action', function($row){
            $html = '';
            $html .='<ul class="action"> 
                        <li class="edit"><a href="#"><i class="icon-eye" onclick="getResturantDetails('.$row->id.')"></i></a> </li>';
                        if($row->bill_number != NULL){
                            $html .= '<li class="edit ms-1"><a href="#"><i class="icofont icofont-print text-info" onclick="kotPrintBill('.$row->bill_number.')"></i></a></li>';
                        }
                    $html .= '</ul>';
            return $html;
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function guestHistoryGetDetails(Request $request){
        $getData = Customer::where('id', $request->id)->get();
        return response()->json(['success' => 'Guest Data fetched', 'data' => $getData]);
    }

    public function guestHistoryUpdateDetails(Request $request){
        $update = Customer::where('id', $request->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'proof_type' => $request->proof_type,
            'id_proof' => $request->id_proof,
        ]);
        if($update){
            return response()->json(['success' => 'Guest data updated successfully'],200);
        }else{
            return response()->json(['error_success' => 'Guest data not updated']);
        }
    }
    public function getReservationDetails(Request $request){
        $resRoomData = [];
        $getData = Reservation::where('id', $request->id)->get();
        $resIds = Reservation::where('id', $request->id)->pluck('reservation_id');
        $resRooms = ReservationRoom::whereIn('reservation_id',$resIds)->get();
        foreach($resRooms as $rooms){
            $resRoomData[] = [
                'room_alloted' => $rooms->room_alloted,
                'room_category' => $rooms->room_type_detail->room_category,
                'tariff_type' => $rooms->tariff_detail->tariff_type,
                'tariff_amount' => $rooms->tariff_detail->room_tariff
            ];
        }
        return response()->json(['success' =>'Reservation data fetched', 'resData' => $getData, 'resRoomData'=> $resRoomData],200);
    }
    
    public function guestRestaurantDetails(Request $request){
        $getData = Kot::where('id', $request->id)->get();
        $kotData = [];
        foreach($getData as $kot){
            $kotData[] = [
                'kot_id' => $kot->kot_id,
                'type' => $kot->type,
                'type_number' => $kot->type_number,
                'order_time' => Carbon::parse($kot->order_time)->format('d-m-Y h:s A'),
                'item_qty' => $kot->total_item_qty,
                'complimentary' => $kot->is_complimentary == 0 ?'No':'Yes',
                'waiter' => $kot->waiterDetail->name ?? '',
                'total_amount' => $kot->grand_total,
                'paid_amount' => $kot->total_paid,
                'assist_by' => $kot->user_detail->name ?? '',
                'order_status' => $kot->order_status,
                'payment_type' => $kot->payment_type,
                'note' => $kot->note
            ];
        }
        return response()->json(['success' => 'Kot data fetched', 'data' => $kotData],200);
    }

    public function reservationPrintBill($id){
        
        $hotlr = HotlrConfiguration::get();
        $invoices = Invoice::where('id',$id)->get();
        $reservations = Reservation::where('id',$invoices[0]->reservation_id)->get();
        $invoice_rooms = InvoiceRoomDetail::where('invoice_id',$id)->get();
        return view('backend.modules.invoice.reservation.view_final_invoice',compact('hotlr','invoices','reservations','invoice_rooms'));
    }
}
