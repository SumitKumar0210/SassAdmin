@extends('backend.layouts.main')
@section('main-container')
@section('title')
Merge Bill
@endsection
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title mt-2">
                <div class="row gx-0">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-block">Merge Bill</h3>
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
                                <table class="display" id="reservation_merge_bill">
                                    <thead>
                                        <tr>
                                            <th>SL No.</th>
                                            <th>Reservation Id</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Room Number</th>
                                            <th>Bill Number</th>
                                            <th>Checkout Date</th>
                                            <th>Updated At</th>
                                            <th>Action</th>
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

    <div class="modal fade" id="selectOptionToMerge" tabindex="-1" role="dialog" aria-labelledby="banquetBookingPaymentModel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" id="merge_element_form" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-toggle-wrapper  text-start dark-sign-up">
                        <div class="modal-header">
                            <h4 class="modal-title roomCategory_title">Merge Expense</h4>
                            <button class="btn-close py-0" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="reservation_merge_id" name="reservation_merge_id"/>
                            <div class="card-wrapper border rounded-3 checkbox-checked">
                            <h6 class="sub-title">Merged Bill Report </h6>
                            <label class="d-block" for="chk-ani"></label>
                            <input class="checkbox_animated" id="chk-ani" type="checkbox" value="Kot" required>Food Bill
                            {{-- <label class="d-block" for="chk-ani1"></label>
                            <input class="checkbox_animated" id="chk-ani1" type="checkbox" value="Lot">Lot Bill
                            <label class="d-block" for="chk-ani2"></label>
                            <input class="checkbox_animated" id="chk-ani4" type="checkbox" value="Tot">Travel Bill   --}}
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Close</button>
                            <button class="btn btn-primary" type="submit">Print Merged Bill </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('extra-js')
    <script>
        let table = $('#reservation_merge_bill').DataTable({
            responsive: true, // Enable responsive feature when small display then + button enable to view all data
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('report.mergeBillReservation') }}",
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
                { data: 'reservation_id', name: 'reservation_id', orderable: true, searchable: true },
                { data: 'first_name', name: 'first_name', orderable: false, searchable: true },
                { data: 'last_name', name: 'last_name', orderable: false, searchable: true },
                { data: 'room_number', name: 'room_number', orderable: false, searchable: true },
                { data: 'bill_number', name: 'bill_number', orderable: false, searchable: true },
                { data: 'checkout_date', name: 'checkout_date', orderable: false, searchable: true },
                { data: 'updated_at', name: 'updated_at', orderable: false, searchable: true },
                { data: 'action', name: 'action' },
            ],     
        });
       
        function selectOptionToMerge(id){
            $('#reservation_merge_id').val(id);
            $('#selectOptionToMerge').modal('show');
        }

        $("#merge_element_form").on("submit", function (event) {
            event.preventDefault();
            
            let id = $('#reservation_merge_id').val();
            let url = '../reservation/merge-bill-print/id='+id+'&type=Food';
            window.open(url,'_blank');
        });

    </script>
@endsection
