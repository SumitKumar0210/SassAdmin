@extends('backend.layouts.main')
@section('title','Reservation Checkout')
@section('main-container')
@section('extra-css')
<style>
	.checkout-bill-header {
        max-width: 310px;
    }
</style>
@endsection
 <div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-12 p-0">
                    <h3>Checkedout</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    @foreach ($reservations as $reservation)
    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-lg-12 col-sm-12">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-3">
                                <div class="mb-3">
                                    
                                </div>
                            </div>
                            <div class="col-6 offset-3">
                                <div class="float-end checkout-bill-header">
                                    <table>
                                        <tr>
                                            <th>Invoice Date:</th>
                                            <td class="text-end">{{date('d-m-Y',strtotime($invoices[0]->invoice_date))}}</td>
                                        </tr>
                                        <tr>
                                            <th colspan="2" class="text-end">To,</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="mb-0 w-100">
                                                    <input class="form-control" type="text" name="guest_name" placeholder="Guest Name" value="{{$reservation->first_name}} {{$reservation->last_name}}">
                                                </div>
                                            </td>
                                        </tr>
                                         <tr>
                                            <th colspan="2" class="text-end">
                                                @if($reservation->address != '') {{$reservation->address}}, @endif
                                                @if($reservation->city != '') {{$reservation->city}}, @endif
                                                @if($reservation->state != '') {{$reservation->state}} @endif
                                                @if($reservation->pincode != '') - {{$reservation->pincode}}@endif
                                                @if($reservation->country != ''), {{$reservation->country}} @endif
                                            </th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                <div class="mb-0 w-100">
                                                    <input class="form-control" type="text" name="company_gst" placeholder="N/A" value="{{$reservation->company_gst}}">
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Check In Date:</th>
                                            <td class="text-end">{{date('d-m-Y h:i A',strtotime($invoices[0]->checkin))}}</td>
                                        </tr>
                                        <tr>
                                            <th>Check Out Date:</th>
                                            <td class="text-end">{{date('d-m-Y h:i A',strtotime($invoices[0]->checkout))}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="room-tariff-details">
                                    <table class="table table-hover">
                                        <tr>
                                            <th>Sl.No.</th>
                                            <th>Room Type</th>
                                            <th>Room No</th>
                                            <th>Tariff Type</th>
                                            <th>Room Tariff</th>
                                            <th>Occupancy Type</th>
                                            <th>No Of Days</th>
                                            <th class="text-end">Amount</th>
                                        </tr>
                                        @php
                                           $no = 1;
                                        @endphp
                                        @foreach($invoice_rooms as $room)
                                        @php
                                        $tariff_name = '';
                                        $adult = 0;
                                        $tariff_room = App\Models\ReservationRoom::where('id',$room['reserved_room_id'])->get(['tariff_id','adults']);
                                        if(sizeOf($tariff_room) > 0){
                                            $tariff_name = App\Models\Tariff::where('id',$tariff_room[0]->tariff_id)->value('tariff_type');
                                            $adult = $tariff_room[0]->adults;
                                        }
                                        @endphp
                                        <tr>
                                            <td>{{$no++}}</td>
                                            <td>{{$room['room_type']}}</td>
                                            <td>{{$room['room_number']}}</td>
                                            <td>{{$tariff_name}}</td>
                                            <td>{{$room['total']}}</td>
                                            <td>{{$adult + $room['extra_person']}}</td>
                                            <td>{{$room['no_of_days']}}</td>
                                            <td class="text-end">{{$room['no_of_days'] * $room['total']}}</td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-lg-4 col-sm-12">
                                
                                <div class="mb-2">
                                    <h5 class="py-3">Merged Bill Report</h5>
                                    <div class="form-check"><input class="form-check-input room_checked-element" type="checkbox" id="food_check">Food Bill</div>
                                </div>
                            </div>
                            <div class="col-4 offset-4">
                                <div class="float-end checkout-bill-header">
                                    <table>
                                        <tr>
                                            <th>Amount:</th>
                                            <td class="text-end">₹ <span class="total_amount">{{$invoices[0]->total}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Discount:</th>
                                            <td class="text-end">₹ <span class="total_discount_amount">{{$invoices[0]->dis_amount}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Amount After Discount:</th>
                                            <td class="text-end">₹ <span class="total_discount">{{$invoices[0]->amount_after_discount}}</span></td>
                                        </tr>
                                        <tr class="tax-sgst">
                                            <th>SGST(<span class="total_sgst_percent">{{$invoices[0]->sgst_per}}</span>)%</th>
                                            <td class="text-end">₹ <span class="total_sgst">{{$invoices[0]->sgst_amount}}</span></td>
                                        </tr>
                                        <tr class="tax-sgst">
                                            <th>CGST(<span class="total_sgst_percent">{{$invoices[0]->cgst_per}}</span>)%</th>
                                            <td class="text-end">₹ <span class="total_cgst">{{$invoices[0]->cgst_amount}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Sub Total</th>
                                            <td class="text-end">₹ <span class="sub_total">{{$invoices[0]->amount_after_tax}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Advance Amount</th>
                                            <td class="text-end">₹ <span class="advance_amount">{{$invoices[0]->advance_amount}}</span></td>
                                        </tr>
                                        <tr>
                                            <th>Round Off</th>
                                            <td class="text-end">₹ <span class="advance_amount">{{$invoices[0]->round_off}}</span></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-12 mb-3">
                                <div class="border py-2 px-2 bg-light">
                                    <h5 class="text-end text-dark">Total Paid: ₹ <span class="remaining_amount">{{$invoices[0]->pay_amount}}</span></h5>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-2">
                                    <label>Payment Mode: {{$mode}}</label>
                                    @if($invoices[0]->reference != '')
                                    <label># {{$invoices[0]->reference}}</label>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-end align-item-center">
                                   <button class="btn btn-secondary me-2" type="button" onClick="unCheckMerge(`{{$reservation_id}}`)">Print Bill</button>
                                   <button class="btn btn-primary ms-2" type="button" onClick="printMergeBill(`{{$reservation_id}}`)">Print Merged Bill</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    <!-- Container-fluid Ends-->
</div>
@endsection
@section('extra-js') 
<script>
    function unCheckMerge(id){
        $('#food_check').prop('checked', false);
        printMergeBill(id);
    }

    function printMergeBill(id){
        let food = $('#food_check').prop('checked');
        let type = '';
        if(food){
            type = 'food';
        }
        let url = '../reservation/merge-bill-print/id='+id+'&type='+type;
        window.open(url,'_blank');
    }
</script>
@endsection