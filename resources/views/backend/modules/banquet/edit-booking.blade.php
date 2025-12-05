@extends('backend.layouts.main')
@section('title','Edit Banquet Booking')
@section('main-container')
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-12 p-0">
                    <h3>Edit Booking</h3>
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
                                <input type="hidden" class="form-control" id="banquet_id" value="{{$banquets[0]->id}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="clientName" class="form-label">Client Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="banquet_client" placeholder="Enter Client Name" value="{{$banquets[0]->client_name}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="phone" class="form-label">Phone No <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="banquet_phone" maxlength="10" value="{{$banquets[0]->contact_no}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="banquet_address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="banquet_address" maxlength="255" value="{{$banquets[0]->address}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="eventType" class="form-label">Event Type <span class="text-danger">*</span></label>
                                <select class="form-select" id="banquet_eventType">
                                    <option value="">Select</option>
                                    @foreach ($events as $item)
                                        <option value="{{$item->id}}" @if($banquets[0]->event_id == $item->id) {{ 'selected'; }} @endif>{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                 <label for="eventDate" class="form-label">Event Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm" id="banquet_eventDate" onchange="checkAvailable(this.value)">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="startTime" class="form-label">Event Start Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="banquet_startTime" value="{{$banquets[0]->start_time}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="endTime" class="form-label">Event End Date <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="banquet_eventEndDate">
                            </div>
                            <div class="col-md-4 mb-3">
                               <label for="endTime" class="form-label">Event End Time <span class="text-danger">*</span></label>
                                <input type="time" class="form-control" id="banquet_endTime" value="{{$banquets[0]->end_time}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="guestCount" class="form-label">Expected Guest Count</label>
                                <input type="number" class="form-control" id="banquet_guestCount" min="1" value="{{$banquets[0]->expected_guest_count}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gst" class="form-label">Company GST </label>
                                <input type="text" class="form-control" id="banquet_company_gst" placeholder="GST Number" readonly value="{{$banquets[0]->company_gst}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="company" class="form-label">Company Name</label>
                                <input type="text" class="form-control" id="banquet_company" placeholder="Company Name" readonly value="{{$banquets[0]->company_name}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="gst" class="form-label">Company Address</label>
                                <input type="text" class="form-control" id="banquet_company_address" placeholder="Company Address" readonly value="{{$banquets[0]->company_address}}">
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
                                <input type="number" class="form-control" id="banquet_hall_charge" placeholder="Hall Charges" onkeyup="calculateHall()" value="{{$banquets[0]->hall_charge}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Discount <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_hall_discount" placeholder="Discount" maxlength="2" onkeyup="calculateHall()" value="{{$banquets[0]->discount}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Total <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_hall_total" placeholder="Total" readonly value="{{$banquets[0]->discount_amount}}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Complimentary Rooms <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_complimentary_room" placeholder="Complimentary Rooms" value="{{$banquets[0]->complimentary_room}}">
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="w-50 me-2">
                                        <label class="form-label">Extra Rooms <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="banquet_hall_extra_room" placeholder="No. of Rooms" onkeyup="calculateAll()" value="{{$banquets[0]->extra_room}}">
                                    </div>
                                    <div class="w-50 ms-2">
                                        <label class="form-label">Per Room Capacity <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" id="banquet_hall_per_room_capacity" placeholder="Per Room Capacity" value="{{$banquets[0]->per_room_capacity}}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Per Room Charges <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="banquet_hall_per_room_charge" placeholder="Per Room Charges" onkeyup="calculateAll()" value="{{$banquets[0]->per_room_charge}}">
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
                                        <input class="form-check-input" id="radioinline1" type="radio" name="banquet_plate_price" value="Approx Pricing" @if($banquets[0]->food_consumption_type == 'Approx Pricing') {{ 'checked' }} @endif>
                                        <label class="form-check-label mb-0" for="radioinline1">Approx Pricing</label>
                                    </div>
                                    <div class="form-check form-check-inline radio radio-primary">
                                        <input class="form-check-input" id="radioinline2" type="radio" name="banquet_plate_price" value="Per Plate Pricing" @if($banquets[0]->food_consumption_type == 'Per Plate Pricing') {{ 'checked' }} @endif>
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
                                                    <input type="number" class="form-control w-50" id="banquet_grand_total_hall_charge" placeholder="Hall Charges" step="0.01" readonly value="{{$banquets[0]->total_hall_charge}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">F&B Charges <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control w-50" id="banquet_total_food_charge" placeholder="F&B Charges" step="0.01" onkeyup="calculateAll()" value="{{$banquets[0]->total_food_charge}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Consumables & Accessories Charges <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control w-50" id="banquet_consumable_charge" placeholder="Consumables & Accessories Charges" step="0.01" readonly value="{{$banquets[0]->total_accesories_charge}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Extra Room Charges <span class="text-danger">*</span></label>
                                                    <input type="number" class="form-control w-50" id="banquet_total_extra_room_charge" placeholder="Extra Room Charges" step="0.01" readonly value="{{$banquets[0]->extra_room_charge}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Sub Total Amount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_sub_total_amount" placeholder="Sub Total Amount" step="0.01" readonly value="{{$banquets[0]->sub_total}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Discount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_discount" placeholder="Discount" maxlength="2" step="0.01" onkeyup="calculateAll()" value="{{$banquets[0]->total_discount}}">
                                                    <input type="hidden" class="form-control w-50" id="banquet_after_discount" placeholder="Discount" value="{{$banquets[0]->total_discount_amount}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Total Amount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_total_amount" placeholder="Total Amount" step="0.01" readonly value="{{$banquets[0]->total_amount}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">GST</label>
                                                    <select class="form-control tax_type w-50" onchange="calculateAll()" id="banquet_gst">
                                                        <option value="">Select</option>
                                                        @foreach($taxList as $key => $tax)
                                                        <option value="{{$tax['value']}}" @if($tax['value'] == $banquets[0]->gst) {{ 'selected'}} @endif>{{$tax['name']}}({{$tax['value']}}%)</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">GST Amount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_after_gst" placeholder="GST" readonly value="{{$banquets[0]->gst_amount}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Adjustment Amount</label>
                                                    <input type="number" class="form-control w-50" id="banquet_adjustment" placeholder="Adjustment Amount" step="0.01" onkeyup="calculateAll()" value="{{$banquets[0]->adjustment}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Grand Total</label>
                                                    <input type="number" class="form-control w-50" id="banquet_grand_total" placeholder="Grand Total" step="0.01" readonly value="{{$banquets[0]->grand_total}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Advance Paid</label>
                                                    <input type="number" class="form-control w-50" id="banquet_advance_paid" placeholder="Advance Paid" step="0.01" onkeyup="calculateAll()" value="{{$banquets[0]->advance_paid}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Due Total</label>
                                                    <input type="number" class="form-control w-50" id="banquet_due_total" placeholder="Due Total" step="0.01" readonly value="{{$banquets[0]->due}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Payment Mode</label>
                                                    <select class="form-control w-50" id="banquet_payment_mode" onchange="referenceNumberSet(this.value)">
                                                    @foreach($payment_modes as $payment)
                                                        <option value="{{$payment['id']}}" @if($banquets[0]->payment_mode == $payment['id']) {{ 'selected'; }} @endif>{{$payment['name']}}</option>
                                                    @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3 reference_number_view d-none">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Reference Number</label>
                                                    <input class="form-control w-50" id="banquet_reference" type="text" placeholder="Enter Reference Number" value="{{$banquets[0]->reference_number}}">
                                                </div>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <label class="form-label">Note</label>
                                                    <textarea class="form-control w-50" id="banquet_note" placeholder="Note" >{{$banquets[0]->note}}</textarea>
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
                                    <button type="button" class="btn btn-secondary submitBtn" onclick="updateBooking()">Update</button>
                                    <button type="button" class="btn btn-primary processBtn d-none">Please Wait...</button>
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
  const updateBookingData = "{{ route('booking.update') }}";
  const getBooking = "{{ route('booking.getBooking') }}";
  const companyVerifyGst = "{{ route('company.verifyGst') }}";
</script>
<script src="{{asset('backend/assets/js/custom/banquet/booking_edit.js')}}"></script>
@endsection