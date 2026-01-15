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
                                <div class="row ">
                                    <div class="col-lg-6 col-sm-6">
                                         <h4 class="d-block">Paid Bill</h4>
                                    </div>
                                    <div class="col-lg-6 col-sm-6">
                                        <button class="btn btn-primary pull-right" type="button" onclick="getTodaySale()"> Today Sales Report</button>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card height-equal">
                                            <div class="card-body">
                                                <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                                    <div class="col-5">
                                                        {{-- <label>Select Table Number</label> --}}
                                                        <select class="form-select forrm-select-sm bg-transparent w-100" id="bill_table" style="width:100px;">
                                                            <option value="">Select Table Number </option>
                                                            @foreach($tables_occupied as $table)
                                                               <option value="{{$table}}">{{$table}}</option>
                                                            @endforeach
                                                        </select> 
                                                    </div>
                                                    <div class="col-5">
                                                        {{-- <label>Select Room Number</label> --}}
                                                        <select class="form-select forrm-select-sm bg-transparent w-100" id="bill_room" style="width:100px;">
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
                                    <div class="col-lg-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="hover row-border stripe" id="kot_for_bill_table">
                                                        <thead>
                                                            <tr>
                                                                <th>Bill#</th>
                                                                <th>Table</th>
                                                                <th>Room</th>
                                                                <th>KOT Type</th>
                                                                <th>Guest Name</th>
                                                                <th>Assisted By</th>
                                                                <th>Date & Time</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="kotCancelGenerateBill" tabindex="-1" role="dialog" aria-labelledby="banquetBookingCancelGenerateBill" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-toggle-wrapper  text-start dark-sign-up">
                    <div class="modal-header">
                        <h4 class="modal-title roomCategory_title">Cancel Reason</h4>
                        <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="" id="cancel_kot_generate_bill_form" class="needs-validation" novalidate>
                        <div class="modal-body">
                            <div class="col-md-12 mb-3 d-none">
                                <input type="text" class="generate_bill_id">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="generate_bill_cancel_reason">Reason</label>
                                <textarea class="form-control form-control-sm" id="generate_bill_cancel_reason" type="text" placeholder="Enter Reason" style="background-image: none;" required></textarea>
                                <div class="invalid-feedback">
                                    Enter Reason
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary payment_collecting_submit" type="submit">Submit</button>
                            <button class="btn btn-primary payment_processing d-none" type="button">Please Wait..</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('backend.modules.models.kotSaleRecordModel')
@endsection
@section('extra-js')
<script>
    const getBilledKot = "{{ route('kot-generated-bill-list.getBillPaid') }}";
    const cancelBill = "{{ route('kot-generated-bill-cancel.cancelGeneratedBill') }}";
    const kotSaleModel = "{{route('view-kot-sale.getKotSaleReport')}}";

    function getTodaySale(){

        $.ajax({
            url: kotSaleModel,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                //console.log(response);
                $('#kotSaleModel').modal('show');
                let view = '';
                view = `<div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="mb-1">Number of Kots : ${response.kots}</p>`;
                                response.payments.forEach(element => {
                                    view += `<p class="mb-1">Amount paid by ${element.method} : ₹ ${element.amount}</p>`;
                                });
                            view += `</div>
                        </div>
                    </div>
                </div>`;
                $('.kot-sale-report-detail').html(view);
            }
        });
        
    }
</script>
    
{{-- kot_for_bill_table --}}
<script src="{{asset('backend/assets/js/custom/kot/bill-paid.js')}}"></script>
@endsection