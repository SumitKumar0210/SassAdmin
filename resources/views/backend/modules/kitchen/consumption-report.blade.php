@extends('backend.layouts.main')
@section('title','Kitchen Consumption Report')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Consumption Report</h3>
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
        <div class="container-fluid">
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="hover row-border stripe" id="consumption-report-table">
                                    <thead>
                                        <tr>  
                                            <th>SR No.</th>
                                            <th>Item Name</th>
                                            <th>Department</th>
                                            <th>Expiry Date</th>
                                            <th>TXN Date</th>
                                            <th>Qty In</th>
                                            <th>Qty Out</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      
                                    </tbody>
                                </table>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let in_stock_table = $('#consumption-report-table').DataTable({
        processing:true,
        serverSide:true,
        ajax:{
            url:"{{route('kitchen.consumptionReportView')}}",
            type:"POST",
            error:function(xhr,error,thrown){
                console.log(xhr.responseText);
                alert("An error occured "+thrown);
            }
        },
            columns:[
            {
                data:'DT_RowIndex',
                name:'DT_RowIndex'
            },
            {
                data:'item_name',
                name:'item_name'
            },
            {
                data:'department',
                name:'department'
            },
            {
                data:'expiry',
                name:'expiry'
            },
            {
                data:'txn_date',
                name:'txn_date'
            },
            {
                data:'qty_in',
                name:'qty_in'
            },
            {
                data:'qty_out',
                name:'qty_out'
            },
            {
                data:'balance',
                name:'balance'
            },
        ]
    });
</script>
@endsection