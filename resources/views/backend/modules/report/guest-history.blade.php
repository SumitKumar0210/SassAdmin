@extends('backend.layouts.main')
@section('main-container')
@section('title')
Guest History
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Guest History</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            {{-- <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card height-equal">
                        <div class="card-body">
                            <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                <div class="col-5">
                                    <input class="form-control" id="date1" type="date" required="" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="col-5">
                                    <input class="form-control" id="date2" type="date" required="" value="{{date('Y-m-d')}}">
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary" type="button" onclick="searchReport()">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row">
                <!-- Zero Configuration  Starts-->
                <div class="col-lg-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="display" id="guest_history_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Guest Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Mobile</th>
                                            <th>Email</th>
                                            <th>City</th>
                                            <th>Details</th>
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
        {{-- @include('backend.modules.models.KotConvertModal')
        @include('backend.modules.models.KotCancelModel') --}}
    </div>
@endsection
@section('extra-js')
    <script>
        let table = $('#guest_history_table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('guestHistory.data') }}",
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            error: function(xhr, error, thrown) {
                console.error(xhr.responseText); // Use console.error for better error logs
                alert(`Error: ${thrown}`); // Template literals for readability
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: true, searchable: true },
            { data: 'guest_id', name: 'guest_id', orderable: false, searchable: true },
            { data: 'first_name', name: 'first_name', orderable: true, searchable: true },
            { data: 'last_name', name: 'last_name', orderable: false, searchable: true },
            { data: 'mobile', name: 'mobile', orderable: false, searchable: true },
            { data: 'email', name: 'email', orderable: false, searchable: true },
            { data: 'city', name: 'city', orderable: false, searchable: true },
            { data: 'action', name: 'action', orderable: false, searchable: true }
        ],         
    });

    function getGuestDetails(id){
        window.location.href = '/report/guest-history-details/' + id;
    }
    </script>
    {{-- <script src="{{asset('backend/assets/js/custom/kot/kot.js')}}"></script> --}}
@endsection
