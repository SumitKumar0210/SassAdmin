@extends('backend.layouts.main')
@section('main-container')
@section('title')
Monthly Revenue Breakdown
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Monthly Revenue Breakdown</h3>
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
                                <table class="display" id="monthly_revenue_breakdown_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Month</th>
                                            <th>Year</th>
                                            <th>Total Revenue</th>
                                            <th>Hall Revenue</th>
                                            <th>F&B Revenue</th>
                                            <th>Additional Revenue (additional Room & consumable/accesories)</th>
                                            <th>Advance Collections</th>
                                            <th>Total Collections</th>
                                            <th>Outstanding Amount</th>
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
            table = $('#monthly_revenue_breakdown_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('monthlyRevenue.monthlyRevenueView') }}",
                data: function(d) {
                    d.date_from = $('#date1').val();
                    d.date_to = $('#date2').val();
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
                { data: 'month', name: 'month', orderable: false, searchable: true },
                { data: 'year', name: 'year', orderable: true, searchable: true },
                { data: 'total_revenue', name: 'total_revenue', orderable: false, searchable: true },
                { data: 'hall_revenue', name: 'hall_revenue', orderable: false, searchable: true },
                { data: 'f_b_revenue', name: 'f_b_revenue', orderable: false, searchable: true },
                { data: 'additional_revenue', name: 'additional_revenue', orderable: false, searchable: true },
                { data: 'advance_collection', name: 'advance_collection', orderable: false, searchable: true },
                { data: 'total_collection', name: 'total_collection', orderable: false, searchable: true },
                { data: 'outstanding_amount', name: 'outstanding_amount', orderable: false, searchable: true },
                { data: 'growth', name: 'growth', orderable: false, searchable: true },
            ],     
        });
    });

    function searchReport(){
        table.ajax.reload();
    }
    </script>
@endsection
