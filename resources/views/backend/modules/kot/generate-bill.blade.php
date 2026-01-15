@extends('backend.layouts.main')
@section('title','Generate Bill')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid py-3">
            <div class="email-wrap bookmark-wrap">
                <div class="row">
                    <div class="col-xl-12 col-md-12 box-col-12">
                        <div> 
                            @include('backend.layouts.sidebar_master')
                        </div>
                        <div style=" padding-left:220px;">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card height-equal">
                                            <div class="card-body">
                                                <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                                    <div class="col-5">
                                                        {{-- <label>Select Table Number</label> --}}
                                                        <select class="form-select forrm-select-sm bg-transparent w-100" id="bill_table" style="width:100px;" onchange="clearData(`bill_room`)">
                                                            <option value="">Select Table Number </option>
                                                            @foreach($tables_occupied as $table)
                                                               <option value="{{$table}}">{{$table}}</option>
                                                            @endforeach
                                                        </select> 
                                                    </div>
                                                    <div class="col-5">
                                                        {{-- <label>Select Room Number</label> --}}
                                                        <select class="form-select forrm-select-sm bg-transparent w-100" id="bill_room" style="width:100px;" onchange="clearData(`bill_table`)">
                                                            <option value="">Select Room Number </option>
                                                            @foreach($room_occupied as $room)
                                                               <option value="{{$room}}">{{$room}}</option>
                                                            @endforeach
                                                        </select> 
                                                    </div>
                                                    <div class="col-2">
                                                        <button class="btn btn-primary" type="button" onclick="searchReport()">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- Zero Configuration  Starts-->
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="hover row-border stripe" id="kot_for_bill_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Select</th>
                                                                <th>KOT</th>
                                                                <th>Table</th>
                                                                <th>Room</th>
                                                                <th>KOT Type</th>
                                                                <th>Guest Name</th>
                                                                <th>Assisted By</th>
                                                                <th>Date & Time</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-sm-12">
                                        <button class="btn btn-primary" type="button" onclick="generateBill()">Generate Bill</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('extra-js')
<script>
    const getBillKot = "{{ route('kot-generate-bill-list.getBill') }}";
</script>
<script>
    function clearData(id){
        $('#'+id).val("");
    }
</script>
{{-- kot_for_bill_table --}}
<script src="{{asset('backend/assets/js/custom/kot/bill-kot.js')}}"></script>
@endsection