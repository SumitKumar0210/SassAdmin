@extends('backend.layouts.main')
@section('main-container')
@section('title')
Hall Revenue Comparison
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Hall Revenue Comparison</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-sm-12">
                    <div class="card height-equal">
                        <div class="card-body">
                            <form class="row g-3 needs-validation custom-input invoice-setting-form" novalidate="">
                                <div class="col-5">
                                    <input class="form-control" id="date1" type="month" required="">
                                </div>
                                <div class="col-5">
                                    <input class="form-control" id="date2" type="month" required="">
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
                                <table class="display" id="hall_revenue_comparison_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Hall Name</th>
                                            <th>Q1 Revenue</th>
                                            <th>Q2 Revenue</th>
                                            <th>Q3 Revenue</th>
                                            <th>Q4 Revenue</th>
                                            <th>Total Annual</th>
                                            <th>Growth Rate (%)</th>
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
        let table;

        $(document).ready(function() {  
    
            table = $('#hall_revenue_comparison_table').DataTable({
                responsive: true, // Enable responsive feature when small display then + button enable to view all data
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('hallRevenue.hallRevenueView') }}",
                    data: function(d) {
                        d.date_from = document.getElementById('date1').value.split("-")[0];
                        d.date_to = document.getElementById('date2').value.split("-")[0];
                    },
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
                    { data: 'hall', name: 'hall', orderable: false, searchable: true },
                    { data: 'revenue1', name: 'revenue1', orderable: true, searchable: true },
                    { data: 'revenue2', name: 'revenue2', orderable: false, searchable: true },
                    { data: 'revenue3', name: 'revenue3', orderable: false, searchable: true },
                    { data: 'revenue4', name: 'revenue4', orderable: false, searchable: true },
                    { data: 'total_amount', name: 'total_amount', orderable: false, searchable: true },
                    { data: 'growth_rate', name: 'growth_rate', orderable: false, searchable: true },
                ],     
            });
        });
       
        function searchReport(){
            table.ajax.reload();
        }
    </script>
@endsection
