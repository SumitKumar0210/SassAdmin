<?php

namespace App\Http\Controllers\backend\store;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\RawMaterial;
use App\Models\Stock;
use App\Models\StoreRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function transferReport(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.report.transfer-report',compact('hotlr'));
    }

    public function transferReportVeiw(Request $request){
        if($request->ajax()){
            $transfer_request = StoreRequest::whereNotNull('date_of_transfer')->get();
            return DataTables::of($transfer_request)
            ->addIndexColumn()
            ->addColumn('from',function($row){
                return 'Warehouse';
            })
            ->addColumn('to', function($row) {
                return $row->departmentData->name ?? 'NA';
            })
            ->addColumn('item', function($row) {
                return $row->itemData->name ?? 'NA';
            })
            ->addColumn('qty',function($row){
                return $row->received_qty ?? 0;
            })
            ->addColumn('unit',function($row){
                return $row->measurement_detail->name ?? 'NA';
            })
            ->addColumn('request_date',function($row){
                return $row->created_at->format('d-m-Y');
            })
            ->addColumn('transfer_date', function($row) {
                return \Carbon\Carbon::parse($row->date_of_transfer)->format('d-m-Y');
            })
            ->make(true);
        }
    }

    public function deficiencyReport(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.report.deficiency-report',compact('hotlr'));
    }
    
    public function deficiencyReportVeiw(Request $request){
        if($request->ajax()){
            $raw_material = RawMaterial::get()->filter(function($row) {
                $stock_qty = Stock::where('item_id', $row->id)->pluck('qty')->first() ?? 0;
                $transfer_qty = StoreRequest::where('item_id', $row->id)->sum('received_qty') ?? 0;
                $row->available_qty = $stock_qty - $transfer_qty;
                return $row->available_qty <= $row->min_qty;
            });
            return DataTables::of($raw_material)
            ->addIndexColumn()
            ->addColumn('item',function($row){
                return $row->name ?? 'NA';
            })
            ->addColumn('unit', function($row) {
                return $row->measurement_detail->name ?? 'NA';
            })
           ->addColumn('qty', function($row) {
                return $row->available_qty ?? 0;
            })
            ->addColumn('min_limit',function($row){
                return $row->min_qty ?? 0;
            })
            ->addColumn('max_limit',function($row){
                return $row->max_qty ?? 0;
            })
            ->make(true);
        }
    }

    public function wasteDisposeReport(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.store.report.expired-item-report',compact('hotlr'));
    }

    public function wasteDisposeReportView(Request $request){
        if($request->ajax()){
            $stocks = Stock::whereDate('expiry_date','<=',Carbon::today())->where('department_id',1)->get();
            return DataTables::of($stocks)
            ->addIndexColumn()
            ->addColumn('item',function($row){
                return $row->rawMaterialDetail->name ?? 'NA';
            })
            ->addColumn('unit', function($row) {
                return $row->rawMaterialDetail->measurement_detail->name ?? 'NA';
            })
           ->addColumn('qty', function($row) {
                return $row->qty ?? 0;
            })
            ->addColumn('expired',function($row){
                return date('d-m-Y',strtotime($row->expiry_date));
            })
            ->addColumn('action', function($row) {
                if($row->status == 0){
                    return '';
                }else{
                    return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-trash text-danger" onclick="disposeItem(`' . $row->id . '`)"></i></a></li>
                        </ul>';
                }
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    public function wasteDisposeItem(Request $request){
        $update_stock = Stock::where('id',$request->id)->update([
            'status' => 0
        ]);
        if($update_stock){
            return response()->json(['success'=>'Item Disposed successfully'],200);
        }else{
            return response()->json(['error_success'=>'Unable to dispose the item. Please try again.']);
        }
    }
}
