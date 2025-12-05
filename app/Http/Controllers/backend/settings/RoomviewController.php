<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use App\Models\RoomView;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoomviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $roomType_name = RoomView::get();
           
            return DataTables::of($roomType_name)
            ->addIndexColumn()
            // ->addColumn('id',function($row){
            //     return $row->id;
            // })
            ->addColumn('view_name',function($row){
                return $row->view_name;
            })
            ->addColumn('status',function($row){
                $checked = $row->status ==='active' ? 'checked' : ''; // check if status is active then checked
                 return '<div class="flex-grow-1 icon-state switch-outline">
                      <label class="switch mb-0" onchange="roomViewSwitch('.$row->id.')">
                      <input type="checkbox" '.$checked.'><span class="switch-state bg-success"></span>
                      </label>
                    </div>';
            })
            ->addColumn('action',function($row){
                return '<ul class="action"> 
                        <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="editRoomView('.$row->id.')"></i></a></li>
                        <li class="delete ms-1 d-none" id="deleteBtn" onclick="delete_roomView('.$row->id.')"><i class="icon-trash"></i></li>
                        </ul>';
            })
            ->rawColumns(['status','action'])
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
     {   
        $check_roomView_exist = RoomView::where('view_name',$request->room_view)->exists();
        if($check_roomView_exist == false){
                $roomviewdata = $request->room_view;
                $roomview = new RoomView();
                $roomview->view_name = $roomviewdata;
                
                if ($roomview->save()){
                    $response = response()->json(['success'=>'Data addedd successfully'],200);
                } else{
                    $response = response()->json(['error'=>'Data not addedd successfully'],400);
                }
            }else{
                $response = response()->json(['alreadyfound_error' => 'This Room View already found! Enter another...']);
            }
            return $response;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function roomViewSwitch(Request $request){
        $id = $request->id;
        $rc_status = RoomView::where('id',$id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        RoomView::where('id',$id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    public function get_roomViewDetails(Request $request){
        $id = $request->id;
        $getData = RoomView::where('id',$id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData],200);
     }
     public function rooomView_update(Request $request)
     {  
       // dd($request->all());
         $id = $request->id;
         $room_view = $request->room_view;
         RoomView::where('id',$id)->update([
             'view_name' => $room_view
         ]);
        return response()->json(['success' => 'Data Updated Successfully'],200);
     }
     public function rooomView_delete(Request $request)
     {
         $id = $request->id;
         RoomView::where('id',$id)->delete();
         return response()->json(['success' => 'RoomType Name Deleted Successfully'],200);
     }
    
}
