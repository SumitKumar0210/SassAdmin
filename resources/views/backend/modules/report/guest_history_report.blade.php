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
                        <h3 class="d-block">Reservation Rooms</h3>
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
                                <table class="display" id="reservation_room_table">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Guest ID</th>
                                            <th>Guest Name</th>
                                            <th>Date of Birth</th>
                                            <th>Gender</th>
                                            <th>Nationality</th>
                                            <th>Aadhar No/Id No.</th>
                                            <th>Contact Information</th>
                                            <th>Guest Category</th>
                                            <th>Total Number of Stays</th>
                                            <th>First Stay Date</th>
                                            <th>Last Stay Date</th>
                                            <th>Stay Frequency</th>
                                            <th>Total Nights Stayed</th>
                                            <th>Average Stay Duration</th>
                                            <th>Cancellation History</th>
                                            <th>No-show History</th>
                                            <th>Preferred Room Type</th>
                                            <th>Preferred View</th>
                                            <th>Bed Type Preference</th>
                                            <th>Smoking Preference</th>
                                            <th>Total Revenue Generated</th>
                                            <th>Average Spend per Stay</th>
                                            <th>Room Revenue</th>
                                            <th>F&B Revenue</th>
                                            <th>Payment Method Preference</th>
                                            <th>Outstanding Balance</th>
                                            <th>Payment History</th>
                                            <th>Discount Usage</th>
                                            <th>Corporate Affiliation</th>
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
        let table = $('#reservation_room_table').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('report.guestHistoryReportView') }}",
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
                { data: 'guest_name', name: 'guest_name', orderable: true, searchable: true },
                { data: 'date_of_birth', name: 'date_of_birth', orderable: false, searchable: true },
                { data: 'gender', name: 'gender', orderable: false, searchable: true },
                { data: 'nationality', name: 'nationality', orderable: false, searchable: true },
                { data: 'aadhar_no', name: 'aadhar_no', orderable: false, searchable: true },
                { data: 'contact_information', name: 'contact_information', orderable: false, searchable: true },
                { data: 'guest_category', name: 'guest_category', orderable: false, searchable: true },
                { data: 'no_of_stay', name: 'no_of_stay', orderable: false, searchable: true },
                { data: 'first_stay_date', name: 'first_stay_date', orderable: false, searchable: true },
                { data: 'last_stay_date', name: 'last_stay_date', orderable: false, searchable: true },
                { data: 'stay_frequency', name: 'stay_frequency', orderable: false, searchable: true },
                { data: 'total_nights_stay', name: 'total_nights_stay', orderable: false, searchable: true },
                { data: 'avg_stay_duration', name: 'avg_stay_duration', orderable: false, searchable: true },
                { data: 'cancellation', name: 'cancellation', orderable: false, searchable: true },
                { data: 'no_show_history', name: 'no_show_history', orderable: false, searchable: true },
                { data: 'preferred_room', name: 'preferred_room', orderable: false, searchable: true },
                { data: 'corporate', name: 'corporate', orderable: false, searchable: true },
                { data: 'bed_type_preference', name: 'bed_type_preference', orderable: false, searchable: true },
                { data: 'smoking_preference', name: 'smoking_preference', orderable: false, searchable: true },
                { data: 'revenue_generated', name: 'revenue_generated', orderable: false, searchable: true },
                { data: 'avg_spend_stay', name: 'avg_spend_stay', orderable: false, searchable: true },
                { data: 'room_revenue', name: 'room_revenue', orderable: false, searchable: true },
                { data: 'food_and_banquet_revenue', name: 'food_and_banquet_revenue', orderable: false, searchable: true },
                { data: 'payment_method', name: 'payment_method', orderable: false, searchable: true },
                { data: 'outstanding_balance', name: 'outstanding_balance', orderable: false, searchable: true },
                { data: 'payment_history', name: 'payment_history', orderable: false, searchable: true },
                { data: 'discount_usage', name: 'discount_usage', orderable: false, searchable: true },
                { data: 'corporate_affiliation', name: 'corporate_affiliation', orderable: false, searchable: true }
            ],     
        });
       
    </script>
@endsection
