<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use App\Models\ItemAddon;
use App\Models\ItemAttribute;
use App\Models\ItemVariation;
use App\Models\Kot;
use App\Models\KotItem;
use App\Models\Label;
use App\Models\ReservationRoom;
use App\Models\RoomNumber;
use App\Models\Table;
use App\Models\HotlrConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserMenuController extends Controller
{
    public function index(){
        $itemLists = [];
        $labels = Label::where('status','1')->get(['id','name','image']);
        $config = HotlrConfiguration::get(['name','logo']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('frontend.index',compact('labels','config','hotlr'));
    }

    public function getItemMenuList(Request $request){
       
        $itemLists = [];
        $category_main = Category::where('type','0')->get(['id','name']);
        foreach($category_main as $main_cat){
            $subCategories = [];
            $sub_category = Category::where('type',$main_cat['id'])->get();
            foreach($sub_category as $sub){
                $itemDatas = [];
                $items = Item::where('category',$main_cat['id'])->where('sub_category',$sub['id'])->where('status','1')->get();
                foreach($items as $it){
                    $label_details = [];
                    if(sizeof($it->label_detail) > 0){
                        $lab = $it->label_detail;
                        foreach($lab as $label_name){
                            $data = $label_name->master_label_detail;
                            array_push($label_details,$data);
                        }
                    }
                    
                    $data_item = [
                        'id' => $it['id'],
                        'name' => $it['name'],
                        'code' => $it['code'],
                        'uom' => $it->measurement_detail->name ?? '',
                        'price' => $it['price'],
                        'offer_price' => $it['offer_price'],
                        'gst' => $it['gst'],
                        'gst_amount' => $it['gst_amount'],
                        'total' => $it['total'],
                        'image' => $it['image'],
                        'category_id' => $it->category_detail->id ?? '',
                        'category' => $it->category_detail->name ?? '',
                        'sub_category' => $it->sub_category_detail->name ?? '',
                        'sub_category_id' => $it->sub_category_detail->id ?? '',
                        'type' => $it['type'],
                        'label' => $label_details,
                        'description' => $it['description'],
                        'only_internal' => $it['only_internal'],
                        'variation' => count($it->item_variation_detail)
                    ];
                    array_push($itemDatas,$data_item);
                }
                $data_sub = [
                    'id' => $sub['id'],
                    'name' => $sub['name'],
                    'items' =>  $itemDatas
                ];
                array_push($subCategories,$data_sub);
            }

            $non_category = [];
            $category_items = Item::where('category',$main_cat['id'])->whereNull('sub_category')->get();
            foreach($category_items as $it){
                $label_details = [];
                if(sizeof($it->label_detail) > 0){
                    $lab = $it->label_detail;
                    foreach($lab as $label_name){
                        $data = $label_name->master_label_detail;
                        array_push($label_details,$data);
                    }
                }
                $data_item = [
                    'id' => $it['id'],
                    'name' => $it['name'],
                    'code' => $it['code'],
                    'uom' => $it->measurement_detail->name ?? '',
                    'price' => $it['price'],
                    'offer_price' => $it['offer_price'],
                    'gst' => $it['gst'],
                    'gst_amount' => $it['gst_amount'],
                    'total' => $it['total'],
                    'image' => $it['image'],
                    'category_id' => $it->category_detail->id ?? '',
                    'category' => $it->category_detail->name ?? '',
                    'sub_category' => $it->sub_category_detail->name ?? '',
                    'sub_category_id' => $it->sub_category_detail->id ?? '',
                    'type' => $it['type'],
                    'label' => $label_details,
                    'description' => $it['description'],
                    'only_internal' => $it['only_internal'],
                    'variation' => count($it->item_variation_detail)
                ];
                array_push($non_category,$data_item);
            }
            $data = [
                'id' => $main_cat['id'],
                'name' => $main_cat['name'],
                'sub_categories' => $subCategories,
                'cat_item' => $non_category
            ];
            array_push($itemLists,$data);
        }
        $backend_path = asset('backend/uploads/Item/');
        $frontend_path = asset('frontend/assets/images/');

        $room_ckeckin = 'alloted';
        $menu_types = substr($request->id,0,1);
        $random_qr = substr($request->id,1);
        if($menu_types == 'R'){
            $room_qr = RoomNumber::where('random_code',$random_qr)->get(['id','room_number']);
            $number = $room_qr[0]->id;
            $kot_room = ReservationRoom::where('room_alloted_id',$number)->whereNull('checkedout_at')->get(['reservation_id','id']);
            if(sizeof($kot_room) > 0){ }else{
                $room_ckeckin = 'un-alloted';
            }
        }
        
        return response()->json(['success' => 'Data Fetched Successfully','itemLists'=>$itemLists,'backend_path' => $backend_path, 'frontend_path' => $frontend_path,'room_status' => $room_ckeckin],200);
    }

    public function getItemVariation(Request $request){
        $itemVariation = [];
        $variationsType = [];
        $items = Item::where('id',$request->id)->get();
        $variations = $items[0]->item_variation_detail;
        foreach($variations as $vari){
            if (array_search($vari->attribute_id, array_column($variationsType, 'id')) === FALSE) {
                $variationsType[] = [
                    'id' => $vari->attribute_id,
                    'name' => $vari->attribute_detail->name ?? '',
                    'allow_multiple' => $vari->attribute_detail->allow_multiple ?? '',
                ];
            }

            $itemVariation[] = [
                'id' => $vari->id,
                'item_id' => $request->id,
                'attribute_id' => $vari->attribute_id,
                'attribute_name' => $vari->attribute_detail->name ?? '',
                'sub_attribute_id' => $vari->type,
                'sub_attribute_name' => $vari->attribute_type_detail->name ?? '',
                'price' => $vari->price,
                'type' => 'variation'
            ];
        }
        $type = 'nonveg';
        if($items[0]['type'] == 'Veg'){
            $type = 'veg';
        }

        $addonItem = 0;
        $addons = ItemAddon::where('item_id',$request->id)->get();
        foreach($addons as $add){

            $item_variations = ItemVariation::where('id',$add->variation)->get();
            $items = Item::where('id',$add->addon_item_id)->get(['id','name']);
            foreach($item_variations as $vari){

                $itemVariation[] = [
                    'id' => $vari->id,
                    'item_id' => $add->addon_item_id,
                    'item_name' => $items[0]->name,
                    'attribute_id' => $vari->attribute_id,
                    'attribute_name' => $vari->attribute_detail->name ?? '',
                    'sub_attribute_id' => $vari->type,
                    'sub_attribute_name' => $vari->attribute_type_detail->name ?? '',
                    'price' => $vari->price,
                    'type' => 'Addon'
                ];
                $addonItem++;
            }
        }

        return response()->json(['success' => 'Data Fetched Successfully','id'=>$request->id,'name'=>$items[0]['name'],'image'=>$items[0]['image'],'description'=>$items[0]['description'],'type'=>$items[0]['type'],'price'=>$items[0]['price'],'offer_price'=>$items[0]['offer_price'],'itemVariation' => $itemVariation,'variationsType' => $variationsType,'path' => asset('backend/uploads/Item/'),'frontend_path'=>asset('frontend/assets/images/'.$type.'.png'),'addonItem' => $addonItem],200);
    }

    public function getItemCartDetail(Request $request){
        $itemList = [];
        foreach($request->item as $list){
            $items = Item::where('id',$list['id'])->get();
            $attribute_items = ItemAttribute::where('id',$list['attribute_id'])->get(['type','name']);
            $item_variations = ItemVariation::where('item_id',$list['id'])->get();
            $itemList[] = [
                'id' => $items[0]->id,
                'code' => $items[0]->code,
                'name' => $items[0]->name,
                'price' => $items[0]->price,
                'gst' => $items[0]->gst,
                'qty' => $list['qty'],
                'total_price' => $items[0]->price * $list['qty'],
                'image' => $items[0]->image,
                'gst_amount' => ($items[0]->gst/100) * ($items[0]->price * $list['qty']),
                'attribute' => $list['attribute_id'],
                'attribute_name' => $attribute_items[0]->name,
                'attribute_variant' => $item_variations,
            ];
        }
        return response()->json(['success' => 'Data Fetched Successfully','itemLists'=>$itemList],200);
    }

    public function placeOrder(Request $request){
        
        DB::beginTransaction();
        
        try{
            $rndno = substr((md5(rand())),0, 15);
            $menu_types = substr($request->id,0,1);
            $random_qr = substr($request->id,1);
            $type = 'Table';
            $number = '';
            $reserve_room_id_number = '';
            if($menu_types == 'R'){
                $type = 'Room';
                $room_qr = RoomNumber::where('random_code',$random_qr)->get(['id','room_number']);
                $number = $room_qr[0]->room_number;
                $kot_room = ReservationRoom::where('room_alloted_id',$room_qr[0]->id)->whereNotNull('checkedin_at')->whereNull('checkedout_at')->get(['reservation_id','id']);
                if(sizeof($kot_room) > 0){
                    $rndno =  $kot_room[0]->reservation_id;
                    $reserve_room_id_number = $kot_room[0]->id;
                }
            }else{
                $room_qr = Table::where('random_code',$random_qr)->get(['id','number']);
                $number = $room_qr[0]->number;
                $kot_chk = Kot::where('type',$type)->where('type_number',$number)->where('order_status','Pending')->pluck('kot_id');
                if(sizeof($kot_chk) > 0){
                    $rndno =  $kot_chk[0];
                }
            }

            $item_insert = new Kot();
            $item_insert->menu_type = 'QR';
            $item_insert->menu_id = $request->id;
            $item_insert->type = $type;
            $item_insert->type_number = $number;
            $item_insert->kot_id = $rndno;
            $item_insert->reserve_room_id = $reserve_room_id_number;
            $item_insert->date = date('Y-m-d');
            $item_insert->order_time = date('Y-m-d H:i:s');
            $item_insert->total_item_qty = count($request->item);
            $item_insert->total = $request->total_cost;
            $item_insert->sub_total = $request->total_cost;
            $item_insert->total_gst = $request->total_gst;
            $item_insert->grand_total = $request->grand_total;
            $item_insert->note = $request->note;
            $item_insert->total_paid = 0;
            $item_insert->payment_type = 'Due';
            if ($item_insert->save()) {
                foreach($request->item as $item_data){
                    $item_insert_detail = new KotItem();
                    $item_insert_detail->kot_id = $item_insert->id;
                    $item_insert_detail->item_id = $item_data['id'];
                    $item_insert_detail->item_name = $item_data['name'];
                    $item_insert_detail->qty = $item_data['qty'];
                    $item_insert_detail->price = $item_data['price'];
                    $item_insert_detail->total = $item_data['total_price'];
                    $item_insert_detail->gst = $item_data['gst'];
                    $item_insert_detail->gst_amount = $item_data['gst_amount'];
                    $item_insert_detail->grand_amount = $item_data['mrp'];
                    $item_insert_detail->save();
                }
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }
}
