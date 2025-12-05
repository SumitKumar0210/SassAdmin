<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\BedType;
use App\Models\FacilitieAmenitie;
use App\Models\HotlrConfiguration;
use App\Models\RoomBedConfiguration;
use App\Models\RoomCategory;
use App\Models\RoomType;
use App\Models\RoomTypeName;
use App\Models\RoomtypeImage;
use App\Models\RoomView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log; // Import the Log facade

class RoomtypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomTypedata = RoomType::get();
        $roomTypedataCount = RoomType::count();
        $roomView = RoomView::where('status','active')->get();
        $facility_amenities = FacilitieAmenitie::where('status','active')->get();
        $bedType = BedType::where('status','active')->get();
        $hotlr = HotlrConfiguration::get(['logo','name']);
        return view('backend.modules.settings.roomtype',compact('roomTypedata','roomTypedataCount','roomView','facility_amenities','bedType','hotlr'));
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
    public function store(Request $request){
        // 
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

    public function dataimagesUpload(Request $request) {
       
        $roomCategory = $request->input('rt_room_category');
        $check_type = RoomType::where('room_category',$roomCategory)->whereNull('deleted_at')->count();
        if($check_type == 0){
            // Collect the data from the request
            $descriptionGuests = $request->input('rt_description_guests');
            $maximumOccupancy = $request->input('rt_maximumOccupancy');
            $maximumAdults = $request->input('rt_maximumAdults');
            $maximumChildren = $request->input('rt_maximumChildren');
            $maximumInfants = $request->input('rt_maximumInfants');
            $roomSize = $request->input('rt_roomsize');
            $bathroom = $request->input('rt_bathroom');
            $smoking_category = $request->input('rt_smoking_category');
            $roomView = $request->input('rt_roomview');
            $aminitiesFacilities = $request->input('rt_aminities_facilities');
            
            DB::beginTransaction();
            try{
                $roomtype = new RoomType();
                $roomtype->room_category	 = $roomCategory;
                $roomtype->description = $descriptionGuests;
                $roomtype->max_occupancy = $maximumOccupancy;
                $roomtype->max_adult = $maximumAdults;
                $roomtype->max_child = $maximumChildren;
                $roomtype->max_infant = $maximumInfants;
                $roomtype->room_size = $roomSize;
                $roomtype->bathroom = $bathroom;
                $roomtype->smoking_category = $smoking_category;
                $roomtype->room_view = $roomView;
                $roomtype->ami_facilities = $aminitiesFacilities;
                // $roomtype->room_category_types = $room_category_types;
                if($roomtype->save()) {
        
                    if ($request->hasFile('file')) {
                        foreach ($request->file('file') as $file) {
                            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                            $destinationPath = public_path('/backend/uploads/RoomType');
                            // Move the new file to the destination path
                            $file->move($destinationPath, $filename);
                            // Create a new RoomTypeImage for each uploaded file
                            $roomTypeImage = new RoomtypeImage();
                            $roomTypeImage->roomtype_id = $roomtype->id;
                            $roomTypeImage->file_name = $filename;
                            $roomTypeImage->file_path = '/backend/uploads/RoomType/' . $filename;
                            $roomTypeImage->save();
                        }
                    }
        
                    $bedConfig = json_decode($request->bedConfig);
                    foreach($bedConfig as $config){
                        $roomBed = new RoomBedConfiguration();
                        $roomBed->roomtype_id = $roomtype->id;
                        $roomBed->bed_type = $config->bed_type;
                        $roomBed->no_of_bed = $config->count;
                        $roomBed->save();
                    }
        
                    return response()->json(['status' => 'success', 'message' => 'Room Type Added Successfully']);
                } else {
                    return response()->json(['status' => 'error', 'message' => 'Room Type Not Added']);
                }
            
                DB::commit(); // data saved in both the table successfullt.
                return response()->json(['success' => 'Room Type Added Successfully'], 200);
            } catch (\Exception $e) {
                DB::rollBack(); // if date not saved in both table then both table rollback as before.
                return response()->json(['error_success' => 'Error! Data not added', 'message' => $e->getMessage()], 500);
            }

        }else{
           return response()->json(['status' => 'error', 'message' => 'Room Type Already Exists']);
        }
    }

    public function getDetails(Request $request) {

        $roomType = RoomType::where('id', $request->id)->get();
        $room_beds = [];
        $room_beds_config = RoomBedConfiguration::where('roomtype_id',$request->id)->where('status',1)->get();
        foreach($room_beds_config as $config){
            $room_beds[] = [
                'id' => $config['id'],
                'bed_type_id' => $config['bed_type'],
                'bed_type' => optional($config->bedConfig)->bedtype ?? '',
                'no_of_bed' => $config['no_of_bed'],
                'roomtype_id' => $config['roomtype_id'],
            ];
        }
        $roomTypeImages = RoomtypeImage::where('roomtype_id', $request->id)->get();
        return response()->json(['status' => 'success', 'roomType' => $roomType, 'roomTypeImages' => $roomTypeImages,'room_beds' => $room_beds]);

    }

    public function delete_roomtype(Request $request){
        
        RoomType::where('id',$request->id)->delete();
        RoomtypeImage::where('roomtype_id',$request->id)->delete();
        return response()->json(['success'=>'Room Type Deleted Successfully'],200);

    }

    public function dataimagesEditUpload(Request $request){
        $id = $request->input('imgUploadID');
      
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $filename1 = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path('/backend/uploads/RoomType');
                // Move the new file to the destination path
                $file->move($destinationPath, $filename1);
                // Create a new RoomTypeImage for each uploaded file
                $roomTypeImage = new RoomtypeImage();
                $roomTypeImage->roomtype_id =  $id;
                $roomTypeImage->file_name = $filename1;
                $roomTypeImage->file_path = '/backend/uploads/RoomType/' . $filename1;
                $roomTypeImage->save();
            }
        }

        return response()->json(['status' => 'success', 'message' => 'Image Added Successfully','uploadedImages'=>$roomTypeImage]);
    }

    public function delete_roomtypeImage(Request $request){

        $roomtypedata = RoomtypeImage::where('id', $request->imgID)->get();
        $destinationPath = public_path('/backend/uploads/RoomType');
        // Debug: Log the file path
        Log::info("Deleting image at path: " . $destinationPath);
        // Delete the old image if it exists
        $oldImage = $roomtypedata[0]->file_name;
        
        if (File::exists($destinationPath . '/' . $oldImage)) {
            Log::info("File exists: " . $destinationPath .'/'. $oldImage);
            File::delete($destinationPath . '/' . $oldImage);
            Log::info("File deleted: " . $destinationPath .'/'. $oldImage);
        
        } else {
            Log::warning("File not found: " .$destinationPath .'/'. $oldImage);
        }

        RoomtypeImage::where('id', $request->imgID)->delete();
        
        return response()->json(['success' => 'Image Deleted Successfully'], 200);
    }

    public function update_edit(Request $request){    
        
        RoomType::where('id',$request->id)->update([

            'room_category' =>  $request->rte_room_category,
            'description' => $request->rte_description,
            'max_occupancy' => $request->rte_max_occupancy,
            'max_adult' => $request->rte_max_adult,
            'max_child' => $request->rte_max_child,
            'max_infant' => $request->rte_max_infant,
            'room_size' => $request->rte_roomsize,
            'bathroom' => $request->rte_bathroom,
            'smoking_category'=> $request->rte_smoking_policy,
            'room_view'=> implode(',', $request->rte_roomview),
            'ami_facilities'=> implode(',', $request->rte_facilities)

        ]);

        RoomBedConfiguration::where('roomtype_id',$request->id)->update([
            'status' => 0
        ]);

        $bedConfig = json_decode($request->bedConfig);
        foreach($bedConfig as $config){
            if($config->bed_type != ""){
                $chkRoomBed = RoomBedConfiguration::where('roomtype_id',$request->id)->where('bed_type',$config->bed_type)->count();
                if($chkRoomBed > 0){
                    RoomBedConfiguration::where('roomtype_id',$request->id)->where('bed_type',$config->bed_type)->update([
                        'no_of_bed' => $config->count,
                        'status' => 1
                    ]);
                }else{
                    $roomBed = new RoomBedConfiguration();
                    $roomBed->roomtype_id = $request->id;
                    $roomBed->bed_type = $config->bed_type;
                    $roomBed->no_of_bed = $config->count;
                    $roomBed->save();
                }
            }
        }

        RoomBedConfiguration::where('roomtype_id',$request->id)->where('status',0)->update([
            'deleted_at' => now()
        ]);

        return response()->json(['success' => 'Data Updated Successfully'],200);
    }
    
    public function checkRoomType(Request $request){

        $roomCId = $request->roomCateID;
        $roomTId = $request->roomTypeID;
        $roomtypeData = RoomType::where('room_category_id',$roomCId)->where('roomtype_name_id',$roomTId)->get();

        return response()->json(['success'=>'Room Type Data Fetched','checkRoomType'=>$roomtypeData],200);

    }

    public function availableRoomCategory(){

        $roomCategories = RoomCategory::where('status','active')->get();
        $roomTypeName = RoomTypeName::where('status','active')->get();
        $roomCategoryList = [];
        foreach($roomCategories as $cate){
            $typeName = [];
            foreach($roomTypeName as $name){
                $roomtype_chk = RoomType::where('room_category_id',$cate['id'])->where('roomtype_name_id',$name['id'])->count();
                if($roomtype_chk == 0){
                    $typeName[] =[
                        'id' => $name['id'],
                        'name' => $name['room_name']
                    ];
                }
            }
            if(count($typeName) > 0){
                $roomCategoryList[] =[
                    'id' => $cate['id'],
                    'name' => $cate['room_category'],
                    'type' => $typeName
                ];
            }
        }

        return response()->json(['success'=>'Room Type Data Fetched','roomCategoryList'=>$roomCategoryList],200);
    }
    
}
