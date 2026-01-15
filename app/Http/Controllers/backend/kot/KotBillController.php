<?php

namespace App\Http\Controllers\backend\kot;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Item;
use App\Models\Kot;
use App\Models\KotInvoice;
use App\Models\KotItem;
use App\Models\PaymentMethod;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KotBillController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $tables_occupied = [];
        $room_occupied = [];
        $kots = Kot::whereNull('bill_number')->get();
        foreach($kots as $kot){
            if($kot->type == 'Table'){               
                if(!in_array($kot->type_number,$tables_occupied)){
                    array_push($tables_occupied,$kot->type_number);
                }
            }

            if($kot->type == 'Room'){
                if(!in_array($kot->type_number,$room_occupied)){
                    array_push($room_occupied,$kot->type_number);
                }
            }
        }

        return view('backend.modules.kot.generate-bill',compact('hotlr','tables_occupied','room_occupied','kots'));
    }

    public function getBill(Request $request){
        if($request->ajax()){
            $section = 0;
            if($request->table != null || $request->room != null){
                $section = 1;
                if($request->table != ''){
                    $kots = Kot::whereNull('bill_number')->where('type','Table')->where('type_number',$request->table)->get();
                }else{
                    $kots = Kot::whereNull('bill_number')->where('type','Room')->where('type_number',$request->room)->get();
                }
            }else {
                $kots = Kot::whereNull('bill_number')->get();
            }
            
            return DataTables::of($kots)
            ->addColumn('select', function ($row) use ($section) {
                if($section > 0){
                    return '<div class="form-check checkbox checkbox-primary mb-0">
                                <input class="form-check-input" id="checkbox-primary-'.$row->id.'" type="checkbox" value="'.$row->id.'" name="kotsSelect[]">
                                <label class="form-check-label" for="checkbox-primary-'.$row->id.'"></label>
                            </div>';
                }else{
                    return '';
                }
            })
            ->addColumn('kot',function($row){
                return $row->kot_id;
            })
            ->addColumn('table',function($row){
                if($row->type == 'Table'){
                    return $row->type_number;
                }else{
                    return '';
                }
            })
            ->addColumn('room',function($row){
                if($row->type == 'Room'){
                    return $row->type_number;
                }else{
                    return '';
                }
            })
            ->addColumn('kot_type',function($row){
                $kot_type = '';
                if($row->is_complimentary == 1){
                    $kot_type = 'Paid';
                }else if($row->payment_type == 'Due' || $row->payment_type == 'Complete with Due'){
                    $kot_type = 'Due';
                }else{
                    $kot_type = 'Paid';
                }
                return $kot_type;
            })
            ->addColumn('guest_name',function($row){
                return $row->contact_person_name;
            })
            ->addColumn('assisted_by',function($row){
                return optional($row->user_detail)->name ?? '';
            })
            ->addColumn('date_time',function($row){
                return date('d-m-Y h:s A',strtotime($row->order_time));
            })
            ->rawColumns(['select'])
            ->make(true);
        }
    }

    public function showKotForBill($ids){
        // dd($ids);
        $basic = [];
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $kotList = [];
        $ids_array = explode(',',$ids);
        $kots = Kot::whereIn('id',$ids_array)->get();
        foreach($kots as $kt){
            $kot_items = KotItem::where('kot_id',$kt->id)->get();
            foreach($kot_items as $item){

                $items = Item::where('id',$item->item_id)->value('code');
                $kotList[] = [
                    'id' => $item->id,
                    'kot_id' => $item->kot_id,
                    'item_code' => $items,
                    'item_id' => $item->item_id,
                    'item_name' => $item->item_name,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'total' => $item->total,
                    'gst' => $item->gst,
                    'gst_amount' => $item->gst_amount,
                    'grand_amount' => $item->grand_amount,
                ];
            }

            $customer_name = '';
            $customer_gst = '';
            if($kt->type == 'Room'){
                $reservation = Reservation::where('reservation_id',$kt->kot_id)->get(['first_name','last_name','company_gst']);
                $customer_name = $reservation[0]->company_name;
                $customer_gst = $reservation[0]->company_gst;
                if($kt->contact_person_name == ''){
                    $customer_name = $reservation[0]->first_name.' '.$reservation[0]->last_name;
                }
            }
            $basic[] = [
                'bill_by' => optional($kt->user_detail)->name,
                'type' => $kt->type,
                'type_number' => $kt->type_number,
                'customer' => $customer_name,
                'customer_gst' => $customer_gst
            ];
        }

        $payment_methods = PaymentMethod::where('status',1)->whereNull('deleted_at')->get();
        return view('backend.modules.kot.pay-bill',compact('hotlr','kotList','basic','payment_methods','ids'));
    }

    public function previewKotInvoice($detail){
       parse_str($detail, $params);

        $random_id = $params['rand'] ?? null;
        $total_amount = $params['total'] ?? null;
        $dicount_percentage_value = $params['dicount_percentage'] ?? null;
        $dicount_amount_value = $params['dicount_amount'] ?? null;
        $tax_value = $params['tax_value'] ?? null;
        $total_cgst_value = $params['total_cgst'] ?? null;
        $total_sgst_value = $params['total_sgst'] ?? null;
        $total_igst_value = $params['total_igst'] ?? null;
        $round_off = $params['round_off'] ?? null;
        $payment_mode_value = $params['payment_mode'] ?? null;
        $reference_code = $params['reference_code'] ?? null;
        $remaining_amount = $params['remaining_amount'] ?? 0;
        $showPerforma = $params['show'] ?? 01;
        $guest_name = $params['guest_name'] ?? '';
        $company_gst = $params['company_gst'] ?? '';

        $kotList = [];
        $ids_array = explode(',',$random_id);
        $kots = Kot::whereIn('id',$ids_array)->get();
        foreach($kots as $kt){
            $kot_items = KotItem::where('kot_id',$kt->id)->get();
            foreach($kot_items as $item){

                $items = Item::where('id',$item->item_id)->value('code');
                $kotList[] = [
                    'id' => $item->id,
                    'kot_id' => $item->kot_id,
                    'item_code' => $items,
                    'item_id' => $item->item_id,
                    'item_name' => $item->item_name,
                    'qty' => $item->qty,
                    'price' => $item->price,
                    'total' => $item->total,
                    'gst' => $item->gst,
                    'gst_amount' => $item->gst_amount,
                    'grand_amount' => $item->grand_amount,
                ];
            }

            $basic[] = [
                'bill_by' => optional($kt->user_detail)->name,
                'type' => $kt->type,
                'type_number' => $kt->type_number,
                'customer' => $kt->contact_person_name
            ];
        }

        $invoice_date = date('d/m/Y');
        $hotlr = HotlrConfiguration::get(['name','address','invoice_prefix','suffix_length','state','pincode','gst','hsn','mobile','logo','hsn']);
        $invoice_created = KotInvoice::where('status',1)->orderBy('id','desc')->get(['invoice_id','invoice_date']);
        $next_number = 1;
        if(sizeof($invoice_created) > 0){
            $invoice_date = date('d/m/Y',strtotime($invoice_created[0]->invoice_date));
            $invoice_id = $invoice_created[0]->invoice_id;
            $next_number = intval($invoice_id)+1;
        }
        $invoice_number = str_pad($next_number, $hotlr[0]->suffix_length, '0', STR_PAD_LEFT);
        $created_invoice = 'FB-'.$hotlr[0]->invoice_prefix.''.$invoice_number;
        
        
        return view('backend.modules.invoice.kot.view_invoice',compact('random_id','total_amount','dicount_percentage_value','dicount_amount_value','tax_value','total_cgst_value','total_sgst_value','total_igst_value','round_off','payment_mode_value','reference_code','remaining_amount','showPerforma','hotlr','kotList','basic','created_invoice','invoice_date','guest_name','company_gst'));
    }

    public function generateInvoiceKot(Request $request){
        
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'total_amount' => ['required'],
                'random_number' => ['required'],
                'payment_mode' => ['required'],
                'remaining_amount' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        $next_number = 1;
        $companies = HotlrConfiguration::get(['name','address','invoice_prefix','suffix_length','state','pincode','gst','mobile']);
        $invoice_created = KotInvoice::where('status',1)->get(['invoice_id','invoice_date']);
        if(sizeof($invoice_created) > 0){
            $invoice_id = $invoice_created[0]->invoice_id;
            $next_number = str_replace($companies[0]->invoice_prefix, "", $invoice_id) + 1;
        }
        $invoice_number = str_pad($next_number, $companies[0]->suffix_length, '0', STR_PAD_LEFT);
        $created_invoice = $companies[0]->invoice_prefix.''.$invoice_number;

        DB::beginTransaction(); 

        try{
            $amount_after_discount = $request->total_amount - $request->dicount_amount;
            $amount_after_tax = $amount_after_discount + $request->total_igst;

            $invoice = new KotInvoice();
            $invoice->invoice_id = $created_invoice;
            $invoice->type = 'Restaurant';
            $invoice->kots = $request->random_number;
            $invoice->invoice_date = date('Y-m-d H:i:s');
            $invoice->guest_name = $request->guest_name;
            $invoice->guest_gst = $request->company_gst;
            $invoice->total = $request->total_amount;
            $invoice->dis_per = $request->discount_percentage;
            $invoice->dis_amount = $request->dicount_amount;
            $invoice->amount_after_discount = $amount_after_discount;
            $invoice->cgst_per = ($request->tax_value)/2;
            $invoice->sgst_per = ($request->tax_value)/2;
            $invoice->igst_per = $request->tax_value;
            $invoice->cgst_amount = $request->total_cgst;
            $invoice->sgst_amount = $request->total_sgst;
            $invoice->igst_amount = $request->total_igst;
            $invoice->amount_after_tax = $amount_after_tax;
            $invoice->round_off = $request->round_off;
            $invoice->pay_amount = $request->remaining_amount;
            $invoice->payment_mode = $request->payment_mode;
            $invoice->reference = $request->reference_code;
            $invoice->received_by = Auth::user()->id;

            if($invoice->save()){
                $ids_array = explode(',',$request->random_number);
                $kots = Kot::whereIn('id',$ids_array)->update([
                    'bill_number' => $created_invoice,
                    'bill_date' => date('Y-m-d H:i:s'),
                    'generated_bill_by' => Auth::user()->id
                ]);
            }

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Invoice created successfully'], 200);
        }catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }


}
