<?php

namespace App\Http\Controllers\backend\settings;

use App\Http\Controllers\Controller;
use App\Models\FacilitieAmenitie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class FacilitiesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $facilitiesAmenities = FacilitieAmenitie::get();
            //dd($bedTypeData);
            return DataTables::of($facilitiesAmenities)
                ->addIndexColumn()
                ->addColumn('image_icon', function ($row) {
                    return '<img src="backend/uploads/facilitiesAmenities/' . $row->image_icon . '" height="50px" width="60px">';
                })
            
                ->addColumn('facilities', function ($row) {
                    return $row->facilities;
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status === 'active' ? 'checked' : ''; // check if status is active then checked
                    return '<div class="flex-grow-1 icon-state switch-outline">
                              <label class="switch mb-0" onchange="facilities_switch(' . $row->id . ')">
                              <input type="checkbox" ' . $checked . '><span class="switch-state bg-success"></span>
                              </label>
                            </div>';
                })
                ->addColumn('action', function ($row) {
                    return '<ul class="action">
                            <li class="edit"> <a href="#"><i class="icon-pencil-alt" onclick="edit_facilities(' . $row->id . ')"></i></a></li>
                            <li class="delete ms-1 d-none" id="deleteBtn" onclick="delete_facilities(' . $row->id . ')"><i class="icon-trash"></i></li>
                            </ul>';
                })
                ->rawColumns(['image_icon','status', 'action'])
                ->make(true);
        }
    }
    
    public function store(Request $request)
    {
        $check_faciAme_exist = FacilitieAmenitie::where('facilities',$request->facilities)->exists();
        if($check_faciAme_exist == false){     
                $facilitiesdata = $request->facilities;
                $facilities_imagedata = $request->file('facilities_image');
                $facilitiesAme = new FacilitieAmenitie();
                $facilitiesAme->facilities = $facilitiesdata;
                
                if ($facilities_imagedata) {
                    // Define your file path and name
                    $imageName = time() . '.' . $facilities_imagedata->getClientOriginalExtension();
                    $destinationPath = public_path('/backend/uploads/facilitiesAmenities');
                    
                    // Move the file to the destination path
                    $facilities_imagedata->move($destinationPath, $imageName);
                    
                    // Save the image path in your database
                    $facilitiesAme->image_icon = $imageName;
                }
                
                if ($facilitiesAme->save()) {
                    return response()->json(['success' => 'Data added successfully'], 200);
                } else {
                    return response()->json(['error' => 'Data not added successfully'], 400);
                }
            }else{
                $response = response()->json(['alreadyfound_error' => 'This Facilities & Amenities already found! Enter another...']);
            }
            return $response;
          
    }
    
    public function facilities_switch(Request $request){
        $id = $request->id;
        $rc_status = FacilitieAmenitie::where('id',$id)->get(['status']);
        $status = $rc_status[0]->status;
        if($status === 'active'){
            $new_status = 'inactive';
        }
        else{
            $new_status = 'active';
        }
        FacilitieAmenitie::where('id',$id)->update([
            'status' => $new_status
        ]);
        return response()->json(['success' => 'Status Updated Successfully'],200);
    }
    public function get_facilitiesdetails(Request $request){
        $id = $request->id;
        $getData = FacilitieAmenitie::where('id',$id)->get();
        return response()->json(['success' => 'Data Fetched Successfully','getData'=>$getData],200);
     }
     public function facilities_update(Request $request)
     {  
       //  dd($request->all());
         $id = $request->id;
         $facilities1 = $request->facilities;
     
         // Update the facilities
         FacilitieAmenitie::where('id', $id)->update([
             'facilities' => $facilities1
         ]);
     
         $facilities_img = $request->file('facilities_image');
         if ($facilities_img) {
             $facilityAmenity = FacilitieAmenitie::find($id); // Get the existing record
              
             // Define your file path and name
             $imageName = time() . '.' . $facilities_img->getClientOriginalExtension();
             $destinationPath = public_path('/backend/uploads/facilitiesAmenities');
     
             // Delete the old image if it exists
             $oldImage = $facilityAmenity->image_icon;
             // dd($oldImage);
             if (File::exists($destinationPath . '/' . $oldImage)) {
                 File::delete($destinationPath . '/' . $oldImage);
             }
     
             // Move the new file to the destination path
             $facilities_img->move($destinationPath, $imageName);
     
             // Save the new image path in your database
             $facilityAmenity->image_icon = $imageName;
             $facilityAmenity->save();
         }
     
         return response()->json(['success' => 'Data Updated Successfully'], 200);
     }
     
     public function facilities_delete(Request $request)
     {
        $id = $request->id;
            // Find the record
            $facilityAmenity = FacilitieAmenitie::find($id);
        
            if ($facilityAmenity) {
                // Define the file path
                $filePath = public_path('backend/uploads/facilitiesAmenities/' . $facilityAmenity->image_icon);
        
                // Check if the file exists
                if (File::exists($filePath)) {
                    // Delete the file
                    File::delete($filePath);
                }
        
                // Delete the record
                $facilityAmenity->delete();
        
                return response()->json(['success' => 'Record and image deleted successfully'], 200);
            } else {
                return response()->json(['error' => 'Record not found'], 404);
            }
       
     }
}
