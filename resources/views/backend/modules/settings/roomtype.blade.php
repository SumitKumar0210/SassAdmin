@extends('backend.layouts.main')
@section('title','Setting Room Type')
@section('main-container')
@section('extra-css')
 <style>
 .btn-primary.disabled, .btn-primary:disabled {
    background-color: #d2d2d2 !important;
    border-color: #969f9f !important;
    color: #000;
}
</style>
 @endsection
    <div class="page-body">
        <div class="container-fluid py-3">
            <div class="email-wrap bookmark-wrap">
                <div class="row">
                    <div class="col-xl-12 col-md-12 box-col-12">
                        <div> 
                            @include('backend.layouts.sidebar_master')
                        </div>
                        <div style="padding-left:220px;">
                            <div class="container-fluid">
                                <div class="page-title">
                                    <div class="row">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="col-12 col-sm-6 p-0">
                                                <h3>Room Type ({{$roomTypedataCount ?? 0}})</h3>
                                            </div>
                                            @if(in_array('Setting Add', (explode(',',auth()->user()->permission))))
                                                <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#addRoomType" onclick="getAvailableRoomType()"><i class="icon-plus me-1" style="font-size:12px"></i> Add Room Type</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="container-fluid">
                                    <div class="row mb-3">
                                        @php
                                            $getroomView = [];
                                            $getroomAminitiynFacility = [];
                                        @endphp
                                        @foreach ($roomTypedata as $roomtype)
                                            @php
                                                $room_beds_detail = '';
                                                $room_beds = '';
                                                $beds = App\Models\RoomBedConfiguration::where('roomtype_id', $roomtype->id)->get(['bed_type','no_of_bed']);
                                                if(count($beds) > 0){
                                                    foreach($beds as $bed){
                                                        $beds_name = App\Models\BedType::where('id', $bed['bed_type'])->value('bedtype');
                                                        $room_beds .= $beds_name.',';
                                                        $room_beds_detail = $beds_name.'-'.$bed['no_of_bed'].'/';
                                                    }
                                                }else{
                                                    $room_beds = $roomtype->bed_type;
                                                }
                                            @endphp
                                            <div class="col-sm-12 p-0 mb-3">
                                                <div class="room-type-wrapper d-flex  border border-radius-4 position-relative overflow-hidden">
                                                    <div class="room-type-toggle text-center">
                                                        <h4><i class="icofont icofont-thin-down"></i></h4>
                                                    </div>
                                                    <div class="room-type-description border-start">
                                                        <h4 class="mb-2 ">{{$roomtype->room_category}} <button class="btn btn-primary ms-2" type="button" data-bs-toggle="modal" data-bs-target="#RoomNumber" onclick="getRoomNumberCategory({{$roomtype->id}})"><i class="icon-plus me-1" style="font-size:12px"></i> Room</button></h4>
                                                        <p class="mb-0 d-sm-block d-none">{{$roomtype->description}}</p>
                                                            <ul class="list-items d-sm-block d-none">
                                                                <li class="list-item"><span class="me-2"><i class="icofont icofont-hotel"></i></span>{{rtrim($room_beds, ", ")}}</li>
                                                                <li class="list-item"><span class="me-2"><i class="icofont icofont-bathtub"></i></span>{{$roomtype->bathroom}} Bath</li>
                                                                <li class="list-item"><span class="me-2"><i class="icofont icofont-map"></i></span>{{$roomtype->room_size}} SQM</li>
                                                                <li class="list-item"><span class="me-2"><i class="icofont icofont-users"></i></span> {{$roomtype->max_adult}} adults, {{$roomtype->max_child}} children {{$roomtype->max_infant}} infants</li>
                                                                <li class="list-item"><span class="me-2"><i class="icofont icofont-5-star-hotel"></i></span> {{$roomtype->room_category}}</li>
                                                                @if($roomtype->smoking_category == 'Non-Smoking')
                                                                    <li class="list-item"><span class="me-2"><i class="icofont icofont-no-smoking"></i></span> {{$roomtype->smoking_category}}</li>
                                                                @else
                                                                    <li class="list-item"><span class="me-2"><i class="fa-solid fa-smoking"></i></span> {{$roomtype->smoking_category}}</li>
                                                                @endif
                                                                {{-- <li class="list-item"><span class="me-2"><i class="icofont icofont-5-star-hotel"></i></span> {{$roomtype->room_view}} views</li> --}}
                                                                @php
                                                                $roomViewIds = explode(',', $roomtype->room_view);
                                                                $amanititysIds = explode(',', $roomtype->ami_facilities);
                                                                @endphp
                                                                <li class="list-item"><span class="me-2"><i class="icofont icofont-eye"></i></span>
                                                                @foreach ($roomViewIds as $roomViewid)
                                                                    @php
                                                                        $roomView22 = App\Models\RoomView::where('id', $roomViewid)->first(['view_name']);
                                                                        if ($roomView22 && isset($roomView22->view_name)) {
                                                                            // Only push valid view names to the array
                                                                            array_push($getroomView, $roomView22->view_name);
                                                                        }
                                                                    @endphp
                                                                @endforeach
                                                                @php
                                                                    $get_roomView = implode(", ", $getroomView); // Join array values into a string
                                                                    $roomViewCount = count($getroomView); // Count the number of room views
                                                                    $getroomView = [];
                                                                @endphp
                                                                {{$roomViewCount}} View
                                                                </li>
                                                                <li class="list-item"><span class="me-2"><i class="icofont icofont-snow"></i></span>
                                                                @foreach ($amanititysIds as $amanity)
                                                                    @php
                                                                        $amanity22 = App\Models\FacilitieAmenitie::where('id', $amanity)->first(['facilities']);
                                                                        if ($amanity22 && isset($amanity22->facilities)) {
                                                                            // Only push valid view names to the array
                                                                            array_push($getroomAminitiynFacility, $amanity22->facilities);
                                                                        }
                                                                    @endphp
                                                                @endforeach
                                                                @php
                                                                    $get_facility = implode(", ", $getroomAminitiynFacility); // Join array values into a string
                                                                    $facilityCount = count($getroomAminitiynFacility); // Count the number of room Facility
                                                                    $getroomAminitiynFacility = [];
                                                                @endphp
                                                                    {{$facilityCount}} Facility
                                                            </li>
                                                            </ul>
                                                    </div>
                                                    <div class="d-sm-block d-none">                     
                                                        <div class="room-type-gallery">
                                                                @php
                                                                    $roomtypeimages = App\Models\RoomtypeImage::where('roomtype_id', $roomtype->id)->get();
                                                                @endphp
                                                                @foreach ($roomtypeimages as $roomtypeimage)
                                                                    <div><figure><img class="img-thumbnail" src="/backend/uploads/RoomType/{{ $roomtypeimage->file_name }}" itemprop="thumbnail" alt="Image description"></figure></div>
                                                                @endforeach    
                                                        </div> 
                                                    </div>       
                                                    <div class="dropdown action-btn">
                                                        <button class="btn btn-light active btn-sm txt-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <i class="ri-more-fill"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <li><a class="dropdown-item" data-bs-toggle="offcanvas" href="#offcanvasRight" role="button" aria-controls="offcanvasRight" onclick="getroomTypeDetails({{$roomtype->id}})"><span class="font-info"><i class="icon-pencil-alt"></i></span> Edit Room Type</a></li>
                                                            {{-- <li><a class="dropdown-item" onclick="delete_roomtype({{$roomtype->id}})"><span class="font-danger"><i class="icon-trash"></i></span> Delete Room Type</a></li> --}}
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="room-type-toggle-container border  border-radius-4" style="display:none;border-top:none !important;">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-md-6 col-sm-12 d-sm-none d-block">
                                                            <p class="mb-0 ">{{$roomtype->description}}</p>
                                                            <ul class="list-items mb-2">
                                                                <li><span class="me-2"><i class="icofont icofont-hotel"></i></span>{{$roomtype->bed_type}}</li>
                                                                <li><span class="me-2"><i class="icofont icofont-bathtub"></i></span>{{$roomtype->bathroom}} Bath</li>
                                                                <li><span class="me-2"><i class="icofont icofont-map"></i></span>{{$roomtype->room_size}} SQM</li>
                                                                <li><span class="me-2"><i class="icofont icofont-users"></i></span> {{$roomtype->max_adult}} adults, {{$roomtype->max_child}} children {{$roomtype->max_infant}} infants</li>
                                                                <li><span class="me-2"><i class="icofont icofont-5-star-hotel"></i></span> {{$roomtype->room_category}}</li>
                                                                @if($roomtype->smoking_category == 'Non-Smoking')
                                                                    <li><span class="me-2"><i class="icofont icofont-no-smoking"></i></span> {{$roomtype->smoking_category}}</li>
                                                                @else
                                                                    <li><span class="me-2"><i class="fa-solid fa-smoking"></i></span> {{$roomtype->smoking_category}}</li>
                                                                @endif
                                                                <li><span class="me-2"><i class="icofont icofont-5-star-hotel"></i></span>
                                                                    @foreach ($roomViewIds as $roomViewid)
                                                                    @php
                                                                        $roomView22 = App\Models\RoomView::where('id', $roomViewid)->first(['view_name']);
                                                                    @endphp
                                                                    {{$roomView22->view_name ??''}}
                                                                    @endforeach
                                                                </li>
                                                                <li><span class="me-2"><i class="icofont icofont-5-star-hotel"></i></span>
                                                                    @foreach ($amanititysIds as $ame)
                                                                    @php
                                                                    $facilitiesame = App\Models\FacilitieAmenitie::where('id', $ame)->first(['facilities']);
                                                                    @endphp
                                                                    {{$facilitiesame->facilities ??''}}
                                                                    @endforeach
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <tr>
                                                                        <th colspan="2">Occupancy</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Maximum Occupancy:</td>
                                                                        <td>{{$roomtype->max_occupancy}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Maximum adults/childrens/infants:</td>
                                                                        <td>{{$roomtype->max_adult}}/{{$roomtype->max_child}}/{{$roomtype->max_infant}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th colspan="2">Features</th>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Bed type configurtion:</td>
                                                                        <td>{{rtrim($room_beds_detail, "/ ")}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Room size:</td>
                                                                        <td>{{$roomtype->room_size}} SQM</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Smoking policy:</td>
                                                                        <td>{{$roomtype->smoking_category}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Number of bath rooms:</td>
                                                                        <td>{{$roomtype->bathroom}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Room Category:</td>
                                                                        <td>{{$roomtype->room_category}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Room view:</td>
                                                                        <td>
                                                                            @foreach ($roomViewIds as $roomViewid)
                                                                            @php
                                                                                $roomView22 = App\Models\RoomView::where('id', $roomViewid)->first(['view_name']);
                                                                                if ($roomView22 && isset($roomView22->view_name)) {
                                                                                    // Only push valid view names to the array
                                                                                    array_push($getroomView, $roomView22->view_name);
                                                                                }
                                                                            @endphp
                                                                        @endforeach
                                                                        @php
                                                                        $get_roomView = implode(", ", $getroomView); // Join array values into a string
                                                                        $getroomView = [];
                                                                        @endphp
                                                                        {{$get_roomView}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Amenities and facilities:</td>
                                                                        <td>
                                                                            @foreach ($amanititysIds as $amanity)
                                                                            @php
                                                                                $amanity22 = App\Models\FacilitieAmenitie::where('id', $amanity)->first(['facilities']);
                                                                                if ($amanity22 && isset($amanity22->facilities)) {
                                                                                    // Only push valid view names to the array
                                                                                    array_push($getroomAminitiynFacility, $amanity22->facilities);
                                                                                }
                                                                            @endphp
                                                                        @endforeach
                                                                        @php
                                                                        $get_facility = implode(", ", $getroomAminitiynFacility); // Join array values into a string
                                                                        $getroomAminitiynFacility = [];
                                                                        @endphp
                                                                        {{$get_facility}}
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                                            <h4 class="mb-2">Media</h4>
                                                            <div class="gallery-meia row d-sm-flex d-none">
                                                                @php
                                                                    // Fetch images that belong only to the current room type
                                                                    $roomtypeimages = App\Models\RoomtypeImage::where('roomtype_id', $roomtype->id)->get();
                                                                @endphp
                                                                @foreach ($roomtypeimages as $roomtypeimage)
                                                                    <div class="col-lg-4 col-sm-6">
                                                                        <figure><img class="img-thumbnail border-0 p-0" src="/backend/uploads/RoomType/{{ $roomtypeimage->file_name }}" itemprop="thumbnail" alt="Image description"></figure>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="gallery-media d-sm-none d-block">
                                                                @foreach ($roomtypeimages as $roomtypeimage)
                                                                <div class="col-lg-4 col-sm-6">
                                                                    <figure><img class="img-thumbnail border-0 p-0" src="/backend/uploads/RoomType/{{ $roomtypeimage->file_name }}" itemprop="thumbnail" alt="Image description"></figure>
                                                                </div>
                                                            @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="addRoomNumberCategory" tabindex="-1" role="dialog" aria-labelledby="addRoomNumberCategory" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-toggle-wrapper  text-start dark-sign-up">
                <div class="modal-header">
                    <h4 class="modal-title">Room</h4>
                    <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="">
                    <div class="modal-body">
                        <div class="col-md-12 mb-3">
                            <input type="hidden" id="category_type_id" />
                            <label>Room Number</label>
                            <div class="d-flex justify-content-between align-items-center" >
                                <div class="input-group">
                                    <input class="form-control" type="text" placeholder="Enter Room Number" aria-label="Room Number" id="room_number_value"><span class="input-group-text bg-primary" onClick="addNumber()"><i class="icon-plus txt-white"></i></span>
                                </div>
                            </div>
                            <span class="text-danger room-number-error" style="font-size: 10px;"></span>
                            <h6 class="mb-2 room-number-list-head d-none mt-3">All Rooms</h6>
                            <div class="room-number-list"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between flex-nowrap">
                        <button class="btn btn-outline-secondary w-50" type="button"
                            data-bs-dismiss="modal">Cancel</button>
                        <button class="btn btn-primary w-50" type="button" onClick="addRoomData()">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Add Room Type start --}}
@include('backend.modules.models.addRoomTypeModel')
{{-- Add Room Type end --}}
{{-- Edit Room Type start --}}
@include('backend.modules.models.editRoomTypeModel')
{{-- Edit Room Type end --}}
<!-- add gallery start -->
@include('backend.modules.models.addGalleryModel')
<!-- add gallery end -->
@endsection
@section('extra-js')
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    const addRoom = "{{ route('room.add_roomNumber') }}";
    const getCategoryRoom = "{{ route('category-roomnumber.getCategoryRoomNumber') }}";

</script>
<script src="{{asset('backend/assets/js/custom/setting/roomtype.js')}}"></script>
<script>

$(document).ready(function () {
    $('.selectpicker').selectpicker();
});

// empity deopzone when opening in update image
$('#assigning').on('shown.bs.modal', function () {
    if (Dropzone.instances.length) {
        Dropzone.instances.forEach(function(instance) {
            instance.removeAllFiles();
        });
    }
});
// empity deopzone when opening in update image ends

const roomtypeDataAdd = "{{route('roomtype.store')}}";//route for adding room type in custom_backend.js
// Make sure this is correctly defined and accessible
// const delete_roomtypeData = "{{ route('roomtype.delete_roomtype') }}";
   
   // Select the DOM elements
const selectElement = document.getElementById("bedType");
const displayDiv = document.getElementById("bedSizeContainer");
const optionText = document.getElementById("bedTypeSelected");

// Add an event listener for the select element
selectElement.addEventListener("change", () => {
    const selectedValue = selectElement.value; // Get the selected option value
    // Update the text inside the div
    const selectedOption = selectElement.options[selectElement.selectedIndex]
    optionText.textContent = selectedOption.text;
    if(selectedValue === ''){
        // Show the div if it was hidden 
        displayDiv.classList.add("d-none");
    }else{
        // Show the div if it was hidden
        displayDiv.classList.remove("d-none");
    }
});

let roomtypecheck = true;

function checkRoomTypeValid() {
    
    let roomCateID = $('#rt_room_category').val();
    let roomTypeID = $('#rt_roomtype_name').val();

    $.ajax({
        url: "{{route('roomtype.checkRoomType')}}",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { roomCateID: roomCateID, roomTypeID: roomTypeID },
        success: function(response) {
            let responseData = response.checkRoomType;
            if (responseData != '') {
                $('.rt_roomtype_name_class').removeClass('d-none');
                $('.rt_roomtype_name_class').html('This room category and type combination already exists.').css('color', 'red');
                $('#rt_roomtype_name').val('');
                $('#nextBtn').addClass('disabled');
            } else {
                $('.rt_roomtype_name_class').html('');
                $('.rt_roomtype_name_class').addClass('d-none');
                $('#nextBtn').removeClass('disabled');
            }
        }
    });  
}  

function checkRoomTypeValidEdit(){

    let roomCateID = $('#rte_room_category').val();
    let roomTypeID = $('#rte_roomtype_name').val();

    $.ajax({
        url: "{{route('roomtype.checkRoomType')}}",
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: { roomCateID: roomCateID, roomTypeID: roomTypeID },
        success: function(response) {
            let responseData = response.checkRoomType;
            if (responseData != '') {
                $('.rte_roomtype_name').removeClass('d-none');
                $('.rte_roomtype_name').html('This room category and type combination already exists.').css('color', 'red');
                $('#rte_roomtype_name').val('');
                $('.roomtype_edit_btn').addClass('disabled');
            } else {
                $('.rte_roomtype_name').html('');
                $('.rte_roomtype_name').addClass('d-none');
                $('.roomtype_edit_btn').removeClass('disabled');
            }
        }
    });

}

function changeValue(button, delta) {
    let input = button.parentElement.querySelector('.input-touchspin');
    let newValue = parseInt(input.value) + delta;
    if (newValue >= 0) {
        input.value = newValue;
    }
    checkOccupancyEdit(input.id, newValue);
}

function checkOccupancyEdit(id_name, value) {

    let rt_maximumOccupancy = parseInt(document.getElementById("rte_max_occupancy").value);
    if (id_name === 'rte_max_adult') {
        if (value > rt_maximumOccupancy) {
            $('.rte_max_adult_class').html('The maximum limit for adults has been exceeded.').addClass('text-danger');
            $(".roomtype_edit_btn").addClass("disabled");
        } else {
            $('.rte_max_adult_class').html('');
            $(".roomtype_edit_btn").removeClass("disabled");
        }
    }else if(id_name === 'rte_max_child'){
        if (value >= rt_maximumOccupancy) {
            $('.rte_max_child_class').html('The maximum limit for childrens has been exceeded.').addClass('text-danger');
            $(".roomtype_edit_btn").addClass("disabled");

        } else {
            $('.rte_max_child_class').html('');
            $(".roomtype_edit_btn").removeClass("disabled");

        }
    }else if(id_name === 'rte_max_infant'){
        if (value >= rt_maximumOccupancy) {
            $('.rte_max_infant_class').html('The maximum limit for infants has been exceeded.').addClass('text-danger');
            $(".roomtype_edit_btn").addClass("disabled");
        } else {
            $('.rte_max_infant_class').html('');
            $(".roomtype_edit_btn").removeClass("disabled");

        }
    }
}

function delete_roomtype(id) {
    // Sweetalert2 for delete confirmation
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('roomtype.delete_roomtype') }}",
                type: "POST",
                data: { id: id },
                headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.success,
                            icon: "success"
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 500); // Delay in milliseconds
                    } else {
                        Swal.fire('Error', 'An error occurred', 'error');
                    }
                },
                error: function(error) {
                    Swal.fire('Error', 'An error occurred', 'error');
                }
            });
        }
    });
}

function get_room_types_list() {
    const selectedOptions = Array.from(document.getElementById('get_room_types').selectedOptions).map(option => option.value);
}
    
// form data with dropzone images submit.
Dropzone.options.myDropzone = {
    url: "{{route('roomtype.dataimagesUpload')}}",  // Your URL here for handling the uploads
    autoProcessQueue: false,  // This will prevent auto-upload and let you manually process
    uploadMultiple: true,     // Allows multiple file uploads at once
    parallelUploads: 15,       // Max number of parallel uploads
    maxFiles: 15,              // Maximum number of files allowed
    maxFilesize: 10,           // Max file size (in MB)
    acceptedFiles: 'image/*', // Allow only images
    addRemoveLinks: true,     // Allows files to be removed from the list
    init: function() {
        var dzClosure = this;  // Store 'this' for later use
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');


        // Trigger file processing when the user clicks the "submit" button
        document.getElementById("submitBtn").addEventListener("click", function(e) {
            e.preventDefault();  // Prevent form from being submitted
            e.stopPropagation();
            dzClosure.processQueue();  // Process the files in the Dropzone queue
            
        });

        // Send all the form data along with the files:
        this.on("sendingmultiple", function(data, xhr, formData) {
            $('.roomTypeSubmitBtn').addClass('d-none');
            $('.roomTypeSubmitSpinn').removeClass('d-none');
            formData.append("_token", csrfToken); // Add the CSRF token
            formData.append("rt_room_category", document.getElementById("rt_room_category").value);
            formData.append("rt_description_guests", document.getElementById("rt_description_guests").value);
            formData.append("rt_maximumOccupancy", document.getElementById("rt_maximumOccupancy").value);
            formData.append("rt_maximumAdults", document.getElementById("rt_maximumAdults").value);
            formData.append("rt_maximumChildren", document.getElementById("rt_maximumChildren").value);
            formData.append("rt_maximumInfants", document.getElementById("rt_maximumInfants").value);
            formData.append("rt_roomsize", document.getElementById("rt_roomsize").value);
            formData.append("rt_bathroom", document.getElementById("rt_bathroom").value);
            formData.append("rt_smoking_category", document.getElementById('smoking_category').value);
            formData.append("rt_roomview", $("select[name='rt_roomview[]']").map(function () { return $(this).val(); }).get());
            formData.append("rt_aminities_facilities", $("select[name='rt_aminities_facilities[]']").map(function () { return $(this).val(); }).get());
            let bedConfig = [];
            let rt_bedType = $("select[name='bedType[]']").map(function () {
                return $(this).find("option:selected").map(function () {
                    return {
                        id: $(this).val(),
                        name: $(this).text()
                    };
                }).get();
            }).get();
            let bedtype_count = $("input[name='rt_bedType_count[]']").map(function(){return $(this).val();}).get();
            rt_bedType.forEach(function(element,key){
                if(element.id != ''){
                    bedConfig.push({
                        'bed_type':element.id,
                        'bed_type_name':element.name,
                        'count' : bedtype_count[key]
                    });
                }
            });
            formData.append("bedConfig",JSON.stringify(bedConfig));
        });
        this.on("successmultiple", function(files, response) {
            if(response.status == 'success'){
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Room Specification added successfully",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Reload the page after the alert is closed
                    setTimeout(() => {
                        location.reload();
                        $('.roomTypeSubmitSpinn').addClass('d-none');
                        $('.roomTypeSubmitBtn').removeClass('d-none');
                    }, 1000); // Delay in milliseconds
                });
            }else{
                $('.roomTypeSubmitBtn').removeClass('d-none');
                $('.roomTypeSubmitSpinn').addClass('d-none');
                toastErrorAlert(response.message);
            }
            // Gets triggered when the files have successfully been sent.
            // Redirect user or notify of success.
            // 
        });
        this.on("errormultiple", function(files, response) {
            $('.roomTypeSubmitBtn').removeClass('d-none');
            $('.roomTypeSubmitSpinn').addClass('d-none');
            // Gets triggered when there was an error sending the files.
            // Maybe show form again, and notify user of error
            // alert(response.message);
            toastErrorAlert("Something Went Wrong");
        });
    }
};

function getroomTypeDetails(x) {

    $('#imgEditUploadID').val(x);
    $('#roomtypeEdit_id').val(x);
    $.ajax({
        url: "{{route('roomtype.getdetails')}}",
        type: "GET",
        data: { id: x },
        success: function (response) {
            let roomtype = response.roomType[0];
            let roomtypeImage = response.roomTypeImages || [];
            let roomtype_id = roomtype.id;
            let roomtype_room_category = roomtype.room_category; 
            let roomtype_name = roomtype.roomtype_name_id;
            let extra_person_charge = roomtype.extra_person_charge;
            let roomtype_description = roomtype.description;
            let roomtype_max_occupancy = roomtype.max_occupancy;
            let roomtype_max_adult = roomtype.max_adult;
            let roomtype_max_child = roomtype.max_child;
            let roomtype_max_infant = roomtype.max_infant;
            let roomtype_room_size = roomtype.room_size;
            let roomtype_bathroom = roomtype.bathroom;
            let roomtype_smoking_category = roomtype.smoking_category;
            if(roomtype_smoking_category=='Non-Smoking'){
                $('#edit-non-smoking').prop('checked', true);
            }
            else{
                $('#edit-smoking').prop('checked',true);
            }
            let roomtype_room_view = roomtype.room_view;
            let roomtype_ami_facilities = roomtype.ami_facilities;
            let roomtype_bed_type = roomtype.bed_type;
            let roomtype_bedtype_count = roomtype.bedtype_count;
            let roomtype_room_category_types = roomtype.room_category_types;
            $("#rte_room_category").val(roomtype_room_category);
            $("#rte_roomtype_name").val(roomtype_name);
            $("#rte_extra_pers_charge").val(extra_person_charge);
            $("#rte_description").val(roomtype_description);
            $("#rte_max_occupancy").val(roomtype_max_occupancy);
            $("#rte_max_adult").val(roomtype_max_adult);
            $("#rte_max_child").val(roomtype_max_child);
            $("#rte_max_infant").val(roomtype_max_infant);
            $("#rte_roomsize").val(roomtype_room_size);
            $("#rte_bathroom").val(roomtype_bathroom).change();
            let rte_roomview_arr = roomtype_room_view.split(",");
            $("#rte_roomview").selectpicker('val',rte_roomview_arr); // appending multiple value to selecepicker select box
            let rte_facilities_arr = roomtype_ami_facilities.split(",");
            $("#rte_facilities").selectpicker('val',rte_facilities_arr);// appending multiple value to selecepicker select box
            $("#rte_bedtype_count").val(roomtype_bedtype_count);
            $("#edit-bedType").val(roomtype_room_category_types).change();
            let editImageDIV = '';
                roomtypeImage.forEach(function(imageloop) {
                editImageDIV +=` <li class="assgin-images position-relative m-2 d-inline-block">
                    <span onclick="getimageID(${imageloop['id']})"><div class="close-images position-absolute bg-danger d-flex align-items-center justify-content-center rounded-circle "><i class="ri-close-fill"></i></div></span>
                     <img src="/backend/uploads/RoomType/${imageloop['file_name']}" alt=""> </li>`;
             }); 
            $('.imageEditDIV').html(editImageDIV);
            
            let ddlArray= new Array();
            let ddl = document.getElementById('bedType');
            for (i = 0; i < ddl.options.length; i++) {
                if(ddl.options[i].value != ''){
                    ddlArray.push({
                        'id':  ddl.options[i].value,
                        'label':  ddl.options[i].outerText,
                    })
                }
            }

            $('.edit-bedtype-container').empty();
            let room_config = '';
            response.room_beds.forEach(function(bed_config) {
                room_config +=`<div class="mb-2 p-3 bg-white border rounded">
                    <div id="bedSizeContainer" class="bedsize-container">
                        <div class="d-flex justify-content-between align-items-center mb-2 rounded-touchspin">
                            <h5 class="mb-0" id="bedTypeSelected">Bed</h5>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="touchspin-wrapper"> 
                                    <button type="button" class="decrement-touchspin btn-touchspin touchspin-primary"><i class="icon-minus"></i></button>
                                    <input class="input-touchspin spin-outline-primary" id="rt_bedType_count" name="rt_bedType_count[]" type="number" value="${bed_config.no_of_bed}">
                                    <button type="button" class="increment-touchspin btn-touchspin touchspin-primary"><i class="icon-plus"></i>
                                    </button>
                                </div>
                                <a href="javascript:void(0)" class="text-danger mb-0" onclick="removeBedSize(this,0)"></a>
                            </div>
                        </div>
                    </div>
                    <select class="form-select form-select-sm" id="bedType1" name="bedType[]" required="">`;
                    room_config +=` <option value="">Select</option>`;
                    ddlArray.forEach(element => {
                        room_config +=`<option value="`+element.id+`"`; if(element.id == bed_config.bed_type_id){ room_config +=` selected`; } room_config +=`>`+element.label+`</option>`;
                    });
                    room_config +=`</select>
                </div>`;
            });
            $('.edit-bedtype-container').append(room_config);
        },
        error: function (xhr, status, error) {
            console.error("Error: " + error);
        }
    });
}

function roomtype_edit_submit(id){

    let rte_room_category =  $("#rte_room_category").val();
    let rte_description =  $("#rte_description").val();
    let rte_max_occupancy = $("#rte_max_occupancy").val();
    let rte_max_adult = $("#rte_max_adult").val();
    let rte_max_child = $("#rte_max_child").val();
    let rte_max_infant = $("#rte_max_infant").val();
    let rte_roomsize = $("#rte_roomsize").val();
    let rte_bathroom = $("#rte_bathroom").val();
    let rte_smoking_policy = $("input[name='smoking-police']:checked").next().text().trim();
    let rte_roomview = $("select[name='rte_roomview[]']").map(function () { return $(this).val(); }).get();
    let rte_facilities = $("select[name='rte_facilities[]']").map(function () { return $(this).val(); }).get();
    let bedConfig = [];
    let rt_bedType = $("select[name='bedType[]']").map(function () { return $(this).val(); }).get();;
    let bedtype_count = $("input[name='rt_bedType_count[]']").map(function(){return $(this).val();}).get();
    rt_bedType.forEach(function(element,key){
        if(element != '' && bedtype_count[key] != '0'){
            bedConfig.push({
                'bed_type':element,
                'count' : bedtype_count[key]
            });
        }
    });

    $.ajax({
        url: "{{route('roomtype.update_edit')}}", // Replace with your controller endpoint URL
        type: 'POST',
        data: {
            id:id,
            rte_room_category: rte_room_category,
            rte_description: rte_description,
            rte_max_occupancy: rte_max_occupancy,
            rte_max_adult: rte_max_adult,
            rte_max_child: rte_max_child,
            rte_max_infant: rte_max_infant,
            rte_roomsize: rte_roomsize,
            rte_bathroom: rte_bathroom,
            rte_smoking_policy: rte_smoking_policy,
            rte_roomview: rte_roomview,
            rte_facilities: rte_facilities,
            bedConfig: JSON.stringify(bedConfig)
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Handle success - replace with your own logic
            var offcanvas = bootstrap.Offcanvas.getInstance(document.getElementById('offcanvasRight'));
            offcanvas.hide();
            $('.alert_msg').html('Room Specification Updated Successfully');
            var toast = new bootstrap.Toast(document.getElementById('liveToast'));
            toast.show();
            setTimeout(() => {
                location.reload();
            }, 1500);
        },
        error: function(xhr, status, error) {
            // Handle error - replace with your own logic
            console.error('Error submitting data: ' + error);
        }
    });
} 

function getimageID(imgID){

    let imgdataID = $('#imgEditUploadID').val();
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('roomtype.delete_roomtypeImage') }}",
                type: "POST",
                data: { imgID: imgID },
                headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.success,
                            icon: "success"
                        });
                            getroomTypeDetails(imgdataID);
                    } else {
                        Swal.fire('Error', 'An error occurred', 'error');
                    }
                },
                error: function(error) {
                    Swal.fire('Error', 'An error occurred', 'error');
                }
            });
        }
    });
}

</script>

<script>

    // Dropzone configuration for edit room type data
    Dropzone.options.myDropzoneEdit = {
        url: "{{ route('roomtype.dataimagesEditUpload') }}",  // URL to your server-side upload handler
        autoProcessQueue: false, // Do not automatically upload files
        uploadMultiple: true,    // Allow multiple files
        parallelUploads: 15,     // Max number of parallel uploads
        maxFiles: 15,            // Max number of files allowed
        maxFilesize: 10,         // Max file size in MB
        acceptedFiles: 'image/*', // Allow only images
        addRemoveLinks: true,    // Allow files to be removed
        init: function() {
            var dzClosure = this;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Trigger file processing when the user clicks the "Submit" button
            document.querySelector(".submit-button-edit").addEventListener("click", function(e) {
            e.preventDefault();  // Prevent default form submission
            e.stopPropagation(); // Stop the event from propagating
            dzClosure.processQueue();  // Process the files in the Dropzone queue
        });
            // Send all the form data along with the files:
            this.on("sending", function(data, xhr, formData) {
                $('.submit-button-edit').addClass('d-none');
                $('.roomTypeSubmitEditSpinn').removeClass('d-none');
            formData.append("_token", csrfToken); // Add the CSRF token
            formData.append("imgUploadID", document.getElementById("imgEditUploadID").value);
        });
            // Handle successful file uploads
                this.on("successmultiple", function(files, response) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Image Uploaded successfully",
                    showConfirmButton: false,
                    timer: 1000
                }).then(() => { 
                    getroomTypeDetails($('#roomtypeEdit_id').val());
                    $('#assigning').modal('hide');
                         $('.roomTypeSubmitEditSpinn').addClass('d-none');
                         $('.submit-button-edit').removeClass('d-none');
                 });
            });

            // Handle errors during file upload
            this.on("errormultiple", function(files, response) {
                console.error("Error uploading files:", response);
                alert(response.error);
            });
        }
    };

    let roomCategoryList = [];

    function getAvailableRoomType(){

        $.ajax({
            url: "{{ route('roomtype.availableRoomCategory') }}",
            type: "POST",
            headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                roomCategoryList = [];
                $('#rt_room_category').empty();
                $('#rt_room_category').append(`<option value="">Select</option>`);
                response.roomCategoryList.forEach(element => {
                    roomCategoryList.push(element);
                    $('#rt_room_category').append(`<option value="${element.id}">${element.name}</option>`);
                });
            }
        });

    }

    function checkRoomTypeName(x){

        $('#rt_roomtype_name').empty();
        if(x != ''){
            $('#rt_roomtype_name').append(`<option value="">Select</option>`);
            roomCategoryList.forEach(element => {
                if(element.id == x){
                    element.type.forEach(element_type => {
                        $('#rt_roomtype_name').append(`<option value="${element_type.id}">${element_type.name}</option>`);
                    });
                }
            });
        }
    }

</script>

@endsection