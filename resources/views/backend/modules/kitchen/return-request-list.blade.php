@extends('backend.layouts.main')
@section('title','Kitchen Return Request List')
@section('main-container')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Return Request List</h3>
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
                                <table class="hover row-border stripe" id="return-request-list">
                                    <thead>
                                        <tr>  
                                            <th>Date</th>
                                            <th>STR No.</th>
                                            <th>Item</th>
                                            <th>Quantity</th>
                                            <th>Unit</th>
                                            <th>Reason</th>
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
    const returnRequestVeiw = "{{route('kitchen.returnRequestVeiw')}}";
</script>
<script>
    let return_request_list = $('#return-request-list').DataTable({
    processing:true,
    serverSide:true,
    ajax:{
        url:returnRequestVeiw,
        type:"POST",
        error:function(xhr,error,thrown){
            console.log(xhr.responseText);
            alert("An error occured "+thrown);
        }
         },
        columns:[
        {
            data:'created_at',
            name:'created_at'
        },
        {
            data:'str_no',
            name:'str_no'
        },
        {
            data:'item',
            name:'item'
        },
        {
            data:'qty',
            name:'qty'
        },
        {
            data:'unit',
            name:'unit'
        },
        {
            data:'reason',
            name:'reason'
        }
    ]
});
</script>
{{-----------external js files added for page functions------------}}
  {{-- <script src="{{asset('backend/assets/js/custom/kitchen/return-request.js')}}"></script> --}}
@endsection