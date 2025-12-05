<?php

namespace App\Http\Controllers\backend\restaurant;

use App\Http\Controllers\Controller;
use App\Models\HotlrConfiguration;
use App\Models\ReservationRoom;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class RestaurantTableController extends Controller
{
    public function index(Request $request){
        $hotlr = HotlrConfiguration::get(['logo','name','restaurant_area']);
        $restaurant_area = explode(',',$hotlr[0]['restaurant_area']);
        
        return view('backend.modules.restaurant.restaurant_table',compact('restaurant_area','hotlr'));
    }

    public function store(Request $request){

        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'number' => ['required'],
                'capacity' => ['required'],
                'area' => ['required'],
            ]);

            if ($validator->fails()) {
                return response()->json(['error_validation' => $validator->errors()->all()], 200);
            }
        }

        $check_exist = Table::where('number',$request->number)->where('area',$request->area)->exists();
        if($check_exist == false){     
            $item_insert = new Table();
            $item_insert->number = $request->number;
            $item_insert->capacity = $request->capacity;
            $item_insert->area = $request->area;
            if($item_insert->save()) {
                    //QR Code genetare starts
                    $fileName = time() .'_' . $item_insert->id . '.svg';
                    $path = public_path('backend/uploads/table-qr-code/' . $fileName);
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
                        $protocol = "https://";
                    } else {
                        $protocol = "http://";
                    }
                    $host = $_SERVER['HTTP_HOST'];
                    $rand = md5(md5($item_insert->id));
                    $full_url = $protocol . $host.'/index/T'.$rand;
                    // Generate PNG data
                    $qrCode = QrCode::format('svg')->size(300)->margin(2)->generate($full_url);
                    // Save to file
                    File::put($path, $qrCode);
                    Table::where('id',$item_insert->id)->update([
                        'qr_code' => $fileName,
                        'random_code' => $rand
                    ]);
                    //QR Code genetare and store path in RoomNumber table ends
                return response()->json(['success' => 'Data added successfully'], 200);
            } else {
                return response()->json(['error' => 'Something Went Wrong'], 400);
            }
        }else{
            $response = response()->json(['alreadyfound_error' => 'Table Number already exists! Enter another...']);
        }
        return $response;
    }

    public function getdetails(Request $request){

        if($request->ajax()){

            $data = Table::whereNull('deleted_at')->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('number',function($row){
                return $row->number ?? '';
            })
            ->addColumn('capacity',function($row){
                return $row->capacity ?? '';
            })
            ->addColumn('area',function($row){
                return $row->area ?? '';
            })
            // ->addColumn('qr_code',function($row){
            //     $filePath = 'backend/uploads/table-qr-code/'.$row->qr_code;
            //     // dd($filePath);
            //     return '<img src="'.$filePath.'" height="50px;" width="50px;">
            //             <a href="'.$filePath.'"download="tableQR'.$row->qr_code.'" class="mx-3"><i class="ri-download-line"></i>
            //             </a>';
            // })
            ->addColumn('qr_code', function($row) {
                $filePath = asset('backend/uploads/table-qr-code/' . $row->qr_code);
                return '
                    <img src="' . $filePath . '" height="50px" width="50px" alt="QR Code" onclick="openModal(this.src)">
                    <a href="' . $filePath . '" download="tableQR' . $row->qr_code . '" class="mx-3">
                        <i class="ri-download-line"></i>
                    </a>
                ';
            })
            ->addColumn('status',function($row){
                $checked = $row->status == 1 ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="restaurantTableSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRestaurantTable('.$row->id.')"></i></a></li>
                        <li class="delete ms-1" id="deleteBtn" onclick="deleteRestaurantTable('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['qr_code','status','action'])
            ->make(true);
        }
    }

    public function switchStatus(Request $request){
        $rc_status = Table::where('id',$request->id)->pluck('status');
        $status = $rc_status[0];
        $new_status = 1;
        if($status == 1){
            $new_status = 0;
        }
        Table::where('id',$request->id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }

    public function getTable(Request $request){
        $getData = Table::where('id',$request->id)->get(['id','number','capacity','area','status']);
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData[0]],200);
    }

    public function update(Request $request){  
        Table::where('id',$request->id)->update([
            'number' => $request->number,
            'capacity' => $request->capacity,
            'area' => $request->area,
            'qr_code' => $fileName ?? null

        ]);
        return response()->json(['success' => 'Data Updated Successfully'],200);
    }

    public function delete(Request $request){
        Table::where('id',$request->id)->update([
            'deleted_at' => now(),
        ]);
        return response()->json(['success' => 'Item Attribute Deleted Successfully'],200);
    }
    
    public function breakfastChart(){
        $company = HotlrConfiguration::get(['logo']);
        $reservation_data = ReservationRoom::where('status','Alloted')->get();
        return view('backend.modules.restaurant.breakfast-chart-compliment',compact('reservation_data','company'));
    }

}
