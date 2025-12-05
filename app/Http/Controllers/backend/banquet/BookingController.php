<?php

namespace App\Http\Controllers\backend\banquet;

use App\Http\Controllers\Controller;
use App\Models\Accessory;
use App\Models\BanquetAccesories;
use App\Models\BanquetBooking;
use App\Models\BanquetMenuItem;
use App\Models\Category;
use App\Models\Event;
use App\Models\Hall;
use App\Models\HotlrConfiguration;
use App\Models\PaymentMethod;
use App\Models\PaymentReceived;
use App\Models\TaxSlab;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
class BookingController extends Controller
{
    public function index(){
        $payments = PaymentMethod::where('status',1)->get(['id','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.banquet.booking',compact('payments','hotlr'));
    }
    
    public function view(Request $request){
        if($request->ajax()){
            $banquet_bookings = BanquetBooking::get();
            return DataTables::of($banquet_bookings)
            ->addIndexColumn()
            ->addColumn('booking_id',function($row){
                return $row->id;
            })
            ->addColumn('client',function($row){
                return $row->client_name;
            })
            ->addColumn('phone',function($row){
                return $row->contact_no;
            })
            ->addColumn('hall',function($row){
                return $row->hall_name;
            })
            ->addColumn('event',function($row){
                return $row->event_name;
            })
            ->addColumn('date',function($row){
                return date('d-m-Y',strtotime($row->event_date)).' '.$row->start_time;
            })
            ->addColumn('end_time',function($row){
                return $row->end_time;
            })
            ->addColumn('guest',function($row){
                return $row->expected_guest_count;
            })
            ->addColumn('amount',function($row){
                return $row->grand_total;
            })
            ->addColumn('paid',function($row){
                return $row->advance_paid;
            })
            ->addColumn('due',function($row){
                return $row->due;
            })
            ->addColumn('status',function($row){
                if($row->status == 1){
                    return 'Booked';
                }else{
                    return 'Drafted';
                }
            })
            ->addColumn('action',function($row){
                $html ='<div class="dropdown icon-dropdown">
                            <button class="btn dropdown-toggle" id="userdropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="ri-more-2-fill"></i></button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userdropdown">
                            <a class="dropdown-item" href="javascript:;" onclick="invoicePrint('.$row->id.')"><i class="icofont icofont-print text-primary"></i> Print</a>
                            <a class="dropdown-item" href="javascript:;" onclick="invoicePrint('.$row->id.')"><i class="icofont icofont-eye-alt text-info"></i> View</a>';
                            if(in_array('Banquet Booking Edit', (explode(',',auth()->user()->permission)))){
                                $html .='<a class="dropdown-item" href="' . route('edit-booking.editBooking', $row->id) . '"><i class="icon-pencil-alt text-warning"></i> Edit</a>';
                            }
                            if(in_array('Banquet Booking Collect Payment', (explode(',',auth()->user()->permission)))){
                                $html .='<a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#banquetBookingPaymentModel" onclick="addPayment('.$row->id.','.$row->due.','.$row->grand_total.')"><i class="ri-bank-card-2-line text-success"></i> Record Payment</a>';
                            }
                            if(in_array('Banquet Booking Delete', (explode(',',auth()->user()->permission)))){
                                $html .='<a class="dropdown-item" href="javascript:;" onclick="cancelBooking('.$row->id.')"><i class="ri-close-fill text-danger"></i> Cancel</a>';
                            }
                            if($row->status == 2){
                                $html .='<a class="dropdown-item" href="javascript:;" data-bs-toggle="modal" data-bs-target="#banquetBookingDraftModel"  onclick="draftBooking('.$row->id.')"><i class="ri-exchange-line text-success"></i> Convert To Booking</a>';
                            }
                            $html .='</div>
                        </div>';
                return $html;
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    public function newBooking(){
        $events = Event::where('status',1)->get(['id','name']);
        $halls = Hall::where('status',1)->get();
        $categoriesList = Category::where('status',1)->where('type',0)->get(['id','name']);
        $categories = []; 
        foreach($categoriesList as $category){
            if(count($category->item_detail) > 0){
                $categories[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            }
        }
        $payment_modes = PaymentMethod::where('status',1)->get(['id','name']);
        $accessories = Accessory::where('status',1)->get(['id','name','rate']);
        $default_tax = 0;
        $default_tax_name = '';
        $taxList = [];
        
        $tax_slabs = TaxSlab::where('category_id',1)->where('default_tax',1)->where('status',1)->get(['name','rate']);
        foreach($tax_slabs as $slab){
            $default_tax += $slab['rate'];
            $default_tax_name .= $slab['name'].'+';
        }
        $taxList[] = [
            'value' => $default_tax,
            'name' => rtrim($default_tax_name, '+')
        ];
        
        $tav_value=0;
        $taxes = TaxSlab::where('status',1)->where('category_id',1)->where('default_tax',0)->get();
        foreach($taxes as $tax_slab){
            $tav_value = $tax_slab['rate'];
            $data = [
                'value' => $tav_value,
                'name' => $tax_slab['name']
            ];
            array_push($taxList,$data);
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.banquet.create-booking',compact('events','halls','accessories','categories','payment_modes','taxList','hotlr'));
    }
    
    public function dataCollect(){
        $halls = Hall::where('status',1)->get();
        $itemList = [];
        $categories = Category::where('status',1)->where('type',0)->get(['id','name']);
        foreach($categories as $category){
            if(count($category->item_detail) > 0){
                $itemList[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'items' => $category->item_detail
                ];
            }
        }
        $accessories = Accessory::where('status',1)->get(['id','name','rate']);
        return response()->json(['success' => 'Data Updated Successfully','halls' => $halls,'accessories' => $accessories,'itemList' => $itemList],200);
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'eventDate' => 'required',
            'eventType' => 'required',
            'startTime' => 'required',
            'client' => 'required',
            'guestCount' => 'required | numeric',
            'phone' => 'required',
            'grand_total' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error_validation'=> $validator->errors()->all(),],422);
        }

        DB::beginTransaction();
        try{
            $booking = new BanquetBooking();
            $booking->event_date = date('Y-m-d',strtotime($request->eventDate)); 
            $booking->event_end_date = date('Y-m-d',strtotime($request->eventEndDate)); 
            $booking->event_id = $request->eventType; 
            $booking->event_name = $request->eventTypeName; 
            $booking->address = $request->address; 
            $booking->start_time = $request->startTime; 
            $booking->end_time = $request->endTime; 
            $booking->client_name = $request->client;
            $booking->company_name = $request->company; 
            $booking->company_gst = $request->company_gst; 
            $booking->company_address = $request->company_address; 
            $booking->expected_guest_count = $request->guestCount; 
            $booking->contact_no = $request->phone; 
            $booking->hall_charge = $request->hall_charge; 
            $booking->discount = $request->hall_discount; 
            $booking->discount_amount = $request->hall_total; 
            $booking->complimentary_room = $request->complimentary_room; 
            $booking->extra_room = $request->hall_extra_room; 
            $booking->per_room_capacity = $request->hall_per_room_capacity; 
            $booking->per_room_charge = $request->hall_per_room_charge; 
            $booking->food_consumption_type = $request->banquet_plate_price; 
            $booking->total_hall_charge = $request->grand_total_hall_charge; 
            $booking->total_food_charge = $request->total_food_charge; 
            $booking->total_accesories_charge = $request->consumable_charge; 
            $booking->extra_room_charge = $request->total_extra_room_charge; 
            $booking->sub_total = $request->sub_total_amount; 
            $booking->total_discount = $request->discount; 
            $booking->total_discount_amount = $request->after_discount; 
            $booking->total_amount = $request->total_amount; 
            $booking->gst = $request->gst; 
            $booking->gst_amount = $request->after_gst; 
            $booking->grand_total = $request->grand_total; 
            $booking->advance_paid = $request->advance_paid; 
            $booking->due = $request->due_total; 
            $booking->note = $request->note; 
            $booking->payment_mode = $request->payment_mode; 
            $booking->reference_number = $request->reference; 
            $booking->adjustment = $request->adjustment; 
            $booking->status = $request->save_type; 
            if(isset($request->selectedHalls)){
                foreach($request->selectedHalls as $hall){
                    $booking->hall_id = $hall['id']; 
                    $booking->hall_name = $hall['name']; 
                    $booking->hall_capacity = $hall['capacity']; 
                    $booking->hall_setup_time = $hall['setup_time']; 
                    $booking->hall_rate = $hall['rate'];
                }
            }
            $booking->created_by = Auth::user()->id;
            if($booking->save()){
                if(isset($request->itemAdded)){
                    foreach($request->itemAdded as $item){
                        $menu_item = new BanquetMenuItem();
                        $menu_item->booking_id = $booking->id;
                        $menu_item->menu_category_id = $item['category_id'];
                        $menu_item->menu_category_name = $item['category_name'];
                        $menu_item->serve_time = $item['time'];
                        $menu_item->item_id = $item['id'];
                        $menu_item->item_name = $item['name'];
                        $menu_item->save();
                    }
                }

                if(isset($request->selectedAccessories)){
                    foreach($request->selectedAccessories as $key => $accessories){
                        $access = new BanquetAccesories();
                        $access->booking_id =  $booking->id;
                        $access->accesories_id = $accessories['id'];
                        $access->accesories_name = $accessories['name'];
                        $access->accesories_rate = $accessories['rate'];
                        $access->accesories_qty = $accessories['qty'];;
                        $access->accesories_amount = $accessories['total'];
                        $access->save();
                    }
                }

                if(isset($request->selectedHalls)){
                    foreach($request->selectedHalls as $hall){
                        $update_hall = Hall::where('id',$hall['id'])->update([
                            'booked_date' => date('Y-m-d',strtotime($request->eventDate)),
                            'booking_id' => $booking->id,
                        ]);
                    }
                }
            }
            
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }

    public function editBooking($id){
        $events = Event::where('status',1)->get(['id','name']);
        $categoriesList = Category::where('status',1)->where('type',0)->get(['id','name']);
        foreach($categoriesList as $category){
            if(count($category->item_detail) > 0){
                $categories[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                ];
            }
        }
        $payment_modes = PaymentMethod::where('status',1)->get(['id','name']);
        $banquets = BanquetBooking::where('id',$id)->get();
        $accessories = Accessory::where('status',1)->get(['id','name','rate']);

        $default_tax = 0;
        $default_tax_name = '';
        $taxList = [];
        
        $tax_slabs = TaxSlab::where('category_id',1)->where('default_tax',1)->where('status',1)->get(['name','rate']);
        foreach($tax_slabs as $slab){
            $default_tax += $slab['rate'];
            $default_tax_name .= $slab['name'].'+';
        }
        $taxList[] = [
            'value' => $default_tax,
            'name' => rtrim($default_tax_name, '+')
        ];
        
        $tav_value=0;
        $taxes = TaxSlab::where('status',1)->where('category_id',1)->where('default_tax',0)->get();
        foreach($taxes as $tax_slab){
            $tav_value = $tax_slab['rate'];
            $data = [
                'value' => $tav_value,
                'name' => $tax_slab['name']
            ];
            array_push($taxList,$data);
        }

        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.banquet.edit-booking',compact('banquets','categories','payment_modes','events','accessories','taxList','hotlr'));
    }

    public function invoice($id){
        $company= HotlrConfiguration::get();
        $banquet_accesories = BanquetAccesories::where('booking_id',$id)->get();
        $banquet_bookings = BanquetBooking::where('id',$id)->get();
        $banquet_menu_items = BanquetMenuItem::where('booking_id',$id)->get();
        $users = User::where('id',$banquet_bookings[0]->created_by)->get(['name','designation']);
        $paymentList = [];

        foreach($banquet_bookings as $payment){
            $paymentList[] = [
                'id' => 0,
                'date' => date('d-m-Y', strtotime($payment->created_at)),
                'mode' => optional($payment->payment_mode_detail)->name,
                'amount' => $payment->advance_paid,
                'received_by' => optional($payment->user_detail)->name,
            ];
        }

        $payments = PaymentReceived::where('type','Banquet')->where('type_id',$id)->get(['id','payment_mode','amount','received_by','created_at']);
        foreach($payments as $payment){
            $paymentList[] = [
                'id' => $payment->id,
                'date' => date('d-m-Y', strtotime($payment->created_at)),
                'mode' => optional($payment->payment_mode_detail)->name,
                'amount' => $payment->amount,
                'received_by' => optional($payment->user_detail)->name,
            ];
        }
        
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.banquet.invoice',compact('banquet_accesories','banquet_bookings','banquet_menu_items','company','users','paymentList','hotlr'));
    }

    public function cancel(Request $request){
        $cancel = BanquetBooking::where('id',$request->id)->update([
            'status' => 2
        ]);
        if($cancel){
            return response()->json(['success'=>'Banquet booking cancelled successfully'],200);
        }else{
             return response()->json(['error_success'=>'Banquet booking not cancelled']);
        }
    }

    public function addPayment(Request $request){
        
        $addBanquetPayment = new PaymentReceived();
        $addBanquetPayment->type = 'Banquet';
        $addBanquetPayment->type_id = $request->id;
        $addBanquetPayment->payment_mode = $request->pmode;
        $addBanquetPayment->txn_number = $request->txn ?? null;
        $addBanquetPayment->amount = $request->amount ?? 0;
        $addBanquetPayment->received_by = Auth::user()->id;
        if($addBanquetPayment->save()){
            $banquet = BanquetBooking::where('id',$request->id)->get(['due']);
            if(sizeOf($banquet) > 0){
                $due_amount = $banquet[0]->due - $request->amount;
                $update_banquet = BanquetBooking::where('id',$request->id)->update([
                    'due' => $due_amount
                ]);
            }
            return response()->json(['success'=>'Payment added successfully'],200);
        }else{
            return response()->json(['error_success'=>'Payment not added']);
        }
    }

    public function getBooking(Request $request){
        $halls = Hall::where('status',1)->get();
        $itemList = [];
        $categories = Category::where('status',1)->where('type',0)->get(['id','name']);
        foreach($categories as $category){
            if(count($category->item_detail) > 0){
                $itemList[] = [
                    'id' => $category->id,
                    'name' => $category->name,
                    'items' => $category->item_detail
                ];
            }
        }
        $accessories = Accessory::where('status',1)->get(['id','name','rate']);
        $banquets = BanquetBooking::where('id',$request->id)->get(['hall_id','event_date','event_end_date']);
        $banquet_menu = BanquetMenuItem::where('booking_id',$request->id)->get();
        $banquet_accessories = BanquetAccesories::where('booking_id',$request->id)->get();
        return response()->json(['success' => 'Data Updated Successfully','halls' => $halls,'accessories' => $accessories,'itemList' => $itemList,'banquets' => $banquets, 'banquet_menu' => $banquet_menu, 'banquet_accessories' => $banquet_accessories],200);
    }

    public function update(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            'eventDate' => 'required',
            'eventType' => 'required',
            'startTime' => 'required',
            'client' => 'required',
            'guestCount' => 'required | numeric',
            'phone' => 'required',
            'grand_total' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['error_validation'=> $validator->errors()->all(),],422);
        }

        DB::beginTransaction();
        try{
            $booking = BanquetBooking::where('id',$request->id)->update([
               'event_date' => date('Y-m-d',strtotime($request->eventDate)), 
               'event_end_date' => date('Y-m-d',strtotime($request->eventEndDate)), 
               'event_id' => $request->eventType, 
               'event_name' => $request->eventTypeName, 
               'address' => $request->address, 
               'start_time' => $request->startTime, 
               'end_time' => $request->endTime, 
               'client_name' => $request->client,
               'company_name' => $request->company, 
               'company_gst' => $request->company_gst, 
               'company_address' => $request->company_address, 
               'expected_guest_count' => $request->guestCount, 
               'contact_no' => $request->phone, 
               'hall_charge' => $request->hall_charge, 
               'discount' => $request->hall_discount, 
               'discount_amount' => $request->hall_total, 
               'complimentary_room' => $request->complimentary_room, 
               'extra_room' => $request->hall_extra_room, 
               'per_room_capacity' => $request->hall_per_room_capacity, 
               'per_room_charge' => $request->hall_per_room_charge, 
               'food_consumption_type' => $request->banquet_plate_price, 
               'total_hall_charge' => $request->grand_total_hall_charge, 
               'total_food_charge' => $request->total_food_charge, 
               'total_accesories_charge' => $request->consumable_charge, 
               'extra_room_charge' => $request->total_extra_room_charge, 
               'sub_total' => $request->sub_total_amount, 
               'total_discount' => $request->discount, 
               'total_discount_amount' => $request->after_discount, 
               'total_amount' => $request->total_amount, 
               'gst' => $request->gst, 
               'gst_amount' => $request->after_gst, 
               'grand_total' => $request->grand_total, 
               'advance_paid' => $request->advance_paid, 
               'due' => $request->due_total, 
               'note' => $request->note, 
               'payment_mode' => $request->payment_mode, 
               'reference_number' => $request->reference, 
               'adjustment' => $request->adjustment,
            ]);
            
            if(isset($request->selectedHalls)){
                foreach($request->selectedHalls as $hall){
                    $booking = BanquetBooking::where('id',$request->id)->update([
                        'hall_id' => $hall['id'],
                        'hall_name' => $hall['name'],
                        'hall_capacity' => $hall['capacity'],
                        'hall_setup_time' => $hall['setup_time'],
                        'hall_rate' => $hall['rate']
                    ]);
                }
            }
           
            if($booking){
                $del_menu = BanquetMenuItem::where('booking_id',$request->id)->delete();
                $del_access = BanquetAccesories::where('booking_id',$request->id)->delete();

                if(isset($request->itemAdded)){
                    foreach($request->itemAdded as $item){
                        $menu_item = new BanquetMenuItem();
                        $menu_item->booking_id = $request->id;
                        $menu_item->menu_category_id = $item['category_id'];
                        $menu_item->menu_category_name = $item['category_name'];
                        $menu_item->serve_time = $item['time'];
                        $menu_item->item_id = $item['id'];
                        $menu_item->item_name = $item['name'];
                        $menu_item->save();
                    }
                }

                if(isset($request->selectedAccessories)){
                    foreach($request->selectedAccessories as $key => $accessories){
                        $access = new BanquetAccesories();
                        $access->booking_id =  $request->id;
                        $access->accesories_id = $accessories['id'];
                        $access->accesories_name = $accessories['name'];
                        $access->accesories_rate = $accessories['rate'];
                        $access->accesories_qty = $accessories['qty'];;
                        $access->accesories_amount = $accessories['total'];
                        $access->save();
                    }
                }

                if(isset($request->selectedHalls)){
                    foreach($request->selectedHalls as $hall){
                        $update_hall = Hall::where('id',$hall['id'])->update([
                            'booked_date' => date('Y-m-d',strtotime($request->eventDate)),
                            'booking_id' => $request->id,
                        ]);
                    }
                }
            }
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully'], 200);
        } catch (\Exception $e) {
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }

    public function draftToBooking(Request $request){
        
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'image' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        DB::beginTransaction();
        try {

            $imagedata = $request->file('image');
            if ($imagedata) {
                $imageName = time() . '.' . $imagedata->getClientOriginalExtension();
                $destinationPath = public_path('/backend/uploads/banquet');
                $imagedata->move($destinationPath, $imageName);

                $upload = BanquetBooking::where('id',$request->id)->update([
                    'document' => $imageName,
                    'status' => 1
                ]);
            }

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Convert To Booking Successfully'], 200);

        } catch (\Exception $e) {

            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }
}
