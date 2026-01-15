<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\RoomCategory;
use App\Models\RoomNumber;
use App\Models\RoomType;
use App\Models\RoomTypeName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Yajra\DataTables\Facades\DataTables;

class RoomnumberController extends Controller
{
    // room_specification_id
    public function index(){
        $room_spec = RoomType::get(['room_category','id']);
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.room_number',compact('room_spec','hotlr'));
    }

    public function add_roomNumber(Request $request){
        
        DB::beginTransaction();
        
        try{
            
            $newRooms = $request->input('room_num'); 
            $rooms = RoomNumber::where('category_id',$request->room_specification_id)->update([
                'status' => 'inactive'
            ]);
            foreach ($newRooms as $roomNumber) {
                $rooms_c = RoomNumber::where('room_number',$roomNumber)->where('status','inactive')->count();
                if($rooms_c > 0){
                    $rooms = RoomNumber::where('category_id',$request->room_specification_id)->where('room_number',$roomNumber)->update([
                        'status' => 'active'
                    ]);
                }else{

                    $roomnumber = new RoomNumber();
                    $roomnumber->category_id = $request->room_specification_id;
                    $roomnumber->room_number = $roomNumber;
                    $roomnumber->current_status = '-1';
                    if ($roomnumber->save()){
                        // QR Code genetare starts
                        $fileName = time() .'_' . $roomnumber->id . '.svg';
                        $path = public_path('backend/uploads/room-qr-code/' . $fileName);
                        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                            $protocol = "https://";
                        } else {
                            $protocol = "http://";
                        }
                        $host = $_SERVER['HTTP_HOST'];
                        $rand = md5(md5($roomnumber->id));
                        $full_url = $protocol . $host.'/index/R'.$rand;
                        $qrCode = QrCode::format('svg')->size(300)->margin(2)->generate($full_url);
                        // Save to file
                        File::put($path, $qrCode);
                        RoomNumber::where('id',$roomnumber->id)->update([
                            'qr_code' => $fileName,
                            'random_code' => $rand
                        ]);
                        //QR Code genetare and store path in RoomNumber table ends
                    }
                }
            }

            $rooms = RoomNumber::where('category_id',$request->room_specification_id)->where('status','inactive')->update([
                'deleted_at' => now()
            ]);
            
            $response = response()->json(['success'=>'Room Number updated successfully'],200);
            DB::commit(); // data saved in both the table successfullt.
            return $response;

        } catch (\Exception $e) {

            DB::rollBack(); // if date not saved in both table then both table rollback as before.
            return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
            
        }
        
    }

    public function get_roomNumberData(Request $request){
        if($request->ajax()){
            $roomnum = RoomNumber::get();
            return DataTables::of($roomnum)
            ->addIndexColumn()
            ->addColumn('room_specification',function($row){
                $room_spec = RoomType::where('id',$row->category_id)->value('room_category');
                return $room_spec;
            })
            ->addColumn('room_number',function($row){
                return $row->room_number;
            })
            ->addColumn('qr_code',function($row){
                $filePath = 'backend/uploads/room-qr-code/'.$row->qr_code;
                return '<img src="'.$filePath.'" height="50px;" width="50px;" alt="QR Code" onclick="openModal(this.src)">
                        <a href="'.$filePath.'"download="roomQR'.$row->qr_code.'" class="mx-3"><i class="ri-download-line"></i>
                        </a>';
            })
            ->addColumn('status',function($row){
                $id = $row->id;
                $checked = $row->status ==='active' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline" onchange="room_num_status('.$id.')">
                      <label class="switch mb-0">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRoomNUm('.$row->id.')"></i></a></li>
                        <li class="delete ms-1 d-none" id="deleteBtn" onclick="delete_room_num('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['qr_code','status','action'])
            ->make(true);
        }
    }

    public function roomNumber_status(Request $request){
        $id = $request->id;
        $rc_status = RoomNumber::where('id',$id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        RoomNumber::where('id',$id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function get_roomNumberDetails(Request $request){
        $id = $request->id;
        $getroomNumData = RoomNumber::where('id',$id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getroomNumData],200);
    }

    public function roomNumber_update(Request $request){
        $filePath = 'backend/uploads/room-qr-code/'.$request->qr_code;
        if(File::exists($filePath)){
            File::delete($filePath);
            //QR Code genetare starts
            $fileName = time() .'_' . $request->id . '.svg';
            $path = public_path('backend/uploads/room-qr-code/' . $fileName);
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                $protocol = "https://";
            } else {
                $protocol = "http://";
            }
            $host = $_SERVER['HTTP_HOST'];
            $rand = md5(md5($request->id));
            $full_url = $protocol . $host.'/index/R'.$rand;
            $qrCode = QrCode::format('svg')->size(300)->margin(2)->generate($full_url);
            // Save to file
            File::put($path, $qrCode);
            //QR Code generate ends
        }
        RoomNumber::where('id',$request->id)->update([
            'category_id' => $request->room_specification_id,
            'room_number' => $request->room_num,
            'qr_code' => $fileName ?? null
        ]);
       return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function roomNumber_delete(Request $request){
        $id = $request->id;
        RoomNumber::where('id',$id)->delete();
        return response()->json(['success' => 'Room Number Deleted Successfully'],200);
    }

    public function roomstatusupdate(Request $request){
        // if (is_numeric($request->roomfrom)) {
            $roomfrom_cstatus = RoomNumber::where('id', $request->roomfrom)->get(['current_status']);
            $foomfrmCurrSts = $roomfrom_cstatus[0]->current_status;
            RoomNumber::where('id', $request->roomfrom)->update([
                'current_status' => -1,
            ]);
        // }
    
        // if (is_numeric($request->roomto)) {
            $roomto_cstatus = RoomNumber::where('id', $request->roomto)->get(['current_status']); // Corrected here
            $foomtoCurrSts = $roomto_cstatus[0]->current_status;
            RoomNumber::where('id', $request->roomto)->update([
                'current_status' => 0,
            ]);
        // }
    
        return response()->json(['success' => 'Room Status Changed'], 200);
    }

    public function getCategoryRoomNumber(Request $request){
        
        $rooms = RoomNumber::where('status','active')->get(['id','room_number','category_id','current_status']);
        return response()->json(['success' => 'Room data fetch successfully','rooms' => $rooms], 200);
    }
}
