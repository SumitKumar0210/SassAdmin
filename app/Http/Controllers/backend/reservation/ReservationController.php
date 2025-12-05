<?php

namespace App\Http\Controllers\backend\reservation;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\CloserReason;
use App\Models\Kot;
use App\Models\Reservation;
use App\Models\ReservationPayment;
use App\Models\ReservationRoom;
use App\Models\RoomCategory;
use App\Models\AdvanceAmount;
use App\Models\Customer;
use App\Models\RoomClosure;
use App\Models\RoomGuest;
use App\Models\RoomNumber;
use App\Models\RoomType;
use App\Models\RoomTypeName;
use App\Models\ReservationRoomTariffLog;
use App\Models\Tariff;
use App\Models\Company;
use App\Models\State;
use App\Models\PaymentMethod;
use App\Models\HotlrConfiguration;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ImageCompressor;

class ReservationController extends Controller
{
    public function index(Request $request){
        // code approved
        $getResViewCount = $request->session()->get('reservaionViewCount',7); // Default to 7 if not set
        $roomNumber = RoomNumber::get();
        $roomtype = RoomType::get();
        $closerReasons = CloserReason::get(['id','name']);
        $roomCategoryNumber = [];
        $roomTypeDetail = [];
        
        $room_types = RoomType::where('status',1)->get(['id','room_category']);
        foreach($room_types as $type){
            $rooms = [];
            $room_numbers = RoomNumber::where('category_id',$type->id)->where('status','active')->get();
            foreach($room_numbers as $number){
                $rooms[] = [
                    'id' => $number->id,
                    'room_number' => $number->room_number,
                    'current_status' => $number->current_status,
                ];
            }
            
            if(count($rooms) > 0){
                $data = [
                'id'=> $type['id'],
                'name'=>$type['room_category'],
                'rooms'=>$rooms
                ];
                array_push($roomCategoryNumber,$data);
            }
        }
        
        $startDate = now()->startOfDay();
        $dates = collect();
    
        for ($i = 0; $i < 10; $i++) {
            $dates->push($startDate->copy()->addDays($i));
        }

        $states = State::get(['gst_code','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $payments = PaymentMethod::where('status',1)->get(['id','name']);
        return view('backend.modules.reservation.reservation',compact('getResViewCount','roomNumber','dates','closerReasons','roomCategoryNumber','states','hotlr','payments'));
    }

    public function index2(Request $request){
        $getResViewCount = $request->session()->get('reservaionViewCount',7); // Default to 7 if not set
        $roomNumber = RoomNumber::get();
        $roomcategory = RoomCategory::get();
        $roomtypename = RoomTypeName::get();
        $startDate = now()->startOfDay();
        $dates = collect();
    
        for ($i = 0; $i < 10; $i++) {
            $dates->push($startDate->copy()->addDays($i));
        }
        return view('backend.modules.reservation.reservation_new',compact('getResViewCount','roomNumber','dates','roomcategory','roomtypename'));
    }

    public function add_reservation(Request $request){ 
       
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'checkin_resvn' => ['required'],
                'checkout_resvn' => ['required'],
                'roomtype_resvn' => ['required', 'array'],
                'adults_resvn' => ['required', 'array'],
                'amount_resvn' => ['required', 'array'],
                'first_name_resvn' => ['required'],
                'mobile_resvn' => ['required'],
                'room_total_amount' => ['nullable'],
                'no_of_nights' => ['nullable'],
                'total_final_res_amount' => ['nullable'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        
        DB::beginTransaction();
        
        try {

            $filename = '';
            if ($request->hasFile('photo_resvn')) {

                $image = $request->file('photo_resvn');
                $folder = public_path('backend/uploads/reservation/');
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $filename = time() . '.jpg';
                $destination = $folder . $filename;

                ImageCompressor::resizeAndCompress(
                    $image->getPathname(),
                    $destination,
                    1024,   // max width
                    150     // target size (KB)
                );
            }
            $date = date('y-m-d'); // current date yy-mm-dd
            $month = date('m', strtotime($date));
            $year = date('y', strtotime($date));
            $res_rand = random_int(100000, 999999);
            $reservation_id = "RES".$month.$year.$res_rand;
            $primary_name = $request->first_name_resvn.' '.$request->last_name_resvn;
        
            $company_gst = '';
            $company_name = '';
            $company_addr = '';
            $company_pincode = '';
            $company_state = '';
            if($request->billtype == 'b2c'){
                $company_name = $request->companyname_resvn;
                $company_addr = $request->companyaddress_resvn;
                $company_pincode = $request->companypincode_resvn;
                $company_state = $request->companystate_resvn;
            }else if($request->billtype == 'b2b'){
                $company_gst = $request->companygst_resvn;
                $company_name = $request->gstTradeName;
                $company_addr = $request->gstAddr;
                $company_pincode = $request->gstAddrPncd;
                $state = State::where('gst_code',$request->gstStateCode).value('name');
                $company_state = $state;
            }

            $guest_id = '';
            $chk_customer = Customer::where('mobile',$request->mobile_resvn)->count();
            if($chk_customer > 0){

                $customers = Customer::where('mobile',$request->mobile_resvn)->value('id');
                $guest_id = $customers;

            }else{

                $registration_customer = new Customer();
                $registration_customer->guest_id = time();
                $registration_customer->first_name = $request->first_name_resvn;
                $registration_customer->last_name = $request->last_name_resvn;
                $registration_customer->email = $request->email_resvn;
                $registration_customer->mobile = $request->mobile_resvn;
                $registration_customer->gender = $request->gender_resvn;
                $registration_customer->allergic_to = $request->allergic_to_resvn;
                $registration_customer->address = $request->address_resvn;
                $registration_customer->city = $request->city_resvn;
                $registration_customer->state = $request->state_resvn;
                $registration_customer->country = $request->country_resvn;
                $registration_customer->pincode = $request->pin_resvn;
                $registration_customer->company_name = $company_name;
                $registration_customer->gst_number = $company_gst;
                $registration_customer->company_address = $company_addr;
                $registration_customer->company_pincode = $company_pincode;
                $registration_customer->company_state = $company_state;
                $registration_customer->id_proof = $request->idnumber_resvn;
                $registration_customer->proof_type = $request->documenttype_resvn;
                $registration_customer->remember_token = md5(time());
                $registration_customer->note = $request->comments_resvn;
                if ($request->hasFile('photo_resvn')) {
                    $registration_customer->proof = $filename;
                }
                $registration_customer->save();
                
                $guest_id = $registration_customer->id;

            }

            $company_id = '';
            if($company_gst != ''){

                $chk_company = Company::where('Gstin',$company_gst)->count();
                if($chk_company > 0){
    
                    $companies = Company::where('Gstin',$company_gst)->value('id');
                    $company_id = $companies;
                    
                }else{
    
                    $company = new Company();
                    $company->name = $company_name;
                    $company->mobile = $request->mobile_resvn;
                    $company->email = $request->email_resvn;
                    $company->Gstin = $company_gst;
                    $company->address = $company_addr;
                    $company->addrBnm = $request->gstAddrBnm;
                    $company->addrBno = $request->gstAddrBno;
                    $company->addrFlno = $request->gstAddrFlno;
                    $company->addrLoc = $request->gstAddrLoc;
                    $company->addrPncd = $company_pincode;
                    $company->addrSt = $request->gstAddrSt;
                    $company->BlkStatus = $request->gstBlkStatus;
                    $company->DtDReg = $request->gstDtDReg;
                    $company->DtReg = $request->gstDtReg;
                    $company->LegalName = $request->gstLegalName;
                    $company->StateCode = $company_state;
                    $company->TradeName = $request->gstTradeName;
                    $company->TxpType = $request->gstTxpType;
                    $company->gstStatus = $request->gstStatus;
                    $company->state = $request->state;
                    $company->save();

                    $company_id = $company->id;
                }
            }

            $reservation = new Reservation();
            $reservation->reservation_id = $reservation_id;
            $reservation->first_name = $request->first_name_resvn;
            $reservation->last_name = $request->last_name_resvn;
            $reservation->mobile = $request->mobile_resvn;
            $reservation->email = $request->email_resvn;
            $reservation->gender = $request->gender_resvn;
            $reservation->address = $request->address_resvn;
            $reservation->city = $request->city_resvn;
            $reservation->state = $request->state_resvn;
            $reservation->pincode = $request->pin_resvn;
            $reservation->country = $request->country_resvn;
            $reservation->guest_type = $request->guest_type_resvn;
            $reservation->allergic_to = $request->allergic_to_resvn;
            $reservation->document_type = $request->documenttype_resvn;
            $reservation->other_document_type = $request->otherdetail_resvn;
            $reservation->id_number = $request->idnumber_resvn;
            $reservation->coming_from = $request->coming_from_resvn;
            $reservation->going_to = $request->going_to_resvn;
            $reservation->purpose_for_visit = $request->purpose_of_visit_resvn;
            $reservation->arrival_date = date('Y-m-d',strtotime($request->checkin_resvn));
            $reservation->arrival_time = $request->arrivaltime_resvn;
            $reservation->advance_amount = $request->total_advance_amount;
            $reservation->no_of_days = $request->no_of_nights;
            $reservation->total_amount = $request->room_total_amount;
            $reservation->discount = $request->total_discount_percentage;
            $reservation->discount_amount = $request->total_subtotal;
            $reservation->after_tax = $request->total_subtotal;
            $reservation->grand_total = $request->total_subtotal;
            $reservation->paid_amount = $request->total_advance_amount;
            $reservation->guest_comment = $request->comments_resvn;
            $reservation->note = $request->note_resvn;
            $reservation->guest_id = $guest_id;
            $reservation->company_id = $company_id;
            $reservation->company_name = $company_name;
            $reservation->company_gst = $company_gst;
            $reservation->company_address = $company_addr;
            $reservation->created_by = Auth::user()->id;
            if ($request->hasFile('photo_resvn')) {
                $reservation->id_proof = $filename;
            }
            if($reservation->save()){

                if($request->total_advance_amount > 0){

                    $reservation_amount = new AdvanceAmount();
                    $reservation_amount->reservation_id = $reservation_id;
                    $reservation_amount->amount = $request->total_advance_amount;
                    $reservation_amount->type = 'Reservation';
                    $reservation_amount->save();
                }

                $activity_log = new ActivityLog();
                $activity_log->reservation_id = $reservation_id;
                $activity_log->room_id = NULL;
                $activity_log->activity = 'New Reservation Done';
                $activity_log->activity_by = Auth::user()->id;
                $activity_log->save();

                $room_type[] = $request->roomtype_resvn;
                $roomnumber[] = $request->roomno_resvn;
                $tariff_value[] = $request->roomtariff_resvn;
                $adults[] = $request->adults_resvn;
                $childrens[] = $request->childrens_resvn;
                $infants[] = $request->infants_resvn;
                $amount[] = $request->amount_resvn;
                $extra_person[] = $request->extraperson_resvn;
                $extra_person_amount[] = $request->extrapersonAmount_resvn;
                
                for ($z = 0; $z < count($room_type); $z++) {
                    for ($i = 0; $i < count($room_type[$z]); $i++) {

                        $reservation_rooms = new ReservationRoom();
                        $reservation_rooms->reservation_id = $reservation_id;
                        $reservation_rooms->primary_name = $primary_name;
                        if($roomnumber[$z][$i] === 'NA'){
                            $reservation_rooms->status = 'Reserved';
                            $reservation_rooms->room_alloted = 'NA';
                        }else{

                            $room_numbers = RoomNumber::where('id',$roomnumber[$z][$i])->value('room_number');
                            $reservation_rooms->status = 'Alloted';
                            $reservation_rooms->room_alloted = $room_numbers;
                            $reservation_rooms->room_alloted_id = $roomnumber[$z][$i];
                            $reservation_rooms->dragged_row = 'direct';
                            $reservation_rooms->dropped_row = $roomnumber[$z][$i];
                            $reservation_rooms->checkedin_at = now();


                        }
                        $reservation_rooms->checkin = date('Y-m-d',strtotime($request->checkin_resvn));
                        $reservation_rooms->checkout = date('Y-m-d',strtotime($request->checkout_resvn));
                        $reservation_rooms->daystay = $request->no_of_nights;
                        $reservation_rooms->room_category_id = $room_type[$z][$i];
                        $reservation_rooms->tariff_id = $tariff_value[$z][$i];
                        $reservation_rooms->adults = $adults[$z][$i];
                        $reservation_rooms->childrens = $childrens[$z][$i];
                        $reservation_rooms->infants = $infants[$z][$i];
                        $reservation_rooms->amount = $amount[$z][$i];
                        $reservation_rooms->extra_person = $extra_person[$z][$i] ?? 0;
                        $reservation_rooms->extra_person_amount = $extra_person_amount[$z][$i] ?? 0;
                        $reservation_rooms->save();

                        if($roomnumber[$z][$i] != 'NA'){

                            $update_rooms = RoomNumber::where('id',$roomnumber[$z][$i])->update([
                                'current_status' => '0'
                            ]);

                            $room_numbers = RoomNumber::where('id',$roomnumber[$z][$i])->value('room_number');
                            $tariff = Tariff::where('id',$tariff_value[$z][$i])->value('tariff_type');

                            $reservation_room_tariff = new ReservationRoomTariffLog();
                            $reservation_room_tariff->date = date('Y-m-d H:i:s');
                            $reservation_room_tariff->reservation_id = $reservation->id;
                            $reservation_room_tariff->reservation =  $reservation_id;
                            $reservation_room_tariff->reservation_room_id = $reservation_rooms->id;
                            $reservation_room_tariff->room_type_id =  $room_type[$z][$i];
                            $reservation_room_tariff->tariff_id = $tariff_value[$z][$i];
                            $reservation_room_tariff->tariff = $tariff;
                            $reservation_room_tariff->room_id = $roomnumber[$z][$i];
                            $reservation_room_tariff->room = $room_numbers;
                            $reservation_room_tariff->adults = $adults[$z][$i];
                            $reservation_room_tariff->childrens = $childrens[$z][$i];
                            $reservation_room_tariff->infants = $infants[$z][$i];
                            $reservation_room_tariff->amount = $amount[$z][$i];
                            $reservation_room_tariff->extra_pax = $extra_person[$z][$i] ?? 0;
                            $reservation_room_tariff->extra_pax_amount = $extra_person_amount[$z][$i] ?? 0;
                            $reservation_room_tariff->save();                            
                        }
                    }
                }
            }
            
            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Data added successfully','reservation_id'=>$reservation_id,'primary_name'=>$primary_name], 200);

        } catch (\Exception $e) {
         
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }

        dd($request->all());
    }

    public function reservationCountView(Request $request){
        $reservationViewCount = $request->days;
        $request->session()->put('reservaionViewCount', $reservationViewCount);
    }

    public function reservationdata(Request $request){
        // start code before night audit
        $reservationRoom = ReservationRoom::where('status','Reserved')->where('checkin','<',date('Y-m-d'))->update([
            'status' => 'Cancel'
        ]);
        // end
        $today = date('Y-m-d');
        $roomType = RoomType::get();
        $roomnumber = RoomNumber::get();
        $roomCategoryNum = [];
        foreach($roomType as $roomCate){
            $rooms = [];
            // $room_types = RoomType::where('room_category_id',$roomCate['id'])->get(['id']);
            // foreach($room_types as $type){
            //     $room_numbers = RoomNumber::where('room_specification_id',$type->id)->where('status','active')->get();
            //     foreach($room_numbers as $number){
            //         $rooms[] = [
            //             'id' => $number->id,
            //             'room_number' => $number->room_number,
            //             'current_status' => $number->current_status,
            //         ];
            //     }
            // }
            $room_numbers = RoomNumber::where('category_id',$roomCate['id'])->where('status','active')->get();
            foreach($room_numbers as $number){
                $rooms[] = [
                    'id' => $number->id,
                    'room_number' => $number->room_number,
                    'current_status' => $number->current_status,
                ];
            }
            if(count($rooms) > 0){
               $data = [
                'id'=> $roomCate['id'],
                'name'=>$roomCate['room_category'],
                'max_occupancy'=>$roomCate['max_occupancy'],
                'max_adult'=>$roomCate['max_adult'],
                'max_child'=>$roomCate['max_child'],
                'max_infant'=>$roomCate['max_infant'],
                'rooms'=>$rooms
               ];
                array_push($roomCategoryNum,$data);
            }
        }
       
        $decrement = $request->y;
        $totaldays = $request->days;
        $currdates = '';
        $currdatesData = $request->refdate;
        $dateCollect = [];
        $area = $request->session()->get('reservaionViewCount');
        if($area == null){
            $area = 7;
        }
        $getResViewCount = $request->session()->get('reservaionViewCount') + $totaldays;
        $dates = [];
        
        if($totaldays > 0){
            if($totaldays != 99){
                if ($decrement == 0) {
                    $mydates = date('Y-m-d', strtotime(' +'.$totaldays.' day', strtotime($currdatesData)));
                }else if($decrement == 2) {
                    $mydates = date('Y-m-d');
                }else{
                    $mydates = date('Y-m-d', strtotime(' -'.$totaldays.' day', strtotime($currdatesData)));
                }
            }else{
                $mydates = date('Y-m-d',strtotime($currdatesData));
            }
        }else{
            $mydates = date('Y-m-d');
        }

        $setdate = $mydates;
        for($i=0; $i< $area; $i++){
            $currentDate = date('Y-m-d', strtotime(' +'.$i.' day', strtotime($setdate)));
            array_push($dateCollect,$currentDate);
        }

        foreach($dateCollect as $date){
            $dateView = [
                'full_date' => $date,
                'date' => date('d',strtotime($date)),
                'month' => date('M',strtotime($date)),
                'day' => date('D',strtotime($date)),
                'today' => date('Y-m-d')
            ];
            array_push($dates,$dateView);
            //reservation Detail according to date
        }

        $totalDate = count($dates)-1;
        //below roomEachDetails used for row view reservation data display
        $reservationRoomDetail = [];
       // $reservation_query = ReservationRoom::whereBetween('checkin',[$dates[0]['full_date'],$dates[$totalDate]['full_date']])->orWhereBetween('checkout',[$dates[0]['full_date'],$dates[$totalDate]['full_date']])->get(['id','checkin','checkout','room_type','room_category_id','status','dropped_row','dropped_checkin_date','reservation_id','primary_name','amount','extra_person','extra_person_amount','room_alloted']);
        $reservation_query = ReservationRoom::whereNull('checkedout_at')->get(['id','checkin','checkout','room_type','room_category_id','status','dropped_row','dropped_checkin_date','reservation_id','primary_name','amount','extra_person','extra_person_amount','room_alloted','checkedin_at','room_alloted_id','adults','childrens','infants']);
        foreach($reservation_query as $reserve){

            $reservations = Reservation::where('reservation_id',$reserve->reservation_id)->get();

            $total_cost = 0;
            $date1 = date_create($reserve->checkin);
            $date2 = date_create($reserve->checkout);
            $checkin = $reserve->checkin;
            $checkout = $reserve->checkout;
            if($reserve->status == 'Alloted'){

                $date1 = date_create($reserve->checkedin_at);
                $checkin = date('Y-m-d',strtotime($reserve->checkedin_at));
                if($reserve->checkout < $today){
                    $checkout = $today;
                    $date2 = date_create($today);
                }
            }
            
            $diff = date_diff($date1,$date2);
            $no_of_nights = $diff->days;
            $count_guest = RoomGuest::where('reservation_id',$reserve->reservation_id)->count();
            $paid_amount = ReservationPayment::where('reservation_id',$reserve->reservation_id)->sum('amount_paid');
            $total_amount =  ($no_of_nights * $reserve->amount) + ($no_of_nights * $reserve->extra_person * $reserve->extra_person_amount);
            $total_cost = $total_amount - $paid_amount;

            $reservationRoomDetail[] =[
                'id' => $reserve->id,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'room_type' => $reserve->room_type,
                'room_category_id' => $reserve->room_category_id,
                'status' => $reserve->status,
                'dropped_row' => $reserve->dropped_row,
                'dropped_checkin_date' => $reserve->dropped_checkin_date,
                'reservation_id' => $reserve->reservation_id,
                'primary_name' => $reserve->primary_name,
                'reservation_detail'  =>  $reserve->reservation_data,
                'guest' => $count_guest,
                'stay' => $no_of_nights,
                'total' => $total_amount,
                'outstanding' => $total_cost,
                'roomData' => $reserve->roomData,
                
                'room_id' => $reserve->room_alloted_id,
                'id' => $reservations[0]->id,
                'reservation_room_id' =>  $reserve->id,
                'reservation_id' => $reserve->reservation_id,
                'first_name' => $reservations[0]->first_name,
                'last_name' => $reservations[0]->last_name,
                'mobile' => $reservations[0]->mobile,
                'email' => $reservations[0]->email,
                'guest_type' =>  $reservations[0]->guest_type,
                'adults' =>  $reserve->adults,
                'extra_person' =>  $reserve->extra_person,
                'reservation_checkin_date' => date('d-m-Y',strtotime($reserve->checkin)),
                'reservation_checkin_time' => date('h:i A', strtotime($reserve->checkedin_at)),
                'stay' => $reserve->daystay,
                'status' => $reserve->status,
                'room_alloted' => $reserve->room_alloted,
                'grand_total' => $reservations[0]->grand_total,
                'due' => $reservations[0]->grand_total - $reservations[0]->paid_amount,
            ];

        }
        $roomEachDetails = [];
        $statusNameColor = [];
        foreach ($roomnumber as $rnum) {
            $roomnumberDetail = [];
            
            $rooms = ReservationRoom::whereNotIn('status',['Reserved','Final','Cancel'])->whereNull('checkedout_at')->get();
            if($rooms->isNotEmpty()) {
                $firstdate = $rooms[0]->checkin;
                $lastdate = $rooms[0]->checkout;
        
                // Generate dates range
                $currentDate = $firstdate;
                while ($currentDate <= $lastdate) {
                    $roomnumberDetail[] = $currentDate; // Avoids duplicate check with in_array
                    $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
                }
            }
            //array push
            $closer_name = '';
            $closer_color = '';
            if($rnum->current_status == 0){
                $closer_name = 'Occupied';
                $closer_color = '#feb858';
            }else if($rnum->current_status > 0){
                $closer_reasons = CloserReason::where('id',$rnum->current_status)->get(['name','color']);
                $closer_name = $closer_reasons[0]->name;
                $closer_color = $closer_reasons[0]->color;
                $roomnumberDetail = [];
                foreach($dateCollect as $date){
                    $roomnumberDetail[] = $date;
                }
            }else{
                $closer_name = 'Vacant';
                $closer_color = '#9560DD';
            }

            $roomEachDetails[] = [
                'room_id' => $rnum->id,
                'room_number' => $rnum->room_number,
                'room_status' => $rnum->current_status,
                'room_dates' => $roomnumberDetail,
                'closer_name' => $closer_name,
                'closer_color' => $closer_color,
                'closer_name_vacant' => 'Vacant',
                'closer_color_vacant' => '#9560DD',
            ];
            
            if (array_search($closer_name, array_column($statusNameColor, 'name')) === FALSE) {
                $statusNameColor[] = [
                    'id' => $rnum->current_status,
                    'name' => $closer_name,
                    'color' => $closer_color,
                ];
            } 
        }

        $roomDetails = [];
        // foreach($roomType as $roomCate){
        //     $roomtypes = RoomType::where('room_category_id',$roomCate['id'])->get(['id','roomtype_name_id']);
        //     $types = [];
            
        // }
        // foreach($roomType as $type){
        //     $roomAvailable = [];
        //     $roomNumbers = RoomNumber::where('category_id',$type['id'])->where('status','active')->where('current_status','-1')->get(['category_id','id','room_number','current_status']);
        //     $roomtypesData = RoomType::where('id',$type['id'])->get();
        //     if(count($roomNumbers) > 0){
        //         $roomtypename = RoomTypeName::where('id',$type['roomtype_name_id'])->where('status','active')->get(['id','room_name']);
        //         $types[] = [
        //             'id'=> $roomtypename[0]->id,
        //             'name'=>$roomtypename[0]->room_name,
        //             'roomNumbers' => $roomNumbers,
        //             'type_detail' => $roomtypesData,
        //         ];
        //     }
        // }
        // if(count($types) > 0){
        //     $data = [
        //         'id'=> $roomCate['id'],
        //         'name'=>$roomCate['room_category'],
        //         'types' => $types
        //     ];
        //     array_push($roomDetails,$data);
        // }


        $tariffs = Tariff::where('status','active')->get(['id','room_category_id','tariff_type','room_tariff','extra_person_tariff']);

        return response()->json([
            'success' => 'Data added successfully',
            // 'dateCollect' => $dateCollect,
            'dates' => $dates,
            'currdates' => $currdates,
            'currrDisplay' => date('d-m-Y',strtotime($mydates)),
            'reservation' => $reservationRoomDetail,
            'reservedRoom' => $reservation_query,
            'getResViewCount' => $getResViewCount,
            'roomCategoryNum'=>$roomCategoryNum,
            // 'roomcategory'=>$roomCategory,
            'roomnumber'=>$roomnumber,
            // 'roomnumberDetail'=>$roomnumberDetail,
            'roomeachDetail'=>$roomEachDetails,
            'statusNameColor' => $statusNameColor,
            'roomDetails' => $roomDetails,
            'tariffs' => $tariffs
        ], 200);
    }

    public function add_roomClosure(Request $request){  
        $roomnumber = $request->room_num;
        $startdate = date('y-m-d',strtotime($request->start_date));
        $reason_closure = $request->reason_closure;
        
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'room_num' => ['required'],
                'start_date' => ['required'],
                'reason_closure' => ['required'],
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'error_validation' => $validator->errors()->all()
                ], 200);
            }
        }
        
        $check_reservation = ReservationRoom::where('checkin',$request->start_date)->pluck('id');
        if(sizeof($check_reservation) > 0){
            $update_room = ReservationRoom::where('id',$check_reservation[0])->update([
                'status' => 'Reserved'
            ]);
        }

        $roomclosure = new RoomClosure();
        $roomclosure->room_number = $roomnumber;
        $roomclosure->status = 'Closed';
        $roomclosure->start_date = $startdate;
        $roomclosure->reason_closure = $reason_closure;
        $roomclosure->desc = $request->desc;
        
        if($roomclosure->save()){
            //update room status 
            RoomNumber::where('id',$roomnumber)->update([
                'current_status'  =>$reason_closure,
            ]);
            return response()->json(['success'=>'Room Closure Submitted Successfully'], 200);
        } else {
            return response()->json(['error_success'=>'Data not inserted'], 500);
        }
    }

    public function getReservationDetails(Request $request){
        $resid = $request->reservationid;
        $resrvationdetails = Reservation::where('reservation_id',$resid)->get();
        $resrvationPayments = ReservationPayment::where('reservation_id',$resid)->get();
        $resrvationroom = ReservationRoom::where('reservation_id',$resid)->get();
        return response()->json(['success'=>'Reservation Details Found','reservationDetails'=>$resrvationdetails,'resrvationPayments'=>$resrvationPayments,'resrvationroom'=>$resrvationroom],200);
    }

    public function getReservation_Details(Request $request){
        $resid = $request->reservationid;
        $resrvationdetails = Reservation::where('reservation_id',$resid)->get();
        $resrvationPayments = ReservationPayment::where('reservation_id',$resid)->get();
        $resrvationroom = ReservationRoom::where('reservation_id',$resid)->get();
        return response()->json(['success'=>'Reservation Details Found','reservation_Details'=>$resrvationdetails,'resrvationPayments'=>$resrvationPayments,'resrvationroom'=>$resrvationroom],200);
    }

    public function getRservationRoomDatas(Request $request){
        $id = $request->id;
        $reservationroomData = ReservationRoom::where('id',$id)->get();
        return response()->json(['success'=>'Reservation Room Details Found','reservationroomDatas'=>$reservationroomData],200);
    }

    public function getRservationData(Request $request){
        $id = $request->id;
        $reservationroomData = ReservationRoom::where('id',$id)->get();
        $resid = $reservationroomData[0]->reservation_id;
        $reservationData = Reservation::where('reservation_id',$resid)->get();
        return response()->json(['success'=>'Reservation Room Details Found','reservationroomData'=>$reservationroomData,'reservationData'=>$reservationData],200);
    }

    public function getRservationRoomDetails(Request $request){
        
        $id = $request->id;
        $dropped_roomnumber = $request->room;
        $dropped_roomnumber_index = $request->drop;
        $refdate = $request->refdate;
        $dateCollect = [];

        for($i=0; $i< $request->number_of_days; $i++){
            $currentDate = date('Y-m-d', strtotime(' +'.$i.' day', strtotime($refdate)));
            array_push($dateCollect,$currentDate);
        }

        $get_dropped_date = $dateCollect[$dropped_roomnumber_index];
        $reservationroomData = ReservationRoom::where('id',$id)->get();
        $start_date = $reservationroomData[0]->checkin;
        $end_date = $reservationroomData[0]->checkout;

        $date1 = date_create($start_date);
        $date2 = date_create($end_date);
        $diff = date_diff($date1,$date2);
        $no_of_nights = $diff->days - 1;
        $endDate = date('Y-m-d', strtotime(' +'.$no_of_nights.' day', strtotime($get_dropped_date)));
        $draggedRoomCategory = [];
        $draggedRoomCategories = RoomNumber::where('id', $request->draggedRoom)->get(['category_id','room_number']);
        foreach($draggedRoomCategories as $drag){
           $draggedRoomCategory = [
            'room_category' => $drag->roomCategoryDetail->room_category,
            'category_id' => $drag->category_id,
            'room_number' => $drag->room_number,
           ];
        }
        $droppedRoomCategories = RoomNumber::where('id', $request->room)->get(['category_id','room_number']);
        foreach($droppedRoomCategories as $drop){
           $droppedRoomCategory = [
            'room_category' => $drop->roomCategoryDetail->room_category,
            'category_id' => $drop->category_id,
            'room_number' => $drop->room_number,
           ];
        }
        
        $reservationroomDataChk = ReservationRoom::whereBetween('checkin',[$get_dropped_date,$endDate])->where('room_alloted_id',$dropped_roomnumber)->count();
        if($reservationroomDataChk > 0){
            return response()->json(['error' => 'Date Already in use'], 200);
        }else{
            $reservedDate = RoomNumber::where('id',$dropped_roomnumber)->where('current_status','-1')->count();
            if($reservedDate > 0){
                return response()->json(['success'=>'Reservation Room Details Found','reservationroomData'=>$reservationroomData,'checkin' => date('d-M-Y',strtotime($start_date)),'checkout' => date('d-M-Y',strtotime($end_date)),'draggedCategory'=>$draggedRoomCategory,'droppedCategory'=>$droppedRoomCategory],200);
            }else{
                return response()->json(['error' => 'Date Already in use'], 200);
            }
        }
    }

    public function getRservationandRoomDetails(Request $request){
        $resid = $request->id;
        $reservation_id = $request->reservationid;
        $checkin_date = '';
        $checkin_at = '';
        $checkout_date = '';
        $checkin = '';
        $checkout = '';
        $payment_log = [];
        //$resrvationroomdetails = ReservationRoom::where('id',$resid)->get();
        $reservationroomAll = ReservationRoom::where('reservation_id',$reservation_id)->where('status','!=','Cancel')->get();
        $resrvationdetails = Reservation::where('reservation_id',$reservation_id)->get();
        $guest_count = RoomGuest::where('reservation_id',$reservation_id)->where('room_id',$resid)->count();
        $resrvationpaymentdetails = ReservationPayment::where('reservation_room_id',$resid)->where('status',1)->where('reservation_id',$reservation_id)->get();
        foreach($resrvationpaymentdetails as $detail){
            $payment_log[] = [
                'id' => $detail['id'],
                'reservation_id' => $detail['reservation_id'],
                'amount' => $detail['amount_paid'],
                'date' => date('d-m-Y',strtotime($detail['payment_date'])),
                'mode' => $detail['payment_type'],
                'recorded_by' => $detail->payment_recorded_by->name
            ];
        }
        $guestRoom = [];
        // $resRoomGuest = RoomGuest::where('reservation_id',$reservation_id)->get();
        $disRoom = RoomGuest::where('reservation_id',$reservation_id)->distinct()->get(['room_id']);
        foreach($disRoom as $room){
            $resRoomGuest = RoomGuest::where('reservation_id',$reservation_id)->where('room_id',$room['room_id'])->get();
            $roomID = $room['room_id'];
            $roomData = ReservationRoom::where('id',$roomID)->get(['room_alloted','room_type']);
            $data = [
                'guests' => $resRoomGuest,
                'room' => $room['room_id'],
                'guest_id' => rand(),
                'room_num' => $roomData[0]->room_alloted ?? '',
                'room_type' => $roomData[0]->room_type ?? '',
            ];
            array_push($guestRoom,$data);
        }
        
        $reservationTariffHistory = [];
        foreach($reservationroomAll as $reservation){
            if($reservation['id'] == $request->id){
                $checkin_date = date('d-M-Y',strtotime($reservation['checkin']));
                $checkout_date = date('d-M-Y',strtotime($reservation['checkout']));
                $checkin_at = $reservation['checkedin_at'];
            }

            $reservationroomtariffs = ReservationRoomTariffLog::where('reservation',$reservation_id)->where('reservation_room_id',$reservation['id'])->get();
            foreach($reservationroomtariffs as $log){
                $current_status = 'Active';
                if($log->end_date == null){
                    $date = Carbon::now();
                    $days = $this->daysCalculate($log->date,$date,1);
                }else{
                    $current_status = 'In-Active';
                    $days = $this->daysCalculate($log->date,$log->end_date,1);
                }

                $total_amount = $days * (($log->amount) + ($log->extra_pax * $log->extra_pax_amount));
                $reservationTariffHistory[] = [
                    'id' => $log->id,
                    'reservation_room_id' => $log->reservation_room_id,
                    'room_type_id' => $log->room_type_id,
                    'room' => $log->room,
                    'room_id' => $log->room_id,
                    'tariff' => $log->tariff,
                    'tariff_id' => $log->tariff_id,
                    'adults' => $log->adults,
                    'childrens' => $log->childrens,
                    'infants' => $log->infants,
                    'amount' => $log->amount,
                    'extra_pax' => $log->extra_pax,
                    'extra_pax_amount' => $log->extra_pax_amount,
                    'date' => $log->date,
                    'end_date' => $log->end_date,
                    'day_stay' => $days,
                    'cost_extra_room' => $days * ($log->extra_pax * $log->extra_pax_amount),
                    'cost_room' => $days * $log->amount,
                    'grand_total' => $total_amount,
                    'current_status' => $current_status
                ];
            }
        }

        if($reservation['checkout'] <= date('Y-m-d')){
            $checkout_date = date('Y-m-d'); 
        }else{
            $checkout_date = $reservation['checkout'];
        }

       
        $checkin = date('Y-m-d',strtotime($reservation['checkin']));
        $checkout = date('Y-m-d',strtotime($checkout_date));
        // Kot detail
        $kotList = [];
        $kot_detail = Kot::where('kot_id',$reservation_id)->where('reserve_room_id',$resid)->get(['id','sub_total','total_gst','grand_total','order_time','payment_type']);
        foreach($kot_detail as $detail){
            $kotList[] = [
                'id' => $detail->id,
                'sub_total' => $detail->sub_total,
                'total_gst' => $detail->total_gst,
                'grand_total' => $detail->grand_total,
                'order_time' => date('d-m-Y h:i A',strtotime($detail->order_time)),
                'payment_type' => $detail->payment_type,
            ];
        }

        $logs = [];
        $activity_logs = ActivityLog::where('reservation_id',$reservation_id)->where('room_id',$resid)->get();
        foreach($activity_logs as $activity){
            $logs[] = [
                'id' => $activity->id,
                'activity' => $activity->activity,
                'activity_by' => $activity->activity_by,
                'date' => date('d-m-Y',strtotime($activity->created_at)),
            ];
        }
       
        return response()->json(['success'=>'Reservation And Room Details Found','reservationDetails'=>$resrvationdetails,'resrvationpaymentdetails'=>$payment_log,'reservationroomAll'=>$reservationroomAll,'reservationroomtariffs' => $reservationroomtariffs,'reservationTariffHistory' => $reservationTariffHistory, 'disRoom'=>$disRoom,'guest_count'=>$guest_count,'guestRoom'=>$guestRoom,'checkin_date'=>$checkin_date,'checkout_date'=>$checkout_date,'kot_detail'=>$kotList,'activity_logs' => $logs,'checkin' => $checkin,'checkout' => $checkout,'checkedin_at' => $checkin_at],200);
    }

    // calender View
    public function reservationRoomNumUpdate(Request $request){
        $id = $request->id;
        $reservationid = $request->reservationid;
        $keyDropped = intval($request->keydropped);
        
        $reservationroomData = ReservationRoom::where('id',$id)->get();
        $start_date = $reservationroomData[0]->checkin;
        $end_date = $reservationroomData[0]->checkout;
        $date1 = date_create($start_date);
        $date2 = date_create($end_date);
        $diff = date_diff($date1,$date2);
        $endDate = date('Y-m-d', strtotime(' +'.$diff->days.' day', strtotime($request->dateAtCheckinIndex['full_date'])));
        $roomDetails = RoomNumber::where('id',$request->keydropped)->get();
        if($keyDropped > 0 ){
            
            $res_update = ReservationRoom::where('id', $id)->update([
                'status' => 'Alloted',
                'dragged_row' => $request->keyDragged,
                'dragged_col' => $request->jDragged,
                'room_alloted_id' => $request->keydropped,
                'room_alloted' => $roomDetails[0]->room_number,
                'dropped_row' => $request->keydropped,
                'dropped_col' => $request->jDropped,
                'room_category_id' => $roomDetails[0]->category_id,
                'dropped_checkin_date' => $request->dateAtCheckinIndex['full_date'],
                'checkin' => $request->dateAtCheckinIndex['full_date'],
                'checkout' => $endDate,
                'checkedin_at' => now()
            ]);

            $reservations = Reservation::where('reservation_id',$request->reservationid)->value('id');
            $tariff = Tariff::where('id',$reservationroomData[0]->tariff_id)->value('tariff_type');

            $chk_exits = ReservationRoomTariffLog::where('reservation',$reservationid)->where('reservation_room_id',$id)->where('adults',$reservationroomData[0]->adults)->where('amount',$reservationroomData[0]->amount)->where('extra_pax',$reservationroomData[0]->extra_person)->where('extra_pax_amount',$reservationroomData[0]->extra_person_amount)->whereNull('end_date')->latest('id')->count();
            if($chk_exits == 0){
                
                $update_last = ReservationRoomTariffLog::where('reservation',$reservationid)->where('reservation_room_id',$id)->whereNull('end_date')->update([
                    'end_date' => date('Y-m-d H:i:s')
                ]);

                $reservation_room_tariff = new ReservationRoomTariffLog();
                $reservation_room_tariff->date = date('Y-m-d H:i:s');
                $reservation_room_tariff->reservation_id = $reservations;
                $reservation_room_tariff->reservation = $reservationid;
                $reservation_room_tariff->reservation_room_id = $id;
                $reservation_room_tariff->room_type_id =  $roomDetails[0]->category_id;
                $reservation_room_tariff->tariff_id = $reservationroomData[0]->tariff_id;
                $reservation_room_tariff->tariff = $tariff;
                $reservation_room_tariff->room_id = $request->keydropped;
                $reservation_room_tariff->room = $roomDetails[0]->room_number;
                $reservation_room_tariff->adults = $reservationroomData[0]->adults;
                $reservation_room_tariff->childrens = $reservationroomData[0]->childrens;
                $reservation_room_tariff->infants = $reservationroomData[0]->infants;
                $reservation_room_tariff->amount = $reservationroomData[0]->amount;
                $reservation_room_tariff->extra_pax = $reservationroomData[0]->extra_person ?? 0;
                $reservation_room_tariff->extra_pax_amount = $reservationroomData[0]->extra_person_amount ?? 0;
                $reservation_room_tariff->save();

            }else{
                
                $reservation_room_tariff = new ReservationRoomTariffLog();
                $reservation_room_tariff->date = date('Y-m-d H:i:s');
                $reservation_room_tariff->reservation_id = $reservations;
                $reservation_room_tariff->reservation =  $reservationid;
                $reservation_room_tariff->reservation_room_id = $id;
                $reservation_room_tariff->room_type_id = $roomDetails[0]->category_id;
                $reservation_room_tariff->tariff_id = $reservationroomData[0]->tariff_id;
                $reservation_room_tariff->tariff = $tariff;
                $reservation_room_tariff->room_id = $request->keydropped;
                $reservation_room_tariff->room = $roomDetails[0]->room_number;
                $reservation_room_tariff->adults = $reservationroomData[0]->adults;
                $reservation_room_tariff->childrens = $reservationroomData[0]->childrens;
                $reservation_room_tariff->infants = $reservationroomData[0]->infants;
                $reservation_room_tariff->amount = $reservationroomData[0]->amount;
                $reservation_room_tariff->extra_pax = $reservationroomData[0]->extra_person ?? 0;
                $reservation_room_tariff->extra_pax_amount = $reservationroomData[0]->extra_person_amount ?? 0;
                $reservation_room_tariff->save(); 
            }

        }else{
            $res_update = ReservationRoom::where('id', $id)->update([
                'checkin' => $request->dateAtCheckinIndex['full_date'],
                'checkout' => $endDate
            ]);
        }
        $draggedRoomNumber = "Unallocated";
        if (is_numeric($request->keyDragged)){
            $draggedRoomNum = RoomNumber::where('id',$request->keyDragged)->value('room_number');
            $draggedRoomNumber = $draggedRoomNum;
        }
        $droppedRoomNum = RoomNumber::where('id',$request->keydropped)->update([
            'current_status' => 0
        ]);
        $droppedRoomNum = RoomNumber::where('id',$request->keydropped)->value('room_number');
        if($res_update) {
            $activity_log = new ActivityLog();
            $activity_log->reservation_id = $reservationid;
            $activity_log->room_id = $id;
            $activity_log->activity = 'Dragged and Dropped from room no. '.$draggedRoomNumber.' to room no. '.$droppedRoomNum;
            $activity_log->activity_by = Auth::user()->name .' ('.Auth::user()->usertype_id.')';
            $activity_log->save();
            return response()->json(['success' => 'Reservation details updated successfully'], 200);
        }
        return response()->json(['error' => 'Details not updated'], 400); // Use a consistent error message format and include a status code
    }

    public function reservationPayment(Request $request) {
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'amount' => 'required',
                'payment_date' => 'required',
                'payment_type' => 'required',
            ]);
    
            if($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
            $roomIDs = $request->roomID;
            foreach($roomIDs as $roomID){
                
                $reservationpayment = new ReservationPayment();
                $reservationpayment->reservation_id = $request->reservationid;
                $reservationpayment->reservation_room_id = $roomID;
                $reservationpayment->amount_paid = $request->amount;
                $reservationpayment->payment_date = $request->payment_date;
                $reservationpayment->payment_type = $request->payment_type;
                $reservationpayment->deposite_status = $request->deposite;
                $reservationpayment->note = $request->note;
                $reservationpayment->note_show_status = $request->shownote;
                $reservationpayment->email_invoice_status = $request->email_invoice;
                $reservationpayment->guest_email = $request->guest_email;
                $reservationpayment->recorded_by = Auth::user()->id;
                if($reservationpayment->save()) {

                    $activity_log = new ActivityLog();
                    $activity_log->reservation_id = $request->reservationid;
                    $activity_log->room_id = $roomID;
                    $activity_log->activity = 'Rs.'.$request->amount.' Room Payment Done';
                    $activity_log->activity_by = Auth::user()->name .' ('.Auth::user()->designation.')';
                    $activity_log->save();
                    $paidAmount = ReservationPayment::where('reservation_id',$request->reservationid)->sum('amount_paid');
                    $advance = AdvanceAmount::where('reservation_id',$request->reservationid)->sum('amount');
                    $reservation = Reservation::where('reservation_id',$request->reservationid)->update([
                        'paid_amount' => $paidAmount + $advance
                    ]);
                    //$paidAmt_new = ReservationRoom::where('id',$roomID)->get(['paid_amount','discount']);
                    return response()->json(['success' => 'Amount Submitted Successfully','res_payment'=>$paidAmount], 200);
                } else {
                    return response()->json(['error_success' => 'Payment Not Done'], 400);
                }
            }
        }
    }
    
    public function submitroomguestData(Request $request) {
        // dd($request->all());
        if($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name_g_rsv_add' => ['required', 'array'],
                'mobile_g_rsv_add' => ['required', 'array'],
            ]);
    
            if($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }
        
        $name = $request->name_g_rsv_add;
        $mobile = $request->mobile_g_rsv_add;
        $doctype = $request->doc_g_rsv_add;
        $idnum = $request->idnum_g_rsv_add;
        $gender = $request->gender_g_rsv_add;
        $roomguestsave = false;
        $idProofs = $request->file('idproof_g_rsv_add');
    
        for ($i = 0; $i < count($request->name_g_rsv_add); $i++) {

            // Skip empty guest rows
            if (empty($request->name_g_rsv_add[$i])) {
                continue;
            }

            $isPrimary = 0;
            $chkReservation = Reservation::where('reservation_id',$request->reservation_id)->where('mobile',$mobile[$i])->count();
            if($chkReservation > 0){
                $isPrimary = 1;
            }

            // $proofFile = null;
            // if (!empty($idProofs[$i])) {
            //     $proof = $idProofs[$i];
            //     $fileName = time().'_'.$i.'.'.$proof->getClientOriginalExtension();
            //     $proof->move(public_path('/backend/uploads/reservation'), $fileName);
            //     $proofFile = $fileName;
            // }

            $proofFile = null;
            if (!empty($idProofs[$i])) {

                $image = $idProofs[$i];
                $folder = public_path('backend/uploads/reservation/');
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $proofFile = time() . '.jpg';
                $destination = $folder . $proofFile;

                ImageCompressor::resizeAndCompress(
                    $image->getPathname(),
                    $destination,
                    1024,   // max width
                    150     // target size (KB)
                );
            }

            $first_name = explode(' ', $request->name_g_rsv_add[$i])[0] ?? '';
            $last_name  = explode(' ', $request->name_g_rsv_add[$i])[1] ?? '';

            $chk_record = RoomGuest::where('reservation_id',$request->reservation_id)->where('mobile',$mobile[$i])->count();
            if($chk_record > 0){

                $chk_record = RoomGuest::where('reservation_id',$request->reservation_id)->where('mobile',$mobile[$i])->update([
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'mobile' => $mobile[$i],
                    'gender' => $gender[$i] ?? '',
                    'document_type' => $doctype[$i] ?? '',
                    'id_number' => $idnum[$i] ?? '',
                    'id_proof' => $proofFile
                ]);
            }else{

                $roomguest = new RoomGuest();
                $roomguest->room_id = $request->roomid;
                $roomguest->reservation_id = $request->reservation_id;
                $roomguest->first_name = $first_name;
                $roomguest->last_name = $last_name;
                $roomguest->mobile = $mobile[$i];
                $roomguest->document_type = $doctype[$i] ?? '';
                $roomguest->id_number = $idnum[$i] ??'';
                $roomguest->gender = $gender[$i] ??'';
                $roomguest->isPrimary = $isPrimary;
                $roomguest->id_proof = $proofFile;
                $roomguestsave = $roomguest->save();
            }
        }
    
        if($roomguestsave) {
            return response()->json(['success' => 'Data submitted successfully'], 200);
        } else {
            return response()->json(['error_success' => 'Data not submitted'], 400);
        }
    }

    public function roomguestnoteData(Request $request){
        
        Reservation::where('reservation_id',$request->reservationid)->update([
            'note'=> $request->notes ?? ''
        ]);
        
        return response()->json(['success' => 'Notes Updated Succesfully'],200);
    }

    public function getActivityLogDetails(Request $request){
        
        $activitydetails = ActivityLog::where('reservation_id',$request->reservationid)->where('room_id',$request->roomID)->get();
        
        return response()->json(['success'=>'Activity Details Found','activitydetails'=>$activitydetails],200);
    }

    public function roomcheckIn(Request $request){
        DB::beginTransaction();
        
        try {

            foreach($request->roomDetail as $detail){
                
                $checkout_update = ReservationRoom::where('id', $detail['id'])->where('reservation_id',$request->reservationid)->update([
                    'guest_status' => 'Check-in',
                    'room_alloted_id' => $detail['room'],
                    'room_alloted' => $detail['room_number'],
                    'status' => 'Alloted',
                    'checkedin_at'=> now()
                ]);

                $room_update = RoomNumber::where('id',$detail['room'])->update([
                    'current_status' => 0
                ]);

                $reservation_detail = Reservation::where('reservation_id',$request->reservationid)->value('id');
                $reservation_room_detail =  ReservationRoom::where('id',$detail['id'])->get();
                $tariff = Tariff::where('id',$reservation_room_detail[0]->tariff_id)->value('tariff_type');

                $reservation_room_tariff = new ReservationRoomTariffLog();
                $reservation_room_tariff->date = date('Y-m-d H:i:s');
                $reservation_room_tariff->reservation_id = $reservation_detail;
                $reservation_room_tariff->reservation = $request->reservationid;
                $reservation_room_tariff->reservation_room_id =$detail['id'];
                $reservation_room_tariff->room_type_id =  $reservation_room_detail[0]->room_category_id;
                $reservation_room_tariff->tariff_id = $reservation_room_detail[0]->tariff_id;
                $reservation_room_tariff->tariff = $tariff;
                $reservation_room_tariff->room_id = $detail['room'];
                $reservation_room_tariff->room = $detail['room_number'];
                $reservation_room_tariff->adults = $reservation_room_detail[0]->adults;
                $reservation_room_tariff->childrens = $reservation_room_detail[0]->childrens;
                $reservation_room_tariff->infants = $reservation_room_detail[0]->infants;
                $reservation_room_tariff->amount = $reservation_room_detail[0]->amount;
                $reservation_room_tariff->extra_pax = $reservation_room_detail[0]->extra_person;
                $reservation_room_tariff->extra_pax_amount = $reservation_room_detail[0]->extra_person_amount;
                $reservation_room_tariff->save();

                $activity_log = new ActivityLog();
                $activity_log->reservation_id = $request->reservationid;
                $activity_log->room_id = $request->clicked_room_id;
                $activity_log->activity = 'Room Checked In';
                $activity_log->activity_by = Auth::user()->name .' ('.Auth::user()->designation.')';
                $activity_log->save();
            }
            
            Reservation::where('reservation_id',$request->reservationid)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'country' => $request->country,
                'allergic_to' => $request->allergic_to,
                'guest_type' => $request->guest,
                'coming_from' => $request->coming_from,
                'going_to' => $request->going_to,
                'purpose_for_visit' => $request->purpose_of_visit,
                'document_type' => $request->document_type,
                'other_document_type' => $request->other_detail,
                'id_number' => $request->id_number,
                'company_name' => $request->company_name,
                'company_gst' => $request->company_gst,
                'company_address' => $request->company_address,
                'company_pincode' => $request->company_pincode,
                'company_state' => $request->company_state,
            ]);

            DB::commit(); // data saved in both the table successfullt.
            return response()->json(['success' => 'Room Checked In successfully'], 200);

        } catch (\Exception $e) {
         
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! while updating room', 'message' => $e->getMessage()], 500);
        }

    }

    public function roomCheckOut(Request $request) {
        $reservation_id = $request->reservationid;
        $room_id = array_unique($request->room_id);
        $chk = 0;
        foreach ($room_id as $roomNumber) {
            $room_number = RoomNumber::where('id',$roomNumber)->pluck('room_number');
            $chk_kot = Kot::where('kot_id',$reservation_id)->where('type','Room')->where('type_number',$room_number[0])->where('payment_type','Due')->count();
            if($chk_kot > 0){
                $chk++;
            }
        }

        if($chk > 0){
            return response()->json(['error' => 'KOT Bill is due Please clear it.'], 200);
        }else{
            // Update room number status
            $rand = rand(1000,9999);
            foreach ($room_id as $roomNumber) {
                ReservationRoom::where('id', $roomNumber)->update([
                    'primary_name' => $request->first_name.' '.$request->last_name,
                    'random' => $rand,
                ]);
            }

            Reservation::where('reservation_id',$reservation_id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'country' => $request->country,
                'allergic_to' => $request->allergic_to,
                'guest_type' => $request->guest,
                'coming_from' => $request->coming_from,
                'going_to' => $request->going_to,
                'purpose_for_visit' => $request->purpose_of_visit,
                'document_type' => $request->document_type,
                'other_document_type' => $request->other_detail,
                'id_number' => $request->id_number,
                'company_name' => $request->company_name,
                'company_gst' => $request->company_gst,
                'company_address' => $request->company_address,
                'company_pincode' => $request->company_pincode,
                'company_state' => $request->company_state,
            ]);

            $guest_id = Reservation::where('reservation_id',$reservation_id)->value('guest_id');

            Customer::where('id',$guest_id)->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->pincode,
                'country' => $request->country,
                'allergic_to' => $request->allergic_to,
                'company_name' => $request->company_name,
                'gst_number' => $request->company_gst,
                'company_address' => $request->company_address,
                'company_pincode' => $request->company_pincode,
                'company_state' => $request->company_state,
                'id_proof' => $request->id_number,
                'proof_type' => $request->document_type,
            ]);

            $filename = '';
            if ($request->hasFile('id_proof')) {

                $image = $request->file('id_proof');
                $folder = public_path('backend/uploads/reservation/');
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $filename = time() . '.jpg';
                $destination = $folder . $filename;

                ImageCompressor::resizeAndCompress(
                    $image->getPathname(),
                    $destination,
                    1024,   // max width
                    150     // target size (KB)
                );

                Reservation::where('reservation_id',$reservation_id)->update([
                    'id_proof' => $filename
                ]);
            }

            return response()->json(['success' => 'Room checked out successfully','random' => $rand], 200);
        }
    }

    public function edit_add_reservation(Request $request){
        // dd($request->all());
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'checkin' => ['required'],
                'checkout' => ['required'],
                'roomTariff' => ['required', 'array'],
                'room_type' => ['required', 'array'],
                'adults' => ['required', 'array'],
                'childrens' => ['required', 'array'],
                'infants' => ['required', 'array'],
                'amount' => ['required', 'array'],
                'extra_person' => ['required', 'array'],
                'extra_person_amount' => ['required', 'array'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        $reservation_id = $request->reservationid;
        $roomTariff[] = $request->roomTariff;
        $room_type[] = $request->room_type;
        $adults[] = $request->adults;
        $childrens[] = $request->childrens;
        $infants[] = $request->infants;
        $amount[] = $request->amount;
        $extra_person[] = $request->extra_person;
        $extra_person_amount[] = $request->extra_person_amount;
        $roomNo[] = $request->roomNo;

        // Save the reservation room details
        for ($z = 0; $z < count($room_type); $z++) {
            for ($i = 0; $i < count($room_type[$z]); $i++) {
                
                $chk = ReservationRoom::where('reservation_id',$reservation_id)->where('room_category_id', $room_type[$z][$i])->where('tariff_id', $roomTariff[$z][$i])->count();
                if($chk > 0) {
                    
                    ReservationRoom::where('reservation_id',$reservation_id)->where('room_category_id', $room_type[$z][$i])->where('tariff_id', $roomTariff[$z][$i])->update([
                        
                        'primary_name' => $request->primary_name,
                        'checkin' => date('Y-m-d',strtotime($request->checkin)),
                        'checkout' => date('Y-m-d',strtotime($request->checkout)),
                        'room_category_id' => $room_type[$z][$i] ?? 0,
                        'tariff_id' => $roomTariff[$z][$i],
                        'adults' => $adults[$z][$i],
                        'childrens' => $childrens[$z][$i],
                        'infants' => $infants[$z][$i],
                        'amount' => $amount[$z][$i],
                        'extra_person' => $extra_person[$z][$i],
                        'extra_person_amount' => $extra_person_amount[$z][$i],
                    ]);

                    if($roomNo[$z][$i] != 'NA'){

                        $alloted = ReservationRoom::where('room_category_id', $room_type[$z][$i])->value('room_alloted_id');
                        
                        if(intval($roomNo[$z][$i]) != $alloted){
                            $room_numbers = RoomNumber::where('id',$roomNo[$z][$i])->value('room_number');
                            $room_update = RoomNumber::where('id',$roomNo[$z][$i])->update([
                                'current_status' => 0
                            ]);

                            ReservationRoom::where('reservation_id',$reservation_id)->where('room_category_id', $room_type[$z][$i])->where('tariff_id', $roomTariff[$z][$i])->update([
                                'status' => 'Alloted',
                                'room_alloted_id' => $roomNo[$z][$i],
                                'room_alloted' => $room_numbers,
                            ]);

                            if($alloted != 'NA'){
                                $room_update_last = RoomNumber::where('id',$alloted)->update([
                                    'current_status' => -1
                                ]);
                            }

                            $reservation_detail = Reservation::where('reservation_id',$reservation_id)->value('id');
                            $reservation_room_detail =  ReservationRoom::where('reservation_id',$reservation_id)->where('room_alloted_id',$roomNo[$z][$i])->value('id');
                            $tariff = Tariff::where('id',$roomTariff[$z][$i])->value('tariff_type');

                            $reservation_room_tariff = new ReservationRoomTariffLog();
                            $reservation_room_tariff->date = date('Y-m-d H:i:s');
                            $reservation_room_tariff->reservation_id = $reservation_detail;
                            $reservation_room_tariff->reservation = $reservation_id;
                            $reservation_room_tariff->reservation_room_id = $reservation_room_detail;
                            $reservation_room_tariff->room_type_id =  $room_type[$z][$i];
                            $reservation_room_tariff->tariff_id = $roomTariff[$z][$i];
                            $reservation_room_tariff->tariff = $tariff;
                            $reservation_room_tariff->room_id = $roomNo[$z][$i];
                            $reservation_room_tariff->room = $room_numbers;
                            $reservation_room_tariff->adults = $adults[$z][$i];
                            $reservation_room_tariff->childrens = $childrens[$z][$i];
                            $reservation_room_tariff->infants = $infants[$z][$i];
                            $reservation_room_tariff->amount = $amount[$z][$i];
                            $reservation_room_tariff->extra_pax = $extra_person[$z][$i];
                            $reservation_room_tariff->extra_pax_amount = $extra_person_amount[$z][$i];
                            $reservation_room_tariff->save();
                        }
                    }
                }else{
                    $reservation_room = new ReservationRoom();
                    $reservation_room->reservation_id = $reservation_id;
                    $reservation_room->primary_name = $request->primary_name;
                    $reservation_room->checkin = date('Y-m-d',strtotime($request->checkin));
                    $reservation_room->checkout = date('Y-m-d',strtotime($request->checkout));
                    $reservation_room->room_category_id = $room_type[$z][$i] ?? 0;
                    $reservation_room->tariff_id = $roomTariff[$z][$i];
                    $reservation_room->adults = $adults[$z][$i];
                    $reservation_room->childrens = $childrens[$z][$i];
                    $reservation_room->infants = $infants[$z][$i];
                    $reservation_room->amount = $amount[$z][$i];
                    $reservation_room->extra_person = $extra_person[$z][$i];
                    $reservation_room->extra_person_amount = $extra_person_amount[$z][$i];
                    if($room_type[$z][$i] != 'NA'){
                        $reservation_room->status = 'Alloted';
                        $reservation_room->room_alloted_id = $roomNo[$z][$i];

                        $room_numbers = RoomNumber::where('id',$roomNo[$z][$i])->value('room_number');
                        $reservation_room->room_alloted = $room_numbers;
                        
                        $room_update = RoomNumber::where('id',$roomNo[$z][$i])->update([
                            'current_status' => 0
                        ]);
                    }
                    $reservation_room->save();
                }
            }
        }

        // Log activity
        $activity_log = new ActivityLog();
        $activity_log->reservation_id = $reservation_id;
        $activity_log->activity = 'New Room Added';
        $activity_log->activity_by = Auth::user()->name .' ('.Auth::user()->designation.')';
        $activity_log->save();

        return response()->json(['success' => 'Reservation updated successfully'], 200);
    }
      
    public function editReservationUpdate(Request $request){
        // Retrieve all data from the request
        $data = $request->all();
        // dd($data);
        DB::beginTransaction();
        
        try {
            foreach ($data['roomEditID'] as $index => $roomId) {
                $room_alloted = 'NA';
                if($data['roomNumEdit'][$index] != 'NA'){
                    $room_numbers = RoomNumber::where('id',$data['roomNumEdit'][$index])->value('room_number');
                    $room_alloted = $room_numbers;

                    $alloted = ReservationRoom::where('id', $roomId)->value('room_alloted_id');
                            
                    if($data['roomNumEdit'][$index] != $alloted){
                        
                        $room_update = RoomNumber::where('id',$data['roomNumEdit'][$index])->update([
                            'current_status' => 0
                        ]);

                        if($alloted != 'NA'){
                            $room_update_last = RoomNumber::where('id',$alloted)->update([
                                'current_status' => -1
                            ]);
                        }
                    }
                    
                    ReservationRoom::where('id', $roomId)->update([
                        'room_category_id' => $data['room_typeEdit'][$index],
                        'room_alloted' => $room_alloted,
                        'tariff_id' => $data['room_tariffEdit'][$index] ?? 0,
                        'adults' => $data['adultsEdit'][$index] ?? 0,
                        'childrens' => $data['childrensEdit'][$index] ?? 0,
                        'infants' => $data['infantsEdit'][$index] ?? 0,
                        'amount' => $data['amountEdit'][$index] ?? 0,
                        'extra_person' => $data['extraPerEdit'][$index] ?? 0,
                        'extra_person_amount' => $data['extraPerEditAmount'][$index] ?? 0,
                    ]);

                    $reservation_detail = Reservation::where('reservation_id',$request->reservation_id)->value('id');
                    $reservation_room_detail =  ReservationRoom::where('id',$roomId)->get();
                    $tariff = Tariff::where('id',$reservation_room_detail[0]->tariff_id)->value('tariff_type');

                    //$chk_exits = ReservationRoomTariffLog::where('reservation',$request->reservation_id)->where('reservation_room_id',$roomId)->where('tariff_id',$reservation_room_detail[0]->tariff_id)->latest('id')->count();
                    $chk_exits = ReservationRoomTariffLog::where('reservation',$request->reservation_id)->where('reservation_room_id',$roomId)->where('adults',$data['adultsEdit'][$index])->where('amount',$data['amountEdit'][$index])->where('extra_pax',$data['extraPerEdit'][$index])->where('extra_pax_amount',$data['extraPerEditAmount'][$index])->whereNull('end_date')->latest('id')->count();
                    if($chk_exits == 0){
                        
                        $update_last = ReservationRoomTariffLog::where('reservation',$request->reservation_id)->where('reservation_room_id',$roomId)->whereNull('end_date')->update([
                            'end_date' => date('Y-m-d H:i:s')
                        ]);

                        $reservation_room_tariff = new ReservationRoomTariffLog();
                        $reservation_room_tariff->date = date('Y-m-d H:i:s');
                        $reservation_room_tariff->reservation_id = $reservation_detail;
                        $reservation_room_tariff->reservation = $request->reservation_id;
                        $reservation_room_tariff->reservation_room_id = $roomId;
                        $reservation_room_tariff->room_type_id =  $data['room_typeEdit'][$index];
                        $reservation_room_tariff->tariff_id = $reservation_room_detail[0]->tariff_id;
                        $reservation_room_tariff->tariff = $tariff;
                        $reservation_room_tariff->room_id = $data['roomNumEdit'][$index];
                        $reservation_room_tariff->room = $room_alloted;
                        $reservation_room_tariff->adults = $data['adultsEdit'][$index];
                        $reservation_room_tariff->childrens = $data['childrensEdit'][$index];
                        $reservation_room_tariff->infants = $data['infantsEdit'][$index];
                        $reservation_room_tariff->amount = $data['amountEdit'][$index];
                        $reservation_room_tariff->extra_pax = $data['extraPerEdit'][$index];
                        $reservation_room_tariff->extra_pax_amount = $data['extraPerEditAmount'][$index];
                        $reservation_room_tariff->save();
                    }
                }

                ReservationRoom::where('id', $roomId)->update([
                    'room_category_id' => $data['room_typeEdit'][$index],
                    'room_alloted' => $room_alloted,
                    'tariff_id' => $data['room_tariffEdit'][$index] ?? 0,
                    'adults' => $data['adultsEdit'][$index] ?? 0,
                    'childrens' => $data['childrensEdit'][$index] ?? 0,
                    'infants' => $data['infantsEdit'][$index] ?? 0,
                    'amount' => $data['amountEdit'][$index] ?? 0,
                    'extra_person' => $data['extraPerEdit'][$index] ?? 0,
                    'extra_person_amount' => $data['extraPerEditAmount'][$index] ?? 0,
                ]);
            }
        
            $company_name = '';
            $company_gst = '';
            $company_address = '';
            $company_pincode = '';
            $company_state = '';
            if($data['company_gst'] != '' && $data['gstLegalName'] != ''){
                $company_name = $data['gstTradeName'];
                $company_gst = $data['company_gst'];
                $company_address = $data['gstAddr'];
                $company_pincode = $data['gstAddrPncd'];
                $state = State::where('gst_code',$data['gstStateCode']).value('name');
                $company_state = $state;
            }else if($data['company_gst'] == '' && $data['company_name'] != ''){
                $company_name = $data['company_name'];
                $company_gst = $data['company_gst'];
                $company_address = $data['company_address'];
                $company_pincode = $data['company_pincode'];
                $company_state = $data['company_state'];
            }

            $company_id = '';
            if($company_gst != ''){

                $chk_company = Company::where('Gstin',$company_gst)->count();
                if($chk_company > 0){ }
                else{
    
                    $company = new Company();
                    $company->name = $company_name;
                    $company->mobile = $data['mobile'] ?? '';
                    $company->email = $data['email'] ?? '';
                    $company->Gstin = $company_gst;
                    $company->address = $company_address;
                    $company->addrBnm = $data['gstAddrBnm'];
                    $company->addrBno = $data['gstAddrBno'];
                    $company->addrFlno = $data['gstAddrFlno'];
                    $company->addrLoc = $data['gstAddrLoc'];
                    $company->addrPncd = $company_pincode;
                    $company->addrSt = $data['gstAddrSt'];
                    $company->BlkStatus = $data['gstBlkStatus'];
                    $company->DtDReg = $data['gstDtDReg'];
                    $company->DtReg = $data['gstDtReg'];
                    $company->LegalName = $data['gstLegalName'];
                    $company->StateCode = $data['gstStateCode'];
                    $company->TradeName = $data['gstTradeName'];
                    $company->TxpType = $data['gstTxpType'];
                    $company->gstStatus = $data['gstStatus'];
                    $company->state = $company_state;
                    $company->save();

                    $company_id = $company->id;
                }
            }

            // Update the main reservation details
            $main_reservation_update = Reservation::where('reservation_id', $request->reservation_id)->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'] ?? '',
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'pincode' => $data['pincode'],
                'country' => $data['country'],
                'gender' => $data['gender'],
                'arrival_time' => $data['arrival_time'],
                'document_type' => $data['document_type'],
                'other_document_type' => $data['other_document_type'] ?? '',
                'id_number' => $data['id_number'],
                'guest_comment' => $data['comments'] ?? '',
                'note' => $data['comments'] ?? '',
                'coming_from' => $data['coming_from'] ?? '',
                'going_to' => $data['going_to'] ?? '',
                'purpose_for_visit' => $data['purpose_of_visit'] ?? '',
                'company_name' => $company_name ?? '',
                'company_gst' => $company_gst ?? '',
                'company_address' => $company_address ?? '',
                'company_pincode' => $company_pincode ?? '',
                'company_state' => $company_state ?? '',
                'company_id' => $company_id ?? '',
            ]);
      
            $guest_id = Reservation::where('reservation_id',$request->reservation_id)->value('guest_id');

            Customer::where('id',$guest_id)->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'] ?? '',
                'address' => $data['address'],
                'city' => $data['city'],
                'state' => $data['state'],
                'pincode' => $data['pincode'],
                'gender' => $data['gender'],
                'country' => $data['country'],
                'company_name' => $company_name ?? '',
                'gst_number' => $company_gst ?? '',
                'company_address' => $company_address ?? '',
                'company_pincode' => $company_pincode ?? '',
                'company_state' => $company_state ?? '',
            ]);

            $filename = '';
            if ($request->hasFile('id_proof')) {

                $image = $request->file('id_proof');
                $folder = public_path('backend/uploads/reservation/');
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $filename = time() . '.jpg';
                $destination = $folder . $filename;

                ImageCompressor::resizeAndCompress(
                    $image->getPathname(),
                    $destination,
                    1024,   // max width
                    150     // target size (KB)
                );

                Reservation::where('reservation_id',$request->reservation_id)->update([
                    'id_proof' => $filename
                ]);
            }

            DB::commit(); // data saved in both the table successfully.
            return response()->json(['success' => 'Reservation details updated'], 200);

        } catch (\Exception $e) {
         
            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
        }
    }
      
    public function updateroomguestData(Request $request){
        // Retrieve all data from the request
        $data = $request->all();
       // Ensure reservationID is correctly passed and validated
       // Iterate through each room data and update accordingly
       foreach ($data['room_guest_id'] as $index => $roomGId) {
           // Update the room reservation by ID
           $guest_update = RoomGuest::where('id', $roomGId)->update([
               'first_name' => $data['name'][$index],
               'mobile' => $data['mobile'][$index],
               'document_type' => $data['doctype'][$index] ??'',
               'id_number' => $data['idnum'][$index] ??'',
               'gender' => $data['gender'][$index] ??'',
           ]);
       }
       if($guest_update){
         return response()->json(['success' => 'Guest Details Updated'],200);
       }else{
         return response()->json(['error_success' => 'Guest Details Not Updated']);

       }
    }

    public function res_confirm_status(Request $request){
        $room_id = $request->room_id;
        $room_confirm =  ReservationRoom::where('id',$room_id)->update([
            'res_confirm_status'=>'Confirmed'
        ]);
        if($room_confirm){
            return response()->json(['success'=>'Status Updated'],200);
        }else{
            return response()->json(['error_success'=>'Status Not Updated']);

        }

    }

    public function guestCheckout(Request $request){
        $date = now();
        $gcheckout = RoomGuest::where('id',$request->id)->update([
            'status'=>'Check-out',
            'checkedin_at'=>$date,
            'checkedout_at'=>$date,
            'remarks'=>$request->name.' checkedout',
        ]);
        if($gcheckout){
            return response()->json(['success'=>'Guest checkout successfully'],200);
        }else{
            return response()->json(['error_success'=>'Guest not checkout'],400);
        }
    }

    public function getDetailsWithPhone(Request $request){
        $mob_num = $request->phone;
        $data = Customer::where('mobile',$mob_num)->latest()->take(5)->get();
        return response()->json(['success'=>'Data fetched Successfully','customer'=>$data],200);        
    }

    public function addDataUsingPhone(Request $request){
        $id = $request->id;
        $data = Customer::where('guest_id',$id)->get();
        return response()->json(['success'=>'Details fetched successfully','resDetails'=>$data],200);
    }

    public function reservationHistory(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.reservation.reservation_history',compact('hotlr'));
    }

    public function getAllData(Request $request){
        if($request->ajax()){
            $reservationDetails = DB::table('reservations')->get();  //query builder not need of model
            return DataTables::of($reservationDetails)
            ->addIndexColumn()
            ->addColumn('reservationid',function($row){
                return $row->reservation_id;
            })
            ->addColumn('created_at',function($row){
                return $row->created_at;
            })
            ->addColumn('name',function($row){
            return $row->name;
            })
            ->addColumn('mobile',function($row){
                return $row->mobile;
            })
            ->addColumn('email',function($row){
                return $row->email;
            })
            ->addColumn('address',function($row){
                return $row->address;
            })
            ->addColumn('arrival_time',function($row){
                return $row->arrival_time;
            })
            ->addColumn('city',function($row){
                return $row->city;
            })
            ->addColumn('state',function($row){
                return $row->state;
            })
            ->addColumn('pin',function($row){
                return $row->pin;
            })
            ->addColumn('document_type',function($row){
                return $row->document_type;
            })
            ->addColumn('id_number',function($row){
                return $row->id_number;
            })
            ->addColumn('company_name',function($row){
                return $row->company_name;
            })
            ->addColumn('company_gst',function($row){
                return $row->company_gst;
            })
            ->addColumn('company_address',function($row){
                return $row->company_address;
            })
            ->addColumn('comments',function($row){
                return $row->comments;
            })
            ->make(true);
            //  return response()->json(['success'=>'Reservation Data fetched','resData'=>$reservationDetails],200);
        }
    }

    public function updateDiscountEdit(Request $request){
        $roomID = $request->id;
        $discount = $request->value;
        $old_discount = ReservationRoom::where('id',$roomID)->get(['discount']);
        $old_disc = $old_discount[0]->discount;
        $update = ReservationRoom::where('id',$roomID)->update([
        'discount' =>$old_disc + $discount
        ]);
        if($update){
        return response()->json(['success'=>'Discount successfully Updated'],200);
        }else{
        return response()->json(['success'=>'Discount not Updated']);
        }
    }

    public function occupancyChart(){
        $company = HotlrConfiguration::get(['logo']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        $reservation_data = ReservationRoom::where('status','Alloted')->get();
        return view('backend.modules.reservation.occupied-chart',compact('reservation_data','company','hotlr'));
    }
      
    public function cancelReservation(Request $request){
        $reservation = ReservationRoom::where('id',$request->id)->update([
            'status' => 'Cancel'
        ]);
        if($reservation){
            return response()->json(['success'=>'Selected Reservation Successfully Cancelled'],200);
        }else{
            return response()->json(['success'=>'Something Went Wrong']);
        }
    }

    public function getPaymentDetail(Request $request){
        
        $total_amount = 0;
        $room_id = array_unique($request->roomCheck_Ids);
        $number_of_rooom = ReservationRoom::where('reservation_id',$request->reservation_id)->where('room_alloted','!=','NA')->count();
        $reservation_rooms = ReservationRoom::where('reservation_id',$request->reservation_id)->whereIn('id',$room_id)->get(['checkin','checkout','amount','extra_person','extra_person_amount','checkedin_at','tariff_id']);
        
        foreach($reservation_rooms as $room){
            $days = $this->daysCalculate($room->checkedin_at,$room->checkout);
            $total_amount += $days * (($room->tariff_detail->room_tariff) + ($room->extra_person * $room->tariff_detail->extra_person_tariff));
        }

        $discount_amount = 0;
        $reservation_discount = Reservation::where('reservation_id',$request->reservation_id)->value('discount');
        if($reservation_discount > 0){
            $discount_amount = (($reservation_discount/100)*$total_amount);
        }

        $paid_amount = ReservationPayment::where('reservation_id',$request->reservation_id)->whereIn('reservation_room_id',$room_id)->sum('amount_paid');
        $advance_amount = AdvanceAmount::where('reservation_id',$request->reservation_id)->sum('amount');
        if($number_of_rooom == count($request->roomCheck_Ids)){
            $advance_amount_value = $advance_amount;
        }else{
            $advance_amount_value = $advance_amount/$number_of_rooom;
        }

        $total_cost = $total_amount - ($paid_amount + $discount_amount + $advance_amount_value);
        return response()->json(['amount' => round($total_cost),'date' => date('Y-m-d')]);
    }

    public function reservationLayout(Request $request){
        
        $reservationRoom = ReservationRoom::where('status','Reserved')->where('checkin','<',date('Y-m-d'))->update([
        'status' => 'Cancel'
        ]);
        // end
        
        $roomnumber = RoomNumber::get();
        $room_types = RoomType::get();
        $roomCategoryNum = [];

        foreach($room_types as $type){
            $rooms = [];
            $room_numbers = RoomNumber::where('category_id',$type->id)->where('status','active')->get();
            foreach($room_numbers as $number){
                $rooms[] = [
                    'id' => $number->id,
                    'room_number' => $number->room_number,
                    'current_status' => $number->current_status,
                ];
            }
            
            if(count($rooms) > 0){
                $data = [
                    'id'=> $type->id,
                    'name'=> $type->room_category,
                    'rooms'=> $rooms
                ];
                array_push($roomCategoryNum,$data);
            }
        }
        
        $decrement = $request->y;
        $totaldays = $request->days;
        $currdates = '';
        $currdatesData = $request->refdate;
        $dateCollect = [];
        $area = $request->session()->get('reservaionViewCount');
        if($area == null){
            $area = 7;
        }
        $getResViewCount = $request->session()->get('reservaionViewCount') + $totaldays;
        $dates = [];
        
        if($totaldays > 0){
            if($totaldays != 99){
                if ($decrement == 0) {
                    $mydates = date('Y-m-d', strtotime(' +'.$totaldays.' day', strtotime($currdatesData)));
                }else if($decrement == 2) {
                    $mydates = date('Y-m-d');
                }else{
                    $mydates = date('Y-m-d', strtotime(' -'.$totaldays.' day', strtotime($currdatesData)));
                }
            }else{
                $mydates = date('Y-m-d',strtotime($currdatesData));
            }
        }else{
            $mydates = date('Y-m-d');
        }

        $setdate = $mydates;
        for($i=0; $i< $area; $i++){
            $currentDate = date('Y-m-d', strtotime(' +'.$i.' day', strtotime($setdate)));
            array_push($dateCollect,$currentDate);
        }

        foreach($dateCollect as $date){
            $dateView = [
                'full_date' => $date,
                'date' => date('d',strtotime($date)),
                'month' => date('M',strtotime($date)),
                'day' => date('D',strtotime($date)),
                'today' => date('Y-m-d')
            ];
            array_push($dates,$dateView);
            //reservation Detail according to date
        }

        $totalDate = count($dates)-1;
        //below roomEachDetails used for row view reservation data display
        $reservationRoomDetail = [];
        $reservation_query = ReservationRoom::whereBetween('checkin',[$dates[0]['full_date'],$dates[$totalDate]['full_date']])->orWhereBetween('checkout',[$dates[0]['full_date'],$dates[$totalDate]['full_date']])->get(['id','checkin','checkout','room_type','room_category_id','status','dropped_row','dropped_checkin_date','reservation_id','primary_name','amount','extra_person','extra_person_amount','room_alloted']);
        foreach($reservation_query as $reserve){
            $total_cost = 0;
            $date1 = date_create($reserve->checkin);
            $date2 = date_create($reserve->checkout);
            $diff = date_diff($date1,$date2);
            $no_of_nights = $diff->days;
            $count_guest = RoomGuest::where('reservation_id',$reserve->reservation_id)->count();
            $paid_amount = ReservationPayment::where('reservation_id',$reserve->reservation_id)->sum('amount_paid');
            $total_amount =  ($no_of_nights * $reserve->amount) + ($no_of_nights * $reserve->extra_person * $reserve->extra_person_amount);
            $total_cost = $total_amount - $paid_amount;
            $reservationRoomDetail[] =[
                'id' => $reserve->id,
                'checkin' => $reserve->checkin,
                'checkout' => $reserve->checkout,
                'room_type' => $reserve->room_type,
                'room_category_id' => $reserve->room_category_id,
                'status' => $reserve->status,
                'dropped_row' => $reserve->dropped_row,
                'dropped_checkin_date' => $reserve->dropped_checkin_date,
                'reservation_id' => $reserve->reservation_id,
                'primary_name' => $reserve->primary_name,
                'reservation_detail'  =>  $reserve->reservation_data,
                'guest' => $count_guest,
                'stay' => $no_of_nights,
                'total' => $total_amount,
                'outstanding' => $total_cost,
                'roomData' => $reserve->roomData
            ];
        }
        $roomEachDetails = [];
        $statusNameColor = [];
        foreach ($roomnumber as $rnum) {
            $roomnumberDetail = [];
            
            $rooms = ReservationRoom::whereNotIn('status',['Reserved','Final','Cancel'])->whereNull('checkedout_at')->get();
            if($rooms->isNotEmpty()) {
                $firstdate = $rooms[0]->checkin;
                $lastdate = $rooms[0]->checkout;
        
                // Generate dates range
                $currentDate = $firstdate;
                while ($currentDate <= $lastdate) {
                    $roomnumberDetail[] = $currentDate; // Avoids duplicate check with in_array
                    $currentDate = date('Y-m-d', strtotime('+1 day', strtotime($currentDate)));
                }
            }
            //array push
            $closer_name = '';
            $closer_color = '';
            if($rnum->current_status == 0){
                $closer_name = 'Occupied';
                $closer_color = '#feb858';
            }else if($rnum->current_status > 0){
                $closer_reasons = CloserReason::where('id',$rnum->current_status)->get(['name','color']);
                $closer_name = $closer_reasons[0]->name;
                $closer_color = $closer_reasons[0]->color;
                $roomnumberDetail = [];
                foreach($dateCollect as $date){
                    $roomnumberDetail[] = $date;
                }
            }else{
                $closer_name = 'Vacant';
                $closer_color = '#9560DD';
            }

            $roomEachDetails[] = [
                'room_id' => $rnum->id,
                'room_number' => $rnum->room_number,
                'room_status' => $rnum->current_status,
                'room_dates' => $roomnumberDetail,
                'closer_name' => $closer_name,
                'closer_color' => $closer_color,
                'closer_name_vacant' => 'Vacant',
                'closer_color_vacant' => '#9560DD',
            ];
            
            if (array_search($closer_name, array_column($statusNameColor, 'name')) === FALSE) {
                $statusNameColor[] = [
                    'id' => $rnum->current_status,
                    'name' => $closer_name,
                    'color' => $closer_color,
                ];
            } 
        }

        $roomDetails = [];
        $roomtypes = RoomType::get();
        foreach($roomtypes as $type){
            $types = [];
            // $roomAvailable = [];
            $roomNumbers = RoomNumber::where('category_id',$type['id'])->where('status','active')->where('current_status','-1')->get(['category_id','id','room_number','current_status']);
            if(count($roomNumbers) > 0){
                
                $types[] = [
                    'roomNumbers' => $roomNumbers,
                    'type_detail' => $type,
                ];
            }
       
            if(count($types) > 0){
                $data = [
                    'id'=> $type['id'],
                    'name'=> $type['room_category'],
                    'types' => $types
                ];
                array_push($roomDetails,$data);
            }
        }

        $closerReasons = CloserReason::get(['id','name']);
        $states = State::get(['gst_code','name']);
        $payments = PaymentMethod::where('status',1)->get(['id','name']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.reservation.reservation-new',compact('roomDetails','closerReasons','states','payments','hotlr'));
    }

    public function daysCalculate($checkin_date,$checkout,$cal = ''){
        
        $hotlr = HotlrConfiguration::where('id',1)->value('time_configuration');
        $hotrl_json = json_decode($hotlr,true);

        $timeslot = $hotrl_json['timeslot'];
        $time = $hotrl_json['checkout_time'];

        $checkin_time_default = $hotrl_json['checkin_time'];
        $checkout_time_default = date("H:i", strtotime($time . " +".$hotrl_json['checkout_buffer_time']." hours"));

        $checkin = Carbon::parse($checkin_date);
        $checkout = Carbon::parse($checkout);
        if($cal == ''){
            $now = Carbon::now();
            $checkout_time = $now->format('H:i:s');
            if($checkout > $now){
                $now = $checkout;
                $checkout_time = $now->format($checkout_time_default.':00');
            }
        }else{
            $now = $checkout;
            $checkout_time = $now->format('H:i:s');
        }
        
        $days = $checkin->diffInDays($now);

        if($timeslot == 1){
            
            $checkin_time = $checkin->format('H:i:s');
            $checkin_seconds = strtotime($checkin_time);
            $checkout_seconds = strtotime($checkout_time);

            $before_12 = strtotime($checkin_time_default.':00');
            $after_14 = strtotime($checkout_time_default.':00');

            if ($days == 0) {
                if ($checkin_seconds < $before_12 && $checkout_seconds > $after_14) {
                    $days += 2;
                } else {
                    $days += 1;
                }
            } else {
                if ($checkin_seconds < $before_12 && $checkout_seconds > $after_14) {
                    $days += 2;
                } elseif (
                    ($checkin_seconds < $before_12 && $checkout_seconds < $after_14) ||
                    ($checkin_seconds > $before_12 && $checkout_seconds > $after_14)
                ) {
                    $days += 1;
                }
            }
        }else{
            if ($days == 0) {
                $days = 1;
            }else{
                $days = $days;
            }
        }

        return $days;
    }
}

