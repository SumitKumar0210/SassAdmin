<?php

namespace App\Http\Controllers\backend\invoice;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceRoomDetail;
use App\Models\Reservation;
use App\Models\ReservationInvoice;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\RoomNumber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    
    public function paymentInvoice($id){
        $reservationRoomDetails = ReservationRoom::where('id',$id)->get();
        $old_invoice_count = $reservationRoomDetails[0]->invoice_view_count;
        ReservationRoom::where('id',$id)->update([
          'invoice_view_count' => $old_invoice_count + 1
        ]);
        $curr_date = date("d F Y");
        $res_id = $reservationRoomDetails[0]->reservation_id;
        $reservationDetails = Reservation::where('reservation_id',$res_id)->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend/modules/invoice/reservation/view_invoice',compact('reservationRoomDetails','curr_date','reservationDetails','hotlr'));
    }
    
    public function send_paymentInvoice($id) {
        $reservationRoomDetails = ReservationRoom::where('id', $id)->get();
        $res_id = $reservationRoomDetails[0]->reservation_id;
        $reservationDetails = Reservation::where('reservation_id', $res_id)->get();
        // Generate invoice URL
        $invoiceUrl = url('/rp-invoice', ['id' => $id]);
        $check_email = $reservationDetails[0]->email ?? '';
        if ($check_email != '') {
            Mail::send('backend.email.payment_invoice', [
                'invoiceUrl' => $invoiceUrl
            ], function ($message) use ($check_email) {
                $message->to($check_email)->subject('Payment Invoice');
            });
            return response()->json(['success' => 'Payment Invoice sent successfully'], 200);
        } else {
            return response()->json(['error_success' => 'Email id not found!'], 400);
        }
    }

    public function FinalPaymentInvoice(Request $request){
        $invoiceDetails = ReservationInvoice::where('id',$request->id)->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend/modules/invoice/reservation/view_invoice',compact('invoiceDetails','hotlr'));
    }

    public function invoice_status(Request $request){
                $invoice_status = $request->markText;
            if($invoice_status == 'Final'){
                $invoice = new ReservationInvoice();
                $invoice->status = $invoice_status;
                $invoice->room_id = $request->roomID;
                $invoice->reservation_id = $request->reservationID;
                $invoice->room_num = $request->room_num;
                $invoice->room_type = $request->room_type;
                $invoice->checkin = $request->checkin;
                $invoice->checkout = $request->checkout;
                $invoice->name = $request->name;
                $invoice->mobile = $request->mobile;
                $invoice->email = $request->email;
                $invoice->address = $request->address;
                $invoice->amount = $request->amount;
                $invoice->discount = $request->discount;
                $invoice->paid_amount = $request->paid_amount;
                $invoice->save();
            }
                    $update = ReservationRoom::where('id',$request->roomID)->update([
                        'invoice_status' => $request->markText
                    ]);
                    if($update){
                        return response()->json(['success' => 'Invoice status updated'],200);
                    }else{
                        return response()->json(['error_success' => 'Invoice not updated']);
                    }
                
    }

    public function final_restr_invoice(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend/modules/invoice/reservation/Final_invoice_details',compact('hotlr'));
    }

    public function getFinalInvoiceData(Request $request){
        if($request->ajax()){
            $invoiceDetails = ReservationInvoice::get();
            return DataTables::of($invoiceDetails)
            ->addIndexColumn()
            ->addColumn('status', function($row){
                // Conditional formatting for the status column
                $color = $row->status === 'final' ? 'badge-primary' : 'badge-danger';
                // Corrected HTML structure
                return "<div class='badge $color fw-light'>$row->status</div>";
            })
            ->addColumn('reservationid',function($row){
                return $row->reservation_id;
            })
            ->addColumn('room_num',function($row){
                return $row->room_num;
            })
            ->addColumn('room_type',function($row){
                return $row->room_type;
            })
            ->addColumn('checkin',function($row){
              return $row->checkin;
            })
            ->addColumn('checkout',function($row){
                return $row->checkout;
            })
            ->addColumn('name',function($row){
                return $row->name;
            })
            ->addColumn('mobile',function($row){
                return $row->mobile;
            })
            ->addColumn('email',function($row){
                return $row->email;
            })
            ->addColumn('address',function($row){
                return $row->address;
            })
            ->addColumn('amount',function($row){
                return $row->amount;
            })
            ->addColumn('discount',function($row){
                return $row->discount;
            })
            ->addColumn('paid_amount',function($row){
                return $row->paid_amount;
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit">
                           <a target="_blank" href="/invoice/invoice-Final-view/'.$row->id.'"><i class="ri-eye-fill"></i></a>
                        </li>
                        <li class="delete ms-1 invoice_cancel" onclick="cancel_Final_invoice('.$row->id.')">
                             <i class="ri-delete-bin-fill"></i>
                        </li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function Final_invoice_view($id){
        $reservationInvoice = ReservationInvoice::where('id',$id)->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend/modules/invoice/reservation/view_Final_invoice',compact('reservationInvoice','hotlr'));
    }

    public function Final_invoice_cancel(Request $request){
     $update = ReservationInvoice::where('id',$request->id)->where('status','Final')->update([
        'status'=>'cancel'
     ]);
     if($update){
        return response()->json(['success'=>'Invoice canceled successfully'],200);
     }else{
        return response()->json(['success_error'=>'Invoice not canceled']);
     }
    }

    public function generateInvoice(Request $request){
        
        $next_number = 1;
        $companies = HotlrConfiguration::get(['name','address','invoice_prefix','suffix_length','state','pincode','gst','mobile']);
        $invoice_created = Invoice::where('status',1)->get(['invoice_id','invoice_date']);
        if(sizeof($invoice_created) > 0){
            $invoice_id = $invoice_created[0]->invoice_id;
            $next_number = str_replace($companies[0]->invoice_prefix, "", $invoice_id) + 1;
        }
        $invoice_number = str_pad($next_number, $companies[0]->suffix_length, '0', STR_PAD_LEFT);
        $created_invoice = $companies[0]->invoice_prefix.''.$invoice_number;
        $roomReservation = ReservationRoom::where('random',$request->random_number)->get(['id','reservation_id','primary_name','status','room_alloted','room_alloted_id','checkin','checkout','room_category_id','room_category','room_type_id','tariff_id','room_type','rate_plan','adults','childrens','infants','amount','extra_person','extra_person_amount','notes','checkedin_at','checkedout_at']);
        $checkin = '';
        $room_number_type = '';
        $room_id = '';
        $reservation_room = [];
        foreach($roomReservation as $room){
           
            $checkin = $room->checkedin_at;
            $days = $this->daysCalculate($room->checkedin_at);
            $total = intval($days) * (($room->amount) + ($room->extra_person * $room->extra_person_amount));
            $reserved_room[] = [
                'id' => $room->id,
                'room_id' => $room->room_alloted_id,
                'room_type' => $room->room_type_detail->room_category ?? '',
                'room_number' => $room->room_alloted ?? '',
                'tariff_type' => $room->tariff_detail->tariff_type ?? '',
                'room_tariff' => round($room->amount ?? 0),
                'days' => intval($days),
                'adult' => $room->adults,
                'extra_person' => $room->extra_person,
                'tariff_extra_person' => $room->tariff_detail->extra_person_tariff ?? 0,
                'total' => round($total)
            ];
            $room_number_type .= $room->room_alloted .'/'.$room->room_type_detail->room_category;
            array_push($reservation_room,$room->id);
            $room_id = $room->id;
        }

        
        $chkDue = Kot::whereIn('payment_type',['Due','Complete with Due'])->where('kot_id',$roomReservation[0]->reservation_id)->count();
        if($chkDue > 0){
            return response()->json(['pending' => 'Please Clear you all Kot Amount','reservation_id' => $roomReservation[0]->reservation_id, 'room_id' => $room_id], 200);
            dd($chkDue);
        }else{
            $reservations = Reservation::where('reservation_id',$roomReservation[0]->reservation_id)->get(['id','reservation_id','status','first_name','last_name','mobile','email','address','city','state','pincode','document_type','other_document_type','id_number','guest_comment','company_name','company_gst','company_address','note','created_at','booking_type']);
            $now = Carbon::now();
            $checkin_date = date('Y-m-d H:i:s',strtotime($checkin));
            $checkout_date = date('Y-m-d H:i:s',strtotime($now));
            $amount_after_discount = $request->total_amount - $request->dicount_amount;
            $amount_after_tax =  $amount_after_discount + $request->total_igst;

            $advance_amount = $request->advance_amount ?? 0;
            $discount_percentage = $request->discount_percentage ?? 0;
            $round_off = $request->round_off ?? 0;

            DB::beginTransaction(); 

            try{
                $invoice_id = '';
                $invoice = new Invoice();
                $invoice->invoice_id = $created_invoice;
                $invoice->type = 'Room';
                $invoice->reservation_id = $reservations[0]->id;
                $invoice->reservation = $roomReservation[0]->reservation_id;
                $invoice->reserved_room_id = implode(',',$reservation_room);
                $invoice->checkin = $checkin_date;
                $invoice->checkout = $checkout_date;
                $invoice->booking_type = $reservations[0]->booking_type ?? 'Single';
                $invoice->invoice_date = date('Y-m-d H:i:s',strtotime($now));
                $invoice->no_of_nights = $request->number_of_days;
                $invoice->no_of_rooms = count($roomReservation);
                $invoice->guest_id = $reservations[0]->id;
                $invoice->guest_name = $request->guest_name;
                $invoice->guest_phone = $reservations[0]->mobile;
                $invoice->guest_address = $reservations[0]->address;
                $invoice->guest_email = $reservations[0]->email;
                $invoice->total = $request->total_amount;
                $invoice->dis_per = $discount_percentage;
                $invoice->dis_amount = $request->dicount_amount;
                $invoice->amount_after_discount = $amount_after_discount;
                $invoice->cgst_per = ($request->tax_value)/2;
                $invoice->sgst_per = ($request->tax_value)/2;
                $invoice->igst_per = $request->tax_value;
                $invoice->cgst_amount = $request->total_cgst;
                $invoice->sgst_amount = $request->total_sgst;
                $invoice->igst_amount = $request->total_igst;
                $invoice->amount_after_tax = $amount_after_tax;
                $invoice->round_off = $round_off;
                $invoice->advance_amount = $advance_amount;
                $invoice->pay_amount = $request->remaining_amount;
                $invoice->payment_mode = $request->payment_mode;
                $invoice->reference = $request->reference_code;
                $invoice->note = $request->notes;
                $invoice->received_by = Auth::user()->id;

                if($invoice->save()){
                    $invoice_id = $invoice->id;
                    foreach($reserved_room as $room_res){

                        $invoice_room = new InvoiceRoomDetail();
                        $invoice_room->invoice_id = $invoice->id;
                        $invoice_room->invoice_date = date('Y-m-d H:i:s',strtotime($now));
                        $invoice_room->reserved_room_id = $room_res['id'];
                        $invoice_room->room_id = $room_res['room_id'];
                        $invoice_room->room_number = $room_res['room_number'];
                        $invoice_room->room_type = $room_res['room_type'];
                        $invoice_room->room_category = $room_res['room_type'];
                        $invoice_room->no_of_days = $room_res['days'];
                        $invoice_room->tariff_type = $room_res['tariff_type'];
                        $invoice_room->total = $room_res['room_tariff'];
                        $invoice_room->adult = $room_res['adult'];
                        $invoice_room->extra_person_no = $room_res['extra_person'];
                        $invoice_room->extra_person_total = $room_res['extra_person'] * $room_res['tariff_extra_person'];
                        $invoice_room->subtotal = $room_res['total'];
                        $invoice_room->save();

                        $reservationRoomCheckout = ReservationRoom::where('id',$room_res['id'])->update([
                            'status' => 'Check-out',
                            'guest_status' => 'Check-out',
                            'checkedout_at' => date('Y-m-d H:i:s',strtotime($now))
                        ]);

                        $vacant_room = RoomNumber::where('id',$room_res['room_id'])->update([
                            'current_status' => '-1'
                        ]);
                    }
                }

                DB::commit(); // data saved in both the table successfullt.
                return response()->json(['success' => 'Invoice created successfully','reservation_id'=>$roomReservation[0]->reservation_id, 'invoice_id' => $invoice_id], 200);
            }catch (\Exception $e) {
                DB::rollBack(); // if date not saved in both table then both table rollback as before.
                return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
            }
        }
    }

    public function daysCalculate($checkin_date){

        $checkin = Carbon::parse($checkin_date);
        $now = Carbon::now();

        $days = $checkin->diffInDays($now);

        $checkin_time = $checkin->format('H:i:s');
        $checkout_time = $now->format('H:i:s');

        $checkin_seconds = strtotime($checkin_time);
        $checkout_seconds = strtotime($checkout_time);

        $before_12 = strtotime('12:00:00');
        $after_14 = strtotime('14:00:00');

        if ($days == 0) {
            if ($checkin_seconds < $before_12 && $checkout_seconds > $after_14) {
                $days += 2;
            } else {
                $days += 1;
            }
        } else {
            if ($checkin_seconds < $before_12 && $checkout_seconds > $after_14) {
                $days += 2;
            } elseif (
                ($checkin_seconds < $before_12 && $checkout_seconds < $after_14) ||
                ($checkin_seconds > $before_12 && $checkout_seconds > $after_14)
            ) {
                $days += 1;
            } 
        }

        return $days;
    }
}


