<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width:30%">
    <div class="offcanvas-header border-bottom position-relative">
        <h5 id="offcanvasRightLabel">Edit Room Type</h5>
        <button type="button" class="btn-close text-reset " data-bs-dismiss="offcanvas" aria-label="Close" ></button>
    </div>
    <div class="offcanvas-body">
        <!--start Form  Step 1 -->
        <div class="general-section" >
            <h5 class="text-uppercase mb-3">General Information</h5> 
            <div class="form-input-wrapper">
                <div class=" mb-3">
                    <input type="hidden" id="roomtypeEdit_id">
                    <label class="form-label" for="rte_room_category">Room Cateory <span class="text-danger">*</span></label>
                    <input type="text"  class="form-control form-control-sm" id="rte_room_category" required="" onchange="checkRoomTypeValidEdit()" />
                </div>
                <div class=""> 
                    <label class="form-label" for="description-guests">Description</label>
                    <textarea class="form-control form-control-sm" id="rte_description" rows="4" placeholder="Add Description" required=""></textarea>
                </div>
            </div>   
        </div>
        <!--end Form  Step 1 -->
        <!--start Form  Step 2 -->
        <div class="occupancy-section" >                                               
            <div class="d-none d-sm-block mb-3 mt-4 "> 
                <h5 class="text-uppercase">Occupancy</h5>
            </div>
            <div class="form-input-wrapper">
                <div class="mb-3">
                    <label class="form-label mb-2" for="occupancy">Maximum Occupancy <span class="text-danger">*</span></label>
                    <div class="touchspin-wrapper"> 
                        <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary d-flex align-items-center justify-content-center" onclick="changeValue(this, -1)"><i class="icon-minus"></i></button>
                        <input class="input-touchspin spin-outline-primary" type="number" value="0" id="rte_max_occupancy">
                        <button type="button" class="increment-touchspin btn-touchspin spin-border-primary d-flex align-items-center justify-content-center" onclick="changeValue(this, 1)"><i class="icon-plus"></i></button>
                    </div>
                    <div class="rte_max_occupancy_class"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-2" for="adults">Maximum Adults <span class="text-danger">*</span></label>
                    <div class="touchspin-wrapper"> 
                        <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary d-flex align-items-center justify-content-center" onclick="changeValue(this, -1)"><i class="icon-minus"></i></button>
                        <input class="input-touchspin spin-outline-primary" type="number" value="0" id="rte_max_adult">
                        <button type="button" class="increment-touchspin btn-touchspin spin-border-primary d-flex align-items-center justify-content-center" onclick="changeValue(this, 1)"><i class="icon-plus"></i></button>
                    </div>
                    <div class="rte_max_adult_class"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-2" for="children">Maximum Children</label>
                    <div class="touchspin-wrapper"> 
                        <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary d-flex align-items-center justify-content-center" onclick="changeValue(this, -1)"><i class="icon-minus"></i></button>
                        <input class="input-touchspin spin-outline-primary" type="number" value="0" id="rte_max_child">
                        <button type="button" class="increment-touchspin btn-touchspin spin-border-primary d-flex align-items-center justify-content-center" onclick="changeValue(this, 1)"><i class="icon-plus"></i></button>
                    </div>
                    <div class="rte_max_child_class"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label mb-2" for="infants">Maximum Infants</label>
                    <div class="touchspin-wrapper"> 
                        <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary d-flex align-items-center justify-content-center" onclick="changeValue(this, -1)"><i class="icon-minus"></i></button>
                        <input class="input-touchspin spin-outline-primary" type="number" value="0" id="rte_max_infant">
                        <button type="button" class="increment-touchspin btn-touchspin spin-border-primary d-flex align-items-center justify-content-center" onclick="changeValue(this, 1)"><i class="icon-plus"></i></button>
                    </div>
                   <div class="rte_max_infant_class"></div>
                </div>
            </div>
        </div>
        <!--end Form  Step 2 -->
        <!--start Form  Step 3 -->
        <div class="features-section" >
            <div class="d-none d-sm-block mb-3 mt-4">
                <h5 class="text-uppercase">Features</h5> 
            </div>
            <div class="row form-input-wrapper">
                <div class=" mb-3">
                    <label class="form-label" for="rte_roomsize">Room Size <span class="text-danger">*</span></label>
                    <div class="input-group">
                    <input class="form-control form-control-sm" id="rte_roomsize" type="text" placeholder="0"><span class="input-group-text" style="font-size:12px">SQM(m<sup>2</sup>)</span> </div>
                </div>
                <div class=" mb-3">
                    <label class="form-label" for="rte_bathroom">Bathroom <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm" id="rte_bathroom" required="">
                        <option value="">Select</option>
                        <option value="1" {{$roomTypedata[0]->batyhroom ?? '' == 1 ?'selected':''}}>1 </option>
                        <option value="2" {{$roomTypedata[0]->batyhroom ??'' == 2 ?'selected':''}}>2</option>
                    </select> 
                 </div>
                <div class=" mb-3 ">
                    <label class="form-label" for="room-category">Smoking policy.<span class="text-danger">*</span></label>
                    <section class="main-upgrade">
                        <div class="variation-box  w-100 h-auto border rounded p-2" id="rte_smoking_policy">
                            <div class="selection-box w-50 h-auto rounded-0  border">
                                <input id="edit-non-smoking" type="radio" name="smoking-police">
                                <div class="custom--mega-checkbox p-1">
                                    Non-Smoking
                                </div>
                            </div>
                            <div class="selection-box w-50 h-auto rounded-0  border">
                                <input id="edit-smoking" type="radio" name="smoking-police">
                                <div class="custom--mega-checkbox p-1">
                                    Smoking
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="mb-3">
                    <label class="form-label d-block" for="rte_roomview">Room View <span class="text-danger">*</span></label>
                    <select class="selectpicker form-control form-control-sm" data-live-search="true" id="rte_roomview" name="rte_roomview[]" data-live-search-placeholder="Search" multiple title="Select Room View">
                        @foreach ($roomView as $r_view)
                        <option value="{{$r_view->id}}">{{$r_view->view_name}}</option>
                        @endforeach
                    </select>
                </div>
                <div class=" mb-3">
                    <label class="form-label" for="rte_facilities">Aminities and facilities <span class="text-danger">*</span></label>
                    <select class="selectpicker form-control form-control-sm" data-live-search="true" data-live-search-placeholder="Search" multiple title="Select Room Amenities & Facilities" id="rte_facilities" name="rte_facilities[]">
                        @foreach ($facility_amenities as $r_facility_amenities)
                        <option value="{{$r_facility_amenities->id}}">{{$r_facility_amenities->facilities}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <label class="form-label" for="bedType">Bed type configuration <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 mb-1 bedtype-container edit-bedtype-container"></div>
                <div class="col-12 mb-3 mt-2">
                    <div class="add-extra-room">
                        <a href="javascript:void(0)" class="btn btn-primary px-2 add_bedroom" type="button" id="add_bedrooms" onclick="addroom(1)"> 
                            <span class="btn-icon"><i data-feather="plus"></i></span> Add Bedroom
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--end Form  Step 3 -->
        <!--start Form  Step 4 -->
        <div class="media-section">
            <div class="d-none d-sm-flex align-items-center justify-content-between mb-3 mt-4">
                <h5 class="text-uppercase">Media</h5>
                <button class="btn btn-light" type="button" data-bs-toggle="modal" data-bs-target="#assigning"><span class="btn-icon"><i data-feather="plus"></i></span> Assigning from media library</button>
            </div>
           
            <ul class="p-4 assign-gallery">
                <!--------Append Image here in imageEditDIV class through js------------>
                <div class="imageEditDIV"></div>
              
            </ul>
          
        </div>
        <!--end Form  Step 4 -->
    </div>
    <div class="offcanvas-footer d-flex">
        <button type="button" class="btn btn-danger w-50 btn-square py-2" data-bs-dismiss="offcanvas" aria-label="Close">Cancel</button>
        <button type="button" class="btn btn-primary  w-50  btn-square py-2 roomtype_edit_btn" onclick="roomtype_edit_submit(document.getElementById('roomtypeEdit_id').value)">Submit</button>
    </div>
</div>