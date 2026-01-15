<?php

namespace App\Http\Controllers\backend\report;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HotlrConfiguration;
use App\Models\Item;
use App\Models\Kot;
use App\Models\KotItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KotItemController extends Controller
{
    public function index(){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.report.kot_item_report',compact('hotlr'));
    }

    public function kotItemReportView(Request $request){

        $dateFrom = $_GET["date_from"];
        $dateTo   = $_GET["date_to"];
        if($dateFrom == '' || $dateTo == ''){
            return DataTables::of(collect([]))->make(true);
        }
        $resRoom = Kot::with(['items.itemDetail'])->whereBetween('order_time',[$dateFrom,$dateTo])->get();
        $total_cash = 0;
        $total_card = 0;
        $total_amount = 0;
        foreach ($resRoom as $row) {
            
            if($row->payment_type == 1 || $row->payment_type == 'Cash' ){
                $total_cash += $row->grand_total;
            }else if($row->payment_mode == 2 || $row->payment_type == 'Card'){
                $total_card += $row->grand_total;
            }else{
                $total_amount += $row->grand_total;
            }
        }
        return DataTables::of($resRoom)
            ->addIndexColumn()
            ->addColumn('kot_no', function ($row) {
                return 'KOT' . date('Ymd') . $row->id;
            })
            ->addColumn('item_name', function ($row) {
                return '<ul>' . $row->items->pluck('item_name')->map(
                    fn($name) => "<li>{$name}</li>"
                )->implode('') . '</ul>';
            })
            ->addColumn('category', function ($row) {
                $kot_items = KotItem::where('kot_id',$row->id)->get(['item_id']); 
                $html = '<ul>'; 
                foreach($kot_items as $item){ 
                    $item_detail = Item::where('id',$item->item_id)->value('category');
                    $category_name = Category::where('id',$item_detail)->value('name');
                    $html .= '<li>'.$category_name.'</li>'; 
                } 
                $html .= '</ul>'; 
                return $html;
            })
            ->addColumn('quantity', function ($row) {
                return '<ul>' . $row->items->pluck('qty')->map(
                    fn($qty) => "<li>{$qty}</li>"
                )->implode('') . '</ul>';
            })
            ->addColumn('rate', function ($row) {
                return '<ul>' . $row->items->pluck('grand_amount')->map(
                    fn($amount) => "<li>{$amount}</li>"
                )->implode('') . '</ul>';
            })
            ->addColumn('amount', fn($row) => $row->grand_total)
            ->addColumn('status', fn($row) => $row->order_status)
            ->rawColumns(['item_name', 'category', 'quantity', 'rate'])
            ->with([
                'total_amount' => $total_amount,
                'total_cash'  => $total_cash,
                'total_card'  => $total_card,
            ])
            ->make(true);
    }
}
