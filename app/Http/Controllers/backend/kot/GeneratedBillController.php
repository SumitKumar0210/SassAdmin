<?php

namespace App\Http\Controllers\backend\kot;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Item;
use App\Models\Kot;
use App\Models\KotInvoice;
use App\Models\KotItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeneratedBillController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $tables_occupied = [];
        $room_occupied = [];
        $kots = Kot::whereNotNull('bill_number')->get();
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

        return view('backend.modules.kot.bill-paid',compact('hotlr','tables_occupied','room_occupied','kots'));
    }

    public function getBillPaid(Request $request){
        if($request->ajax()){
            if($request->table != null || $request->room != null){
                if($request->table != ''){
                    $kots = Kot::whereNotNull('bill_number')->where('type','Table')->where('type_number',$request->table)->get();
                }else{
                    $kots = Kot::whereNotNull('bill_number')->where('type','Room')->where('type_number',$request->room)->get();
                }
            }else {
                $kots = Kot::whereNotNull('bill_number')->get();
            }
            return DataTables::of($kots)
            ->addColumn('bill',function($row){
                return $row->bill_number;
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
                return 'Paid';
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
            ->addColumn('action',function($row){
                $html ='<div class="dropdown icon-dropdown">
                            <button class="btn dropdown-toggle w-25" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-fill"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">
                            <a class="dropdown-item" href="javascript:;" onclick="kotPrintBill(`'.$row->bill_number.'`)"><i class="icofont icofont-print text-primary"></i> Print</a>
                            <a class="dropdown-item" href="javascript:;" onclick="cancelKotBill(`'.$row->bill_number.'`)"><i class="ri-close-fill text-danger"></i> Cancel</a>';
                            $html .='</div>
                        </div>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function cancelGeneratedBill(Request $request){
        DB::beginTransaction();
        try{
            $update = KotInvoice::where('invoice_id',$request->id)->update([
                'status' => 2
            ]);
            
            if($update){
                $update = Kot::where('bill_number',$request->id)->update([
                    'bill_number' => NULL
                ]);
            }

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Paid Bill Cancelled Successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }

    public function invoiceGeneratedBill($para){
        $invoices = KotInvoice::where('invoice_id',$para)->get();
        $kot_list = explode(',',$invoices[0]->kots);
        $kot = [];
        foreach($kot_list as $list){
            $kot_items = KotItem::where('kot_id',$list)->get();
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

            $kots = Kot::where('id',$list)->get();
            $basic[] = [
                'bill_by' => optional($kots[0]->user_detail)->name,
                'type' => $kots[0]->type,
                'type_number' => $kots[0]->type_number,
                'customer' => $kots[0]->contact_person_name
            ];
        }
        
        $total_amount = $invoices[0]->total_amount;
        $dicount_percentage_value = $invoices[0]->dis_per;
        $dicount_amount_value = $invoices[0]->dis_amount;
        $tax_value = $invoices[0]->igst_per;
        $total_cgst_value = $invoices[0]->cgst_amount;
        $total_sgst_value = $invoices[0]->sgst_amount;
        $total_igst_value = $invoices[0]->igst_amount;
        $round_off = $invoices[0]->round_off;
        $reference_code = $invoices[0]->reference;
        $remaining_amount = $invoices[0]->pay_amount;
        $showPerforma = 1;
        $created_invoice = $invoices[0]->invoice_id;
        $invoice_date = $invoices[0]->invoice_date;
        $guest_name = $invoices[0]->guest_name;
        $company_gst = $invoices[0]->guest_gst;

        $hotlr = HotlrConfiguration::get(['name','address','invoice_prefix','suffix_length','state','pincode','gst','hsn','mobile','logo','hsn']);
        
        return view('backend.modules.invoice.kot.view_invoice',compact('total_amount','dicount_percentage_value','dicount_amount_value','tax_value','total_cgst_value','total_sgst_value','total_igst_value','round_off','remaining_amount','showPerforma','hotlr','kotList','basic','created_invoice','invoice_date','guest_name','company_gst'));
    }
}
