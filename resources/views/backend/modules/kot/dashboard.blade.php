@extends('backend.layouts.main')
@section('main-container')
@section('title')
Dashboard
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Dashboard</h3>
                    </div>
                    <div class="col-12 col-sm-6">
                        {{-- <div class="float-end">
                            <button class="btn btn-primary px-2 stock_add" type="button" onclick="stockAddPage()"><span class="btn-icon"><i class="ri-add-line"></i></span>
                                Add Stock</button>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="row product-page-main">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs border-tab nav-primary mb-3" id="top-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab" href="#top-home" role="tab" aria-controls="top-home" aria-selected="false">Table</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" id="profile-top-tab" data-bs-toggle="tab" href="#top-profile" role="tab" aria-controls="top-profile" aria-selected="false">Room</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content" id="top-tabContent">
                                    <div class="tab-pane fade active show" id="top-home" role="tabpanel" aria-labelledby="top-home-tab">
                                        <div class="kot-wrapper">
                                            @foreach($tables as $area)
                                                @php
                                                    $class_room = '';
                                                    $tmp = App\Models\Kot::where('order_status','Pending')->where('type_number',$area->number)->count();
                                                    if($tmp > 0){
                                                        $class_room = 'color:#fff; background-color:#feb858';
                                                    }else if($area->occupancy_status > 0){
                                                        $class_room = 'color:#fff; background-color:#feb858';
                                                    }
                                                @endphp
                                                <div class="reservation-reserved-item room-reserved" style="{{$class_room}}" onclick="changeOccupancy({{$area->id}},{{$area->occupancy_status}},{{$tmp}})">
                                                    <h5 class="mb-0 text-center">{{$area->number}}</h5>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="top-profile" role="tabpanel" aria-labelledby="profile-top-tab">
                                        <div class="kot-wrapper">
                                            @foreach($roomList as $area)
                                                @foreach($area['rooms'] as $room)
                                                    <div class="reservation-reserved-item room-reserved" style="@if($room['color'] != '') color:#fff; @endif background-color:{{$room['color']}}">
                                                        <h5 class="mb-0 text-center">{{$room['room_number']}}</h5>
                                                    </div>
                                                @endforeach
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
        <!-- Container-fluid Ends-->
    </div>
    
@endsection
@section('extra-js')
<script>
    const updateOccupancy = "{{ route('dashboard-occupancy.occupancyStatus') }}";

    function changeOccupancy(id,occupancy_type,chnge_type){
        let type = 'Vacant';
        if(occupancy_type == 0 && chnge_type == 0){
            type = 'Reserved';
        }

        Swal.fire({
        text: "Are you sure to mark as "+type+"?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Do it!"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url:updateOccupancy,
                    type:"POST",
                    data:{id:id,type:type},
                    success:function(response){

                        Swal.fire({
                            title: "Room Closeure status updated successfully",
                            text: response.success,
                            icon: "success"
                        });
                        // if(type == 0){
                        //     let reload_reservation_duration = $(".reload_reservation_duration").html();
                        //     loadreservationdata(reload_reservation_duration, 2);
                        // }else{
                            window.location.reload();
                        // }
                    }
                });

            }
        });
    }
</script>
@endsection