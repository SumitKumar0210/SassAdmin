<?php

namespace App\Http\Controllers\backend\restaurant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HotlrConfiguration;
use App\Models\Item;
use App\Models\ItemAddon;
use App\Models\ItemAttribute;
use App\Models\ItemExtra;
use App\Models\ItemLabel;
use App\Models\Label;
use App\Models\ItemRequireMaterial;
use App\Models\ItemVariation;
use App\Models\Measurement;
use App\Models\Module;
use App\Models\RawMaterial;
use App\Models\TaxSlab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

class RestaurantItemController extends Controller{

    public function index(Request $request){
        $measurements = Measurement::where('status',1)->whereNull('deleted_at')->get();
        $raw_materials = RawMaterial::where('status',1)->whereNull('deleted_at')->get();
        $categories = Category::where('status',1)->whereNull('deleted_at')->get();
        $attributes = ItemAttribute::where('status',1)->whereNull('deleted_at')->get();
        $items = Item::where('status',1)->whereNull('deleted_at')->get();
        $labels = Label::where('status',1)->whereNull('deleted_at')->get();
        $taxList = [];
        $rawMaterials = [];
        foreach($raw_materials as $material){
            $data = [
                'id' => $material->id,
                'code' => $material->code,
                'name' => $material->name,
                'uom' => $material->measurement_detail->short_name ?? '',
                'uom_child' => $material->measurement_detail->child_symbol ?? '',
                'min' => $material->min_qty,
                'max' => $material->max_qty,
            ];
            array_push($rawMaterials,$data);
        }
        $default_tax = 0;
        $uri_path = URL::current();
        $uri_segments = request()->segments();
        $module =  $uri_segments[0];
        $tax_category = Module::where('module',ucfirst($module))->pluck('id');
        if(sizeof($tax_category) > 0){
            $tax_slabs = TaxSlab::where('category_id',$tax_category[0])->where('default_tax',1)->where('status',1)->pluck('rate');
            foreach($tax_slabs as $slab){
                $default_tax += $slab;
            }
            
            $tav_value=0;
            $taxes = TaxSlab::where('status',1)->where('category_id',$tax_category[0])->where('default_tax',0)->get();
            foreach($taxes as $tax_slab){
                $tav_value = $tax_slab['rate'];

                $data = [
                    'value' => $tav_value,
                    'name' => $tax_slab['name']
                ];
                array_push($taxList,$data);
            }
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.restaurant.restaurant_item',compact('measurements','rawMaterials','categories','items','labels','attributes','taxList','default_tax','hotlr'));
    }

    public function getDetails(Request $request){
        if ($request->ajax()){
            $data = Item::whereNull('deleted_at')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                return '<img src="'.asset('backend/uploads/Item/' . $row->image . '').'" height="50px" width="60px">';
            })
            ->addColumn('code', function ($row) {
                return $row->code ?? '';
            })
            ->addColumn('name', function ($row) {
                return $row->name ?? '';
            })
            ->addColumn('uom', function ($row) {
                return $row->measurement_detail->short_name ?? '';
            })
            ->addColumn('price', function ($row) {
                return $row->price;
            })
            ->addColumn('gst', function ($row) {
                return $row->gst.'%';
            })
            ->addColumn('mrp', function ($row) {
                return $row->total;
            })
            ->addColumn('category', function ($row) {
                return $row->category_detail->name ?? '';
            })
            ->addColumn('label', function ($row) {
                $count = sizeof($row->label_detail);
                $html = '';
                if($count > 0){
                    $html .= '<ul>';
                    foreach($row->label_detail as $lab){
                        $html .= '<li>'.$lab->master_label_detail->name ?? ''.'</li>';
                    }
                    $html .= '</ul>';
                }
                return $html;
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                return '<div class="flex-grow-1 icon-state switch-outline">
                        <label class="switch mb-0" onchange="restaurantItemSwitch('.$row->id.')">
                        <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                        </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRestaurantItem('.$row->id.')"></i></a></li>
                        <li class="delete ms-1" id="deleteBtn" onclick="deleteRestaurantItem('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['image','status','action','label'])
            ->make(true);
        }
    }

    public function store(Request $request){
       
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'uom' => ['required'],
                'category' => ['required'],
                'internal' => ['required'],
                'type' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        DB::beginTransaction();
        try {
            $raw_material = json_decode($request->raw_material);
            $variation = json_decode($request->variation);
            $extra = json_decode($request->extra);
            $addon = json_decode($request->addon);

            $items = new Item();
            $items->code = $request->code;
            $items->name = $request->name;
            $items->uom = $request->uom;
            $items->price = $request->price ?? 0;
            $items->offer_price = $request->offer_price ?? 0;
            $items->gst = $request->gst ?? 0;
            $items->gst_amount = $request->gst_amount ?? 0;
            $items->total = $request->total ?? 0;
            $items->category = $request->category;
            $items->sub_category = $request->sub_category;
            $items->label = $request->label;
            $items->only_internal = $request->internal;
            $items->type = $request->type;
            $items->status = $request->status;
            $items->description = $request->desc;
            $imagedata = $request->file('image');
            if ($imagedata) {
                $imageName = time() . '.' . $imagedata->getClientOriginalExtension();
                $destinationPath = public_path('/backend/uploads/Item');
                $imagedata->move($destinationPath, $imageName);
                $items->image = $imageName;
            }
            
            if($items->save()){
                $chk = 1;
                if($request->label != ""){
                    $labels = explode(',',$request->label);
                    foreach($labels as $lab){
                        $item_label = new ItemLabel();
                        $item_label->item_id = $items->id;
                        $item_label->label_id = $lab;
                        if($item_label->save()){ }else{
                            $chk = 0;
                        }
                    }
                }

                if($raw_material != ""){
                    foreach($raw_material as $material){
                        $required_material = new ItemRequireMaterial();
                        $required_material->item_id = $items->id;
                        $required_material->material_id = $material->id;
                        $required_material->qty = $material->qty;
                        $required_material->uom = $material->uom;
                        if($required_material->save()){ }else{
                            $chk = 0;
                        }
                    }
                }

                if($variation != ""){
                    foreach($variation as $vari){
                        $item_vari = new ItemVariation();
                        $item_vari->item_id = $items->id;
                        $item_vari->attribute_id = $vari->id;
                        $item_vari->name = Str::title($vari->sub_attribute_name);
                        $item_vari->price = $vari->price; 
                        $item_vari->type = $vari->sub_attribute_id;
                        $item_vari->save();
                        if($item_vari->save()){ }else{
                            $chk = 0;
                        }
                    }
                }
                
                if($extra != ""){
                    foreach($extra as $extraItem){
                        $item_extra = new ItemExtra();
                        $item_extra->item_id = $items->id;
                        $item_extra->new_item_id = $extraItem->id;
                        $item_extra->name = Str::title($extraItem->name);
                        $item_extra->price = $extraItem->price;
                        if($item_extra->save()){ }else{
                            $chk = 0;
                        }
                    }
                }
                
                if($addon != ""){
                    foreach($addon as $addonItem){
                        $addon_extra = new ItemAddon();
                        $addon_extra->item_id = $items->id;
                        $addon_extra->addon_item_id = $addonItem->id;
                        $addon_extra->variation = $addonItem->variation;
                        $addon_extra->price = $addonItem->price;
                        if($addon_extra->save()){ }else{
                            $chk = 0;
                        }
                    }
                }
                // if ($chk) {
                //     return response()->json(['success' => 'Data added successfully'], 200);
                // } else {
                //     return response()->json(['error' => 'Something Went Wrong'], 400);
                // }
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }

    public function switchStatus(Request $request){
        $rc_status = Item::where('id',$request->id)->pluck('status');
        $status = $rc_status[0];
        $new_status = 1;
        if($status == 1){
            $new_status = 0;
        }
        Item::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getMenu(Request $request){
        $getItem = Item::where('id',$request->id)->get();
        $rawMaterials = [];
        $itemVariation = [];
        $getRawMaterials = ItemRequireMaterial::where('item_id',$request->id)->where('status',1)->get();
        foreach($getRawMaterials as $raw){

            $data = [
                'id' => $raw['material_id'],
                'name' => optional($raw->material_detail)->name ?? '',
                'min' => optional($raw->material_detail)->min_qty ?? '',
                'max' => optional($raw->material_detail)->max_qty ?? '',
                'qty' => $raw['qty'],
                'uom' => $raw['uom'],
            ];
            array_push($rawMaterials,$data);
        }
        $getVariations = ItemVariation::where('item_id',$request->id)->where('status',1)->get();
        foreach($getVariations as $varia){

            $data = [
                'id' => $varia['attribute_id'],
                'attribute_name' => optional($varia->attribute_detail)->name ?? '',
                'sub_attribute_id' => $varia['type'],
                'sub_attribute_name' => optional($varia->attribute_type_detail)->name ?? '',
                'price' => $varia['price'],
            ];
            array_push($itemVariation,$data);
        }

        $sub_categories = [];
        if($getItem[0]['sub_category'] > 0){
            $category_type = Category::where('id',$getItem[0]['sub_category'])->pluck('type');
            $categories = Category::where('type',$category_type[0])->get();
            if(sizeOf($categories) > 0){
                foreach($categories as $cat){
                    $data = [
                        'id' => $cat['id'],
                        'name' => $cat['name']
                    ];
                    array_push($sub_categories,$data);
                }
            }
        }

        $getExtra = ItemExtra::where('item_id',$request->id)->where('status',1)->get();
        $getAddon = ItemAddon::where('item_id',$request->id)->where('status',1)->get();
        $itemAddons = [];
        foreach($getAddon as $addon){
            $itemAddons[] = [
                'id' => $addon->id,
                'item_id' => $addon->item_id,
                'item_name' => optional($addon->item_detail)->name ?? '',
                'addon_item_id' => $addon->addon_item_id,
                'addon_item_name' => optional($addon->item_detail_addon)->name ?? '',
                'variation' => $addon->variation,
                'variation_name' => optional($addon->item_variant_detail)->name ?? '',
                'price' => $addon->price,
            ];
        }

        return response()->json(['success' => 'Data Fetched Successfully','getItem'=>$getItem[0],'getRawMaterial'=>$rawMaterials,'getVariation'=>$itemVariation,'getExtra'=>$getExtra,'getAddon'=>$itemAddons,'sub_categories'=>$sub_categories],200);
    }

    public function update(Request $request){  
        // dd($request->all());
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => ['required'],
                'uom' => ['required'],
                'category' => ['required'],
                'internal' => ['required'],
                'type' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        $raw_material = json_decode($request->raw_material);
        $variation = json_decode($request->variation);
        $extra = json_decode($request->extra);
        $addon = json_decode($request->addon);
        $update_material = Item::where('id',$request->id)->update([
            'code' => $request->code,
            'name' => $request->name,
            'uom' => $request->uom,
            'price' => $request->price ?? 0,
            'offer_price' => $request->offer_price ?? 0,
            'gst' => $request->gst ?? 0,
            'gst_amount' => $request->tax_amount ?? 0,
            'total' => $request->total ?? 0,
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'label' => $request->label,
            'only_internal' => $request->internal,
            'type' => $request->type,
            'status' => $request->status,
            'description' => $request->desc
        ]);
        
        $imagedata = $request->file('image');
        if ($imagedata) {
            $imageName = time() . '.' . $imagedata->getClientOriginalExtension();
            $destinationPath = public_path('/backend/uploads/Item');
            $imagedata->move($destinationPath, $imageName);
            $update_material = Item::where('id',$request->id)->update([
                'image' => $imageName
            ]);
        }
        if($update_material){
            $chk = 1;
            if($request->label != ""){
                $labels = explode(',',$request->label);
                $setStatus = ItemLabel::where('item_id',$request->id)->update([
                    'status' => 0
                ]);
                foreach($labels as $lab){
                    $itemlabels = ItemLabel::where('item_id',$request->id)->where('label_id',$lab)->count();
                    if($itemlabels){
                        $setStatus = ItemLabel::where('item_id',$request->id)->where('label_id',$lab)->update([
                            'status' => 1
                        ]); 
                    }else{
                        $item_label = new ItemLabel();
                        $item_label->item_id = $request->id;
                        $item_label->label_id = $lab;
                        if($item_label->save()){ }else{
                            $chk = 0;
                        }
                    }
                }
            }

            if($raw_material != ""){
                $setStatus = ItemRequireMaterial::where('item_id',$request->id)->update([
                    'status' => 0
                ]);
                foreach($raw_material as $material){
                    $qty = $material->qty;
                    $material_db = RawMaterial::where('id',$material->id)->pluck('uom');
                    $measurement = Measurement::where('id',$material_db[0])->get();
                    if($material->uom != $measurement[0]['short_name']){
                        $qty = ($material->qty/$measurement[0]['conversion']);
                    }
                    $itemlabels = ItemRequireMaterial::where('item_id',$request->id)->where('material_id',$material->id)->count();
                    if($itemlabels){
                        $setStatus = ItemRequireMaterial::where('item_id',$request->id)->where('material_id',$material->id)->update([
                            'status' => 1,
                            'qty' => $qty,
                            'uom' => $material->uom
                        ]); 
                    }else{
                        $required_material = new ItemRequireMaterial();
                        $required_material->item_id = $request->id;
                        $required_material->material_id = $material->id;
                        $required_material->qty = $qty;
                        $required_material->uom = $material->uom;
                        if($required_material->save()){ }else{
                            $chk = 0;
                        }
                    }
                }
            }

            if($variation != ""){
                $setStatus = ItemVariation::where('item_id',$request->id)->update([
                    'status' => 0
                ]);
                foreach($variation as $vari){
                    $itemvar = ItemVariation::where('item_id',$request->id)->where('attribute_id',$vari->id)->where('type',$vari->sub_attribute_id)->count();
                    if($itemvar){
                        $setStatus = ItemVariation::where('item_id',$request->id)->where('attribute_id',$vari->id)->where('type',$vari->sub_attribute_id)->update([
                            'status' => 1,
                            'name' => Str::title($vari->sub_attribute_name),
                            'price' => $vari->price,
                        ]);
                    }else{
                        $item_vari = new ItemVariation();
                        $item_vari->item_id = $request->id;
                        $item_vari->attribute_id = $vari->id;
                        $item_vari->name = Str::title($vari->sub_attribute_name);
                        $item_vari->price = $vari->price; 
                        $item_vari->type = $vari->sub_attribute_id;
                        $item_vari->save();
                        if($item_vari->save()){ }else{
                            $chk = 0;
                        }
                    }
                }
            }
            
            if($addon != ""){
                $setStatus = ItemAddon::where('item_id',$request->id)->update([
                    'status' => 0
                ]);
                foreach($addon as $addonItem){
                    $itemvar = ItemAddon::where('item_id',$request->id)->where('addon_item_id',$addonItem->id)->where('variation',$addonItem->variation)->count();
                    if($itemvar){
                        $setStatus = ItemAddon::where('item_id',$request->id)->where('addon_item_id',$addonItem->id)->where('variation',$addonItem->variation)->update([
                            'status' => 1,
                            'price' => $addonItem->price,
                        ]);
                    }else{
                        $addon_extra = new ItemAddon();
                        $addon_extra->item_id = $request->id;
                        $addon_extra->addon_item_id = $addonItem->id;
                        $addon_extra->variation = $addonItem->variation;
                        $addon_extra->price = $addonItem->price;
                        $addon_extra->save();
                        if($addon_extra->save()){ }else{
                            $chk = 0;
                        }
                    }
                }
            }
            
            // $extra and addon code discussion
            if ($chk) {
                return response()->json(['success' => 'Data updated successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Item Name already exists! Enter another...']);
        }
        
        return $response;
    }

    public function delete(Request $request){
        Item::where('id',$request->id)->update([
            'deleted_at' => now(),
            'status' => 0
        ]);
        return response()->json(['success' => 'Item Deleted Successfully'],200);
    }
}
