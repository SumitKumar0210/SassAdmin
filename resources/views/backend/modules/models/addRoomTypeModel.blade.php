<div class="modal fade" id="addRoomType" tabindex="-1" role="dialog" aria-labelledby="addRoomType" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-toggle-wrapper  text-start dark-sign-up">
				<div class="modal-header">
					<h4 class="modal-title">Add Room Type</h4>
					<button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
                {{-- <form class="needs-validation custom-input" novalidate=""> --}}
                    <div class="modal-body px-0 px-lg-3">
                        <div class="row gx-0">
                            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 d-none d-sm-block">
                                <ul class="vertical-timeline border-end" id="desktopTimeline">
                                    <li class="step active"> 
                                        <span>1</span>
                                        <h4>General Information</h4> 
                                    </li>
                                    <li class="step"> 
                                        <span>2</span>
                                        <h4>Occupancy</h4> 
                                    </li>
                                    <li class="step"> 
                                        <span>3</span>
                                        <h4>Features</h4> 
                                    </li>
                                    <li class="step"> 
                                        <span>4</span>
                                        <h4>Media</h4> 
                                    </li>
                                    <li class="step"> 
                                        <span>5</span>
                                        <h4>Review and Save</h4> 
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xl-9 col-lg-9 col-md-9 col-sm-12 bg-light text-dark px-lg-4 px-3 py-3 py-lg-0 vertical-scroll" style="max-height:600px; overflow-y:auto;">
                                <!-- Row start -->
                                <div class="row">
                                    <div class="col-12 progress-border-bottom">
                                        <div class="circular-progress" id="mobileProgress">
                                            <svg viewBox="0 0 36 36" class="circular-chart">
                                                <path class="circle-bg" d="M18 2.0845
                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                    a 15.9155 15.9155 0 0 1 0 -31.831"></path>
                                                <path class="circle" stroke-dasharray="25, 100" d="M18 2.0845
                                                    a 15.9155 15.9155 0 0 1 0 31.831
                                                    a 15.9155 15.9155 0 0 1 0 -31.831" style="stroke-dasharray: 20, 100;">
                                                </path>
                                                    <text x="18" y="20.35" class="percentage"><tspan dy="0" class="step-color">1</tspan> <tspan dy="0"> OF </tspan> <tspan dy="0">5</tspan></text>
                                            </svg>
                                            <span style="margin-left: 10px;">
                                                <div id="content-1" class="content active">
                                                    <h4 class="text-uppercase">General Information</h4>
                                                    <p class="text-uppercase">Next <span class="icon-chevron-right1"></span><span class="icon-chevron-right1"></span> Occupancy </p>
                                                </div>
                                                <div id="content-2" class="content">
                                                    <h4 class="text-uppercase">Occupancy</h4>
                                                    <p class="text-uppercase">Next <span class="icon-chevron-right1"></span><span class="icon-chevron-right1"></span> Features</p>
                                                </div>
                                                <div id="content-3" class="content">
                                                    <h4 class="text-uppercase">Features</h4>
                                                    <p class="text-uppercase">Next <span class="icon-chevron-right1"></span><span class="icon-chevron-right1"></span> Media</p>
                                                </div>
                                                <div id="content-4" class="content">
                                                    <h4 class="text-uppercase">Media</h4>
                                                    <p class="text-uppercase">Next <span class="icon-chevron-right1"></span><span class="icon-chevron-right1"></span> Submit and Review </p>
                                                </div>
                                                <div id="content-5" class="content">
                                                    <h4 class="text-uppercase">Submit and Review</h4>
                                                    <p class="text-uppercase">prev <span class="icon-chevron-left1"></span><span class="icon-chevron-left1"></span> General Information</p>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
                            </div>
                            <div class="row">
                                    <div class="col-12">
                                        <div class="form-container">
                                          <form id="addRoomTypeForm" action="" enctype="multipart/form-data" method="POST">
                                             @csrf
                                            <div class="form-content">
                                                <div class="form-step active" id="step1">
                                                    <!-- Form content for Step 1 -->
                                                    <div class="d-none d-sm-block">
                                                        <p class="mb-0">STEP ONE</p>
                                                        <h3 class="text-uppercase">General Information</h3> 
                                                    </div>
                                                    <div class="row form-input-wrapper">
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label" for="rt_room_category">Room Cateory <span class="text-danger">*</span></label>
                                                            <input class="form-control form-control-sm" id="rt_room_category" name="rt_room_category" type="text" onchange="checkinputStep1();" /> 
                                                            {{-- <select class="form-select form-select-sm" id="rt_room_category" name="rt_room_category" required="" onchange="checkinputStep1(); checkRoomTypeName(this.value)" >
                                                                <option value="">Select</option>
                                                                @foreach ($roomCategories as $r_category)
                                                                <option value="{{$r_category->id}}">{{$r_category->room_category}}</option>
                                                                @endforeach
                                                            </select> --}}

                                                        </div>
                                                        {{-- <div class="col-12 mb-3">
                                                            <label class="form-label" for="rt_roomtype_name">Room Type Name <span class="text-danger">*</span></label>
                                                            <select class="form-select form-select-sm" id="rt_roomtype_name" name="rt_roomtype_name" required="" onchange="checkinputStep1();">
                                                                <option value="">Select</option>
                                                                @foreach ($roomTypeName as $r_roomtype)
                                                                <option value="{{$r_roomtype->id}}">{{$r_roomtype->room_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <div class="rt_roomtype_name_class d-none"></div>
                                                        </div> --}}
                                                        <div class="col-12"> 
                                                            <label class="form-label" for="rt_description_guests">Description</label>
                                                            <textarea class="form-control form-control-sm" id="rt_description_guests" name="rt_description_guests" rows="6" placeholder="Add Description" required="" ></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-step" id="step2">
                                                    <!-- Form content for Step 1 -->
                                                    <div class="d-none d-sm-block mb-3 ">           
                                                        <p class="mb-0">STEP TWO</p>
                                                        <h3 class="text-uppercase">Occupancy</h3>
                                                    </div>
                                                    <div class="row form-input-wrapper">
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label mb-2" for="occupancy">Maximum Occupancy <span class="text-danger">*</span></label>
                                                            <div class="touchspin-wrapper"> 
                                                                <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary"><i class="ri-subtract-fill"></i></button>
                                                                <input class="input-touchspin spin-outline-primary mxocc-class" id="rt_maximumOccupancy" name="rt_maximumOccupancy" type="number" value="0">
                                                                <button type="button" class="increment-touchspin btn-touchspin spin-border-primary"><i class="ri-add-fill"></i></button> 
                                                                {{-- here function checkinputStep2() called in increment and decrement for step page validadion is on custom_touchspin.js --}}
                                                            </div>
                                                            <div class="rt_maximumOccupancy_class"></div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label mb-2" for="adults">Maximum Adults <span class="text-danger">*</span></label>
                                                            <div class="touchspin-wrapper"> 
                                                                <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary"><i class="ri-subtract-fill"></i></button>
                                                                <input class="input-touchspin spin-outline-primary" id="rt_maximumAdults" name="rt_maximumAdults" type="number" value="0">
                                                                <button type="button" class="increment-touchspin btn-touchspin spin-border-primary"><i class="ri-add-fill"></i></button>
                                                            </div>
                                                            <div class="rt_maximumAdults_class"></div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label mb-2" for="children">Maximum Children <span class="text-danger">*</span></label>
                                                            <div class="touchspin-wrapper"> 
                                                                <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary" ><i class="ri-subtract-fill"></i></button>
                                                                <input class="input-touchspin spin-outline-primary" id="rt_maximumChildren" name="rt_maximumChildren" type="number" value="0">
                                                                <button type="button" class="increment-touchspin btn-touchspin spin-border-primary"><i class="ri-add-fill"></i></button>
                                                            </div>
                                                            <div class="rt_maximumChildren_class"></div>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label mb-2" for="infants">Maximum Infants <span class="text-danger">*</span></label>
                                                            <div class="touchspin-wrapper"> 
                                                                <button type="button" class="decrement-touchspin btn-touchspin spin-border-primary"><i class="ri-subtract-fill"></i></button>
                                                                <input class="input-touchspin spin-outline-primary" id="rt_maximumInfants" name="rt_maximumInfants" type="number" value="0">
                                                                <button type="button" class="increment-touchspin btn-touchspin spin-border-primary"><i class="ri-add-fill"></i></button>
                                                            </div>
                                                            <div class="rt_maximumInfants_class"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-step" id="step3">
                                                    <div class="d-none d-sm-block mb-3 ">
                                                        <p class="mb-0">STEP THREE</p>
                                                        <h3 class="text-uppercase">Features</h3> 
                                                    </div>
                                                    <div class="row form-input-wrapper">
                                                        <div class="col-6 mb-3">
                                                            <label class="form-label" for="room-category">Room Size <span class="text-danger">*</span></label>
                                                            <div class="input-group">
                                                                <input class="form-control form-control-sm" id="rt_roomsize" name="rt_roomsize" type="number" placeholder="0" onchange="checkinputStep3()"><span class="input-group-text">SQM(m<sup>2</sup>)</span> 
                                                            </div>
                                                        </div>
                                                        <div class="col-6 mb-3">
                                                            <label class="form-label" for="room-category">Bathroom <span class="text-danger">*</span></label>
                                                            <select class="form-select form-select-sm" id="rt_bathroom" name="rt_bathroom" required="" onchange="checkinputStep3()">
                                                                <option value="">Select</option>
                                                                <option value="1">1 </option>
                                                                <option value="2">2</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12 mb-3 ">
                                                            <label class="form-label" for="room-category">Smoking policy <span class="text-danger">*</span></label>
                                                            <section class="main-upgrade ">
                                                                <div class="variation-box  w-100 h-auto border rounded p-2" id="smoking_category">
                                                                    <div class="selection-box w-50 h-auto rounded-0  border">
                                                                        <input id="nonSmokingButton" type="radio" name="smoking-police"  onclick="selectSmokingPolicy('Non-Smoking')" onchange="checkinputStep3()">
                                                                        <div class="custom--mega-checkbox p-1">
                                                                            Non-Smoking
                                                                        </div>
                                                                    </div>
                                                                    <div class="selection-box w-50 h-auto rounded-0  border">
                                                                        <input id="smokingButton" type="radio" name="smoking-police" onclick="selectSmokingPolicy('Smoking')" onchange="checkinputStep3()">
                                                                        <div class="custom--mega-checkbox p-1">
                                                                            Smoking
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </section>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label d-block" for="rt_roomview">Room View <span class="text-danger">*</span></label>
                                                            <select class="selectpicker form-control form-control-sm" id="rt_roomview" name="rt_roomview[]" data-live-search="true" data-live-search-placeholder="Search" multiple title="Select Room View" required="" onchange="checkinputStep3()">
                                                                @foreach ($roomView as $r_view)
                                                                <option value="{{$r_view->id}}">{{$r_view->view_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-12 mb-3">
                                                            <label class="form-label" for="rt_aminities_facilities">Aminities and facilities <span class="text-danger">*</span></label>
                                                            <select class="selectpicker form-control form-control-sm" id="rt_aminities_facilities" name="rt_aminities_facilities[]" data-live-search="true" data-live-search-placeholder="Search" multiple title="Select Aminities and Facilities" required="" onchange="checkinputStep3()">
                                                                @foreach ($facility_amenities as $r_facility_amenities)
                                                                <option value="{{$r_facility_amenities->id}}">{{$r_facility_amenities->facilities}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                             <label class="form-label" for="bedType">Bed type configuration <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-12 mb-1 bedtype-container">
                                                            <div class="p-3 bg-white border rounded">
                                                                <div id="bedSizeContainer" class="bedsize-container d-none">
                                                                    <div class="d-flex justify-content-between align-items-center mb-2 rounded-touchspin">
                                                                        <h5 class="mb-0" id="bedTypeSelected"></h5>
                                                                        <div class="d-flex justify-content-between align-items-center">
                                                                            <div class="touchspin-wrapper"> 
                                                                                <button type="button" class="decrement-touchspin btn-touchspin touchspin-primary"><i class="icon-minus"></i></button>
                                                                                <input class="input-touchspin spin-outline-primary" id="rt_bedType_count" name="rt_bedType_count[]" type="number" value="1" onchange="checkinputStep3()">
                                                                                <button type="button" class="increment-touchspin btn-touchspin touchspin-primary"><i class="icon-plus"></i>
                                                                                </button>
                                                                            </div>
                                                                            {{-- <a href="javascript:void(0)" class="text-danger mb-0 ms-3" onclick="removeBedSize(this)">Delete</a> --}}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <select class="form-select form-select-sm" id="bedType" name="bedType[]" required="" onchange="checkinputStep3()">
                                                                    <option value="" selected="">Add bed type</option>
                                                                    @foreach ($bedType as $r_bedtype)
                                                                <option value="{{$r_bedtype->id}}">{{$r_bedtype->bedtype}}</option>
                                                                @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-1 bedroom-container" id="bedroom-container"></div>
                                                        <div class="col-12 mb-3 mt-2">
                                                            <div class="add-extra-room">
                                                                <a href="javascript:void(0)" class="btn btn-primary px-2 add_bedroom" type="button" id="add_bedrooms" onclick="addroom()"> 
                                                                    <span class="btn-icon"><i data-feather="plus"></i></span> Add Bedroom
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-step" id="step4">
                                                    <!-- Form content for Step 3 -->
                                                    <div class="d-none d-sm-block ">
                                                        <p class="mb-0">STEP FOUR</p>
                                                        <h3 class="text-uppercase">Media</h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="dropzone dropzone-secondary" id="myDropzone" required="" >
                                                              <div class="dz-message needsclick" onclick="checkinputStep4()">
                                                                 <i class="icon-cloud-up"></i>
                                                                 <h4 class="f-w-700">Drop files here or click to upload.</h4>
                                                                <span class="note needsclick">(Selected files are <strong>actually</strong> uploaded.)</span>
                                                             </div>
                                                           </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <div class="form-step" id="step5">
                                                    <!-- Form content for Step 5 -->
                                                    <div class="d-none d-sm-block ">
                                                        <p class="mb-0">STEP FIVE</p>
                                                        <h3 class="text-uppercase">Review and Save</h3>
                                                    </div>
                                                    <div class="rt_preview_data"></div>
                                                </div>
                                            </div>
                                           
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Row end -->
                        </div>
                    </div>  

                    <div class="modal-footer">
                        <button type="button" id="prevBtn" class="btn btn-outline-secondary mx-2" onclick="prevStep()" style="display: none;"><span class="icon-chevron-left1 align-middle"></span> Back</button>
                        <button type="button" id="nextBtn" class="btn btn-primary mx-2 disabled" onclick="nextStep()"  style="display: block;">Next <span class="icon-chevron-right1 align-middle"></span></button>
                        <button type="button" id="submitBtn" class="btn btn-primary mx-2 roomTypeSubmitBtn" style="display: none;">Submit</button>
                        <button class="btn btn-primary roomTypeSubmitSpinn d-none" type="button">
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            <span role="status">Please Wait...</span>
                        </button>
                    </div>
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>