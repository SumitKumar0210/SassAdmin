<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Item;
use App\Models\KotItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ItemwiseSalesController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.item_wise_sale_report',compact('hotlr'));
    }

    public function itemWiseSaleView(Request $request){

        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $items = [];
        $dateTo = $dateTo.' 23:59:59';
        $item_distinct = KotItem::distinct()->whereBetween('created_at',[$dateFrom,$dateTo])->pluck('item_id');
        foreach($item_distinct as $item){

            $item_details = Item::where('id',$item)->get(['name','category']);

            $total_qty = KotItem::where('item_id',$item)->whereBetween('created_at',[$dateFrom,$dateTo])->sum('qty');
            $total = KotItem::where('item_id',$item)->whereBetween('created_at',[$dateFrom,$dateTo])->sum('total');
            $total_amount = KotItem::where('item_id',$item)->whereBetween('created_at',[$dateFrom,$dateTo])->sum('grand_amount');
            $gst_amount = KotItem::where('item_id',$item)->whereBetween('created_at',[$dateFrom,$dateTo])->sum('gst_amount');
            $dis = ((($total + $gst_amount) - $total_amount) / ($total+$gst_amount)) * 100;
            $items[] = [
                'item_name' => $item_details[0]->name,
                'category' => optional($item_details[0]->category_detail)->name ?? '',
                'qty_sold' => $total_qty ?? 0,
                'gross_amount' => $total ?? 0,
                'discount' => $dis,
                'gst_amount' => $gst_amount ?? 0,
                'net_amount' => $total_amount ?? 0,
            ];
        }
        return DataTables::of($items)
        ->addIndexColumn()
        ->addColumn('item_name',function($row){
            return $row['item_name'];
        })
       ->addColumn('category',function($row){
            return $row['category'];
        })
        ->addColumn('qty_sold',function($row){
            return $row['qty_sold'];
        })
        ->addColumn('gross_amount',function($row){
            return $row['gross_amount'];
        })
        ->addColumn('discount',function($row){
            return $row['discount'].' %';
        })
        ->addColumn('gst_amount',function($row){
            return $row['gst_amount'];
        })
        ->addColumn('net_amount',function($row){
            return $row['net_amount'];
        })
        ->make(true);
    }
}
