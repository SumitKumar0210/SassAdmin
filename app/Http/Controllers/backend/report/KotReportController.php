<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Kot;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
class KotReportController extends Controller
{
    public function index(Request $request){
        $payments = PaymentMethod::where('status',1)->get(['id','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.kot_report',compact('payments','hotlr'));
    }

    public function kotReportView(Request $request){

        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $resRoom = Kot::with(['items', 'reservation'])->whereBetween('date', [$dateFrom, $dateTo])->whereNull('menu_type')->get();
        return DataTables::of($resRoom)
        ->addIndexColumn()
        ->addColumn('kot_id', fn($row) => 'KOT-' . date('Ym', strtotime($row->date)) . $row->id)
        ->addColumn('order_date', fn($row) => date('d-m-Y', strtotime($row->date)))
        ->addColumn('order_time', fn($row) => date('h:i A', strtotime($row->order_time)))
        ->addColumn('order_type', fn() => 'Dining')
        ->addColumn('order_source', fn($row) => $row->type == 'Room' ? 'Room' : 'Restaurant')
        ->addColumn('table_number', fn($row) => $row->type == 'Table' ? $row->type_number : '')
        ->addColumn('room_number', fn($row) => $row->type == 'Room' ? $row->type_number : '')
        ->addColumn('server_id', fn($row) => $row->waiterDetail->name ?? '')
        ->addColumn('guest_name', fn($row) => $row->type == 'Room' ? optional($row->reservation)->name ?? '' : '')
        ->addColumn('guest_contact', fn($row) => $row->type == 'Room' ? optional($row->reservation)->mobile ?? '' : '')
        ->addColumn('special', fn($row) => $row->note)
        ->addColumn('total_item', fn($row) => $row->items->sum('qty'))
        ->addColumn('total_item_cost', fn($row) => $row->total)
        ->addColumn('subtotal', fn($row) => $row->sub_total)
        ->addColumn('tax_amount', fn($row) => round($row->total_gst))
        ->addColumn('service_charge', fn() => 0)
        ->addColumn('discount_applied', fn($row) => $row->discount_value ?? 0)
        ->addColumn('total_amount', fn($row) => $row->grand_total)
        ->addColumn('payment_method', function($row){
            if($row->is_complimentary == 1) { 
                return 'Complimentary'; 
            } else{ 
                return $row->payment_type;
            }
        })
        ->addColumn('action',function($row){
            $html = '';
            $html .='<div class="dropdown icon-dropdown">
                <button class="btn dropdown-toggle" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-fill"></i></button>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">';
                if($row->is_complimentary == 0 && $row->payment_type == 'Complete with Due'){
                    $html .='<a class="dropdown-item" href="javascript:;" onclick="kotRecordPayment('.$row->id.','.$row->grand_total.','.$row->total_paid.')"><i class="ri-money-rupee-circle-line text-info"></i> Record Payment</a>';
                }
                $html .='<a class="dropdown-item" href="javascript:;" onclick="getKotId('.$row->id.')"><i class="ri-exchange-line text-secondary"></i> To Room </a>
                <a class="dropdown-item" href="javascript:;" onclick="printKot(`'.$row->kot_id.'`)"><i class="icofont icofont-print text-primary"></i> Print</a>
                <a class="dropdown-item" href="javascript:;" onclick="cancelKot('.$row->id.')"><i class="ri-close-fill text-danger"></i> Cancel</a>
                </div>
            </div>';
            return $html;
        })
        ->rawColumns(['action'])
        ->make(true);
    }
}

