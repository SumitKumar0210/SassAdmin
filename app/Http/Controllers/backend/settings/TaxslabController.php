<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\Module;
use App\Models\TaxSlab;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaxslabController extends Controller
{
    public function index(){
        $tax_categories = Module::where('isTaxable',1)->where('status',1)->get();
        $taxes = TaxSlab::where('status',1)->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.taxslab',compact('tax_categories','taxes','hotlr'));
    }

    public function getData(Request $request){
        if($request->ajax()){
            $taxslabs = TaxSlab::get();
            return DataTables::of($taxslabs)
            ->addIndexColumn()
            ->addColumn('category',function($row){
                return $row->tax_category->module ?? '';
            })->addColumn('name',function($row){
                $html = '';
                if($row->belongs_to != ''){
                    $html = '<i class="ri-links-line text-warning"></i>';
                }
                if($html == ''){
                    $chkAny = TaxSlab::where('status',1)->where('belongs_to',$row->id)->count();
                    if($chkAny > 0){
                        $html = '<i class="ri-links-line text-warning"></i>';
                    }
                }
                return $row->name.''.$html;
            })
            ->addColumn('rate',function($row){
                return $row->rate .' %';
            })
            ->addColumn('default',function($row){
                $checked = $row->default_tax == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="switchDefaultTax('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="taxSlabSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"><a href="#"><i class="icon-pencil-alt" onclick="editTaxSlab('.$row->id.')"></i></a></li>
                        <li class="delete ms-1 d-none" id="deleteBtn" onclick="deleteTaxSlab('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action','name','default'])
            ->make(true);
        }
    }

    public function store(Request $request){
        $check_slab_exist = TaxSlab::where('name',$request->name)->where('category_id',$request->category)->where('rate',$request->rate)->exists();
        if($check_slab_exist == false){
            $taxslab = new TaxSlab();
            $taxslab->name = $request->name;
            $taxslab->rate = $request->rate;
            $taxslab->category_id = $request->category;
            $taxslab->belongs_to = $request->releted_to;
            // $taxslab->default_tax = $request->set_default;
            if ($taxslab->save()){
                $response = response()->json(['success'=>'Data addedd successfully'],200);
            } else{
                $response = response()->json(['error'=>'Data not addedd successfully'],400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'This tax slab already found! Enter another...']);
        }
        return $response;
    }

    public function getDetails(Request $request){
        $getData = TaxSlab::where('id',$request->id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData[0]],200);
    }

    public function update(Request $request){
        TaxSlab::where('id',$request->id)->update([
            'name' => $request->name,
            'rate' => $request->rate,
            'category_id' => $request->category,
            'belongs_to' => $request->releted_to
        ]);
       return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function delete(Request $request){
        TaxSlab::where('id',$request->id)->delete();
        return response()->json(['success' => 'Tax Slab Deleted Successfully'],200);
    }

    public function switchDefaultTax(Request $request){
        $id = $request->id;
        $getTax = TaxSlab::find($id);
        $default_tax = $getTax->default_tax;
        TaxSlab::where('category_id',$getTax->category_id)->update([
            'default_tax' => 0,
        ]);

        if($default_tax != 1){
            TaxSlab::where('id',$request->id)->update([
                'default_tax' => 1,
            ]);

            TaxSlab::where('belongs_to',$request->id)->update([
                'default_tax' => 1,
            ]);

            if($getTax->belongs_to != NULL){
                TaxSlab::where('id',$getTax->belongs_to)->update([
                    'default_tax' => 1,
                ]); 
            }
        }
        return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function switchStatus(Request $request){
        $rc_status = TaxSlab::where('id',$request->id)->pluck('status');
        $status = $rc_status[0];
        $new_status = 1;
        if($status == 1){
            $new_status = 0;
        }
        TaxSlab::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
}