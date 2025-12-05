@extends('backend.layouts.main')
@section('title','Create Banquet Booking')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-12 p-0">
                    <h3>Create Booking</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        {{-- general info start --}}
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <div class="py-2 px-2 bg-light-primary rounded border">
                                    <h3 class="fw-normal text-dark">Client & Event Details</h3>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="clientName" class="form-label">Client Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="banquet_client" placeholder="Enter Client Name">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Phone No <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="banquet_phone" maxlength="10">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="banquet_address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="banquet_address" maxlength="255">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="eventType" class="form-label">Event Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="banquet_eventType">
                                    <option value="">Select</option>
                                    @foreach ($events as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                <!-- Add more as needed -->
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="eventDate" class="form-label">Event Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="banquet_eventDate" onchange="checkAvailable(this.value)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="startTime" class="form-label">Event Start Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="banquet_startTime">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="endTime" class="form-label">Event End Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="banquet_eventEndDate">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="endTime" class="form-label">Event End Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="banquet_endTime">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="guestCount" class="form-label">Expected Guest Count <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_guestCount" min="1">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gst" class="form-label">Company GST </label>
                                <input type="text" class="form-control" id="banquet_company_gst" placeholder="GST Number" onchange="checkGstRequest(this.value)" maxlength="15">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="banquet_company" placeholder="Company Name" readonly>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gst" class="form-label">Company Address</label>
                                <input type="text" class="form-control" id="banquet_company_address" placeholder="Company Address" readonly>
                            </div>
                        </div>
                        {{-- hall details start --}}
                        <div class="row mb-3 hallView d-none">
                            <div class="col-md-12 mb-3">
                                <div class="py-2 px-2 bg-light-primary rounded border">
                                    <h3 class="fw-normal text-dark">Hall Selection</h3>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="row hall_detail"></div>
                            </div>
                        </div>
                        {{-- hall details end --}}
                        {{-- pricing detail start --}}
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <div class="py-2 px-2 bg-light-primary rounded border">
                                    <h3 class="fw-normal text-dark">Pricing & Payments</h3>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Hall Charges <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_hall_charge" placeholder="Hall Charges" onkeyup="calculateHall()">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Discount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_hall_discount" placeholder="Discount" maxlength="2" onkeyup="calculateHall()">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Total <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_hall_total" placeholder="Total" readonly value="0">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Complimentary Rooms <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_complimentary_room" placeholder="Complimentary Rooms">
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="w-50 me-2">
                                        <label class="form-label">Extra Rooms <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="banquet_hall_extra_room" placeholder="No. of Rooms" onkeyup="calculateAll()" value="0">
                                    </div>
                                    <div class="w-50 ms-2">
                                        <label class="form-label">Per Room Capacity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="banquet_hall_per_room_capacity" placeholder="Per Room Capacity" value="0">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Per Room Charges <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_hall_per_room_charge" placeholder="Per Room Charges" onkeyup="calculateAll()" value="0">
                            </div>
                        </div>
                        {{-- pricing detail end --}}
                        {{-- Food and accessories and Consumable/Accessories pricing detail start --}}
                        <div class="row mb-3">
                            <div class="col-md-12 mb-3">
                                <div class="py-2 px-2 bg-light-primary rounded border">
                                    <h3 class="fw-normal text-dark">Pricing & Payments (Food & Consumables/Accessories)</h3>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-check-size">
                                    <div class="form-check form-check-inline radio radio-primary">
                                        <input class="form-check-input" id="radioinline1" type="radio" name="banquet_plate_price" value="Approx Pricing" checked="">
                                        <label class="form-check-label mb-0" for="radioinline1">Approx Pricing</label>
                                    </div>
                                    <div class="form-check form-check-inline radio radio-primary">
                                        <input class="form-check-input" id="radioinline2" type="radio" name="banquet_plate_price" value="Per Plate Pricing">
                                        <label class="form-check-label mb-0" for="radioinline2">Per Plate Pricing</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label d-block">Add Menu Category</label>
                                        <select class="selectpicker w-50" multiple data-actions-box="true" id="menu_category" title="Add Menu Category" onchange="menuCategory(this)">
                                            @foreach($categories as $item)
                                                <option value="{{$item['id']}}">{{$item['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row menu_items"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label class="form-label d-block">Add Consumable/Accesories</label>
                                        <select class="selectpicker w-100" multiple data-actions-box="true" title="Add Consumable/Accesories" id="consumable_item" onchange="consumableItem(this)">
                                            @foreach($accessories as $accessory)
                                                <option value="{{$accessory->id}}">{{$accessory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="row accessories_list"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- Pricing Summary start --}}
                                    <div class="col-md-12 mb-3">
                                        <div class="py-2 px-2 bg-light-primary rounded border">
                                            <h3 class="fw-normal text-dark">Pricing Summary</h3>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Hall Charges <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control w-50" id="banquet_grand_total_hall_charge" placeholder="Hall Charges" step="0.01" readonly value="0">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">F&B Charges <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control w-50" id="banquet_total_food_charge" placeholder="F&B Charges" step="0.01" onkeyup="calculateAll()" value="0">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Consumables & Accessories Charges <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control w-50" id="banquet_consumable_charge" placeholder="Consumables & Accessories Charges" step="0.01" readonly value="0">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Extra Room Charges <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control w-50" id="banquet_total_extra_room_charge" placeholder="Extra Room Charges" step="0.01" readonly value="0">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Sub Total Amount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_sub_total_amount" placeholder="Sub Total Amount" step="0.01" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Discount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_discount" placeholder="Discount" maxlength="2" step="0.01" onkeyup="calculateAll()">
                                                    <input type="hidden" class="form-control w-50" id="banquet_after_discount" placeholder="Discount">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Total Amount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_total_amount" placeholder="Total Amount" step="0.01" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">GST</label>
                                                    <select class="form-control tax_type w-50" onchange="calculateAll()" id="banquet_gst">
                                                        <option value="">Select</option>
                                                        @foreach($taxList as $key => $tax)
                                                        <option value="{{$tax['value']}}">{{$tax['name']}}({{$tax['value']}}%)</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">GST Amount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_after_gst" placeholder="GST" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Adjustment Amount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_adjustment" placeholder="Adjustment Amount" step="0.01" onkeyup="calculateAll()">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Grand Total</label>
                                                    <input type="number" class="form-control w-50" id="banquet_grand_total" placeholder="Grand Total" step="0.01" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Advance Paid</label>
                                                    <input type="number" class="form-control w-50" id="banquet_advance_paid" placeholder="Advance Paid" step="0.01" onkeyup="calculateAll()">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Due Total</label>
                                                    <input type="number" class="form-control w-50" id="banquet_due_total" placeholder="Due Total" step="0.01" readonly>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Payment Mode</label>
                                                    <select class="form-control w-50" id="banquet_payment_mode" onchange="referenceNumberSet(this.value)">
                                                    @foreach($payment_modes as $payment)
                                                        <option value="{{$payment['id']}}">{{$payment['name']}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3 reference_number_view d-none">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Reference Number</label>
                                                    <input class="form-control w-50" id="banquet_reference" type="text" placeholder="Enter Reference Number" >
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Note</label>
                                                    <textarea class="form-control w-50" id="banquet_note" placeholder="Note" ></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Pricing Summary end --}}
                                </div>
                            </div>
                        </div>
                        {{-- Food and accessories and Consumable/Accesories pricing detail start --}}
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end gap-3">
                                    <button type="button" class="btn btn-secondary submitBtn" onclick="createBooking(1)">Save</button>
                                    <button type="button" class="btn btn-secondary submitBtn" onclick="createBooking(2)">Save to Draft</button>
                                    <button type="button" class="btn btn-info submitBtn">Preview</button>
                                    <button type="button" class="btn btn-primary submitBtn">Print</button>
                                    <button type="button" class="btn btn-primary processBtn d-none">Please Wait...</button>
                                    <button type="button" class="btn btn-success d-none">Upload & Book</button>
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
  $(document).ready(function () {
    $('.selectpicker').selectpicker();
  });

  const collectDataBooking = "{{ route('booking.dataCollect') }}";
  const addBooking = "{{ route('booking.store') }}";
  const companyVerifyGst = "{{ route('company.verifyGst') }}";
</script>
<script src="{{asset('backend/assets/js/custom/banquet/booking.js')}}"></script>
@endsection