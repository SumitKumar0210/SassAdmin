
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Site Title -->
  <title>Hotel Booking Invoice</title>
  {{-- <link rel="stylesheet" href="assets/css/style.css"> --}}
  <link rel="stylesheet" href="{{url('backend/assets/css/invoice/style.css')}}">
</head>
<style>
  .tm_table_responsive table th{
   padding: 10px 13px;
}
.tm_table_responsive table td{
    padding: 10px 13px;
    text-align: center;
 }
   .header {
    display: flex;
    justify-content: space-between;
    margin-bottom:12px;
}
.logo-img img{
  width: 22px;
  height:auto;
}
.scanner img{
  width: 100px;
  height:auto;
}
.tax-invoice{
  text-align:center;
  line-height: 30px;
}
.tm_m0 {
    line-height: 20px;
}
.tm_invoice_content{
  position: relative;
  z-index: 1;
}
.invoice-cancel{
  position: absolute;
  top: 437px;
  left: 75px;
}
.invoice-cancel h1{
  font-size: 100px;
  rotate: -30deg;
  color:#ff00003d
}
</style>
<body>
    @php
    $checkinDate = new DateTime($reservationInvoice[0]->checkin);
    $checkoutDate = new DateTime($reservationInvoice[0]->checkout);
    $interval = $checkinDate->diff($checkoutDate);
    $interval_in_days = $interval->days;
    $room_amount = $reservationInvoice[0]->amount;
    $total_room_amount = $room_amount * $interval_in_days;
    $status = $reservationInvoice[0]->status;
    if($status == 'cancel'){
      $ssts_warning = 'CANCELLED';
    }else{
      $ssts_warning = '';
    }
   @endphp
  <div class="tm_container" style="font-size:13px">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="invoice-cancel">
            <h1>{!! $ssts_warning !!}</h1>
          </div>
          <div class="tm_invoice_content">
            <div class="header">
               <div class="logo-img"><img src="{{asset('backend/assets/images/logo/logo_dark.png')}}" alt="Logo"></div>
               <div class="tax-invoice">
                    <b class="tm_f30 tm_medium tm_primary_color">Tax invoice</b>
                    <p class="tm_m0"><b>Company</b> : Hotel Yuvraj Deluxe</p>
                    <p class="tm_m0"> <b>Address</b> : Barauni Zero Mile, Barauni - Purnea Highway,<br> Begusarai, Bihar 851126</p>
                    <p class="tm_m0"><b>Tel-No</b> :  +91 123 456 7890</p>
                    <p class="tm_m0"><b>GST NO</b> : 10AJJPS4638J2ZO</p>
                    <p class="tm_m0"><b>IRN</b> : ABC987654321123456789CDF123456987EFG987654321</p> 
                 </div>
                 <div class="scanner"><img src="{{asset('backend/assets/images/scan_me.jpg')}}" alt="Logo"></div>
            </div>
            <div class="tm_invoice_info tm_mb25">
              <div class="tm_invoice_info_right" style="width:100%">
                <div class="tm_grid_row tm_col_4 tm_col_2_sm tm_invoice_info_in tm_gray_bg tm_round_border">
                  <div>
                    <span>Invoice No:</span> <br>
                    <b class="tm_primary_color">RS0{{$reservationInvoice[0]->id}}</b>
                  </div>
                  
                  <div>
                    <span>Check In:</span> <br>
                    <b class="tm_primary_color">{{$reservationInvoice[0]->checkin}}</b>
                  </div>
                  <div>
                    <span>Check Out:</span> <br>
                    <b class="tm_primary_color">{{$reservationInvoice[0]->checkout}}</b>
                  </div>
                  <div>
                    <span>Booking ID:</span> <br>
                    <b class="tm_primary_color">{{$reservationInvoice[0]->reservation_id}}</b>
                  </div>
                  <div>
                    <span>Invoice Date:</span> <br>
                    <b class="tm_primary_color">{{$reservationInvoice[0]->created_at}}</b>
                  </div>
                  <div>
                    <span>Nights:</span> <br>
                    <b class="tm_primary_color">{{$interval_in_days}}</b>
                  </div>
                  <div>
                    <span>Rooms:</span> <br>
                    <b class="tm_primary_color">1</b>
                  </div>
                  <div>
                    <span>Room No./Type:</span> <br>
                    <b class="tm_primary_color">{{$reservationInvoice[0]->room_num}}/{{$reservationInvoice[0]->room_type}}</b>
                  </div>
                </div>
              </div>
            </div>
            <div class="tm_grid_row tm_col_2 tm_invoice_info_in tm_round_border tm_mb30" style="grid-template-columns: repeat(3, 1fr);">
              <div class="tm_border_right tm_border_none_sm">
                <b class="tm_primary_color">Guest Info</b>
                <p class="tm_m0">Name: {{$reservationInvoice[0]->name}} <br>Phone: {{$reservationInvoice[0]->mobile}}</p>
              </div>
              <div class="tm_border_right tm_border_none_sm">
                <b class="tm_primary_color">Address:</b>
                <p class="tm_m0">{{$reservationInvoice[0]->address}}</p>
                <p class="tm_m0">Email: {{$reservationInvoice[0]->email}}</p>
              </div>
              <div>
                <b class="tm_primary_color">Company Info</b>
                <p class="tm_m0">Name: {{$reservationInvoice[0]->company_name}} <br>GST NO : {{$reservationInvoice[0]->company_gst}}</p>
              </div>
            </div>
            <div class="tm_table tm_style1">
              <div class="tm_round_border">
                <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_primary_color">Room Charges</th>
                      <th class="tm_primary_color">No Of Days</th>
                      <th class="tm_primary_color">Amount</th>
                      <th class="tm_primary_color">Disc</th>
                      <th class="tm_primary_color">Total</th>
                      {{-- <th class="tm_primary_color">CGST %</th>
                      <th class="tm_primary_color">SGST%</th>
                      <th class="tm_primary_color">IGST%</th>
                      <th class="tm_primary_color">Pay Amount</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @php
                      $amt = $reservationInvoice[0]->amount;
                      $amount = $amt * $interval_in_days;
                      $disc = $reservationInvoice[0]->discount;
                      $amt_after_disc = $amount - $disc;
                      $cgst = ($amt_after_disc * 2.5)/100;
                      $sgst = ($amt_after_disc * 2.5)/100;
                      $pay_amount = $amt_after_disc - $cgst - $sgst;
                      $in_words =  numToWordsfinal($pay_amount); // Output: Twelve Thousand Three Hundred Forty Five
                    @endphp
                    <tr>
                      <td data-label="Room Charges" style="text-align:left">₹{{$amt}}</td>
                      <td data-label="No Of Days" style="text-align:left">{{$interval_in_days}}</td>
                      <td data-label="Amount" style="text-align:left">₹{{$amount}}</td>
                      <td data-label="Disc" style="text-align:left">₹{{$disc}}</td>
                      <td data-label="Total" style="text-align:left">₹{{$amt_after_disc}}</td>
                      {{-- <td data-label="CGST">5%</td>
                      <td data-label="SGST">5%</td>
                      <td data-label="IGST">5%</td>
                      <td data-label="Pay Amount">₹5635</td> --}}
                    </tr>
                    {{-- <tr>
                      <td colspan="7" style="text-align:right"><b> Sub total</b></td>
                      <td colspan="1"><b>₹5635</b></td>
                    </tr> --}}
                    <!-- Additional rows as needed -->
                  </tbody>
                </table>
                </div>
              </div>
              <div class="tm_invoice_footer tm_mb15">
                <div class="tm_left_footer">
                  <p class="tm_mb2"><b class="tm_primary_color">Payment info:</b></p>
                  <p class="tm_m0">Received By- Manager<br>Paid Amount: ₹{{$pay_amount}}</p>
                </div>
                <div class="tm_right_footer">
                  <table class="tm_mb15">
                    <tbody>
                       <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Sub Total</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">₹{{$amt_after_disc}}</td>
                      </tr> 
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">CGST 2.5%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">₹{{$cgst}}</td>
                      </tr>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">SGST 2.5%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">₹{{$sgst}}</td>
                      </tr>
                      {{-- <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">IGST 5%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">₹245</td>
                      </tr> --}}
                      <tr>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_gray_bg tm_radius_6_0_0_6" style="font-size:14px">Pay Amount</td>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_text_right tm_gray_bg tm_radius_0_6_6_0" style="font-size:14px">₹{{$pay_amount}}</td>
                      </tr> 
                    </tbody>
                  </table>
                  <!-- <p style="display:flex; align-items:center justify-content:space-between"><span>Total</span><span>$1200</span></p> -->
                  <p style="margin-top:-8px;margin-left: 17px;"> <b>In words :</b> {{$in_words}}.</p>
                </div>
              </div>
              <div class="tm_invoice_footer tm_type1">
                <div class="tm_left_footer" style="width:100%">
                    <div class="tm_invoice_info_in tm_round_border">
                        <b class="tm_primary_color">Please Notes</b>
                        <p class="tm_m0" style="margin-top:6px; font-size:12px;">The customer is liable to pay the net amount mentioned in this invoice. Any disputes are subject to Bihar jurisdiction. We appreciate your business and regret any inconvenience. Looking forward to serving you again. Thank you!
                        </p>
                        <p style="margin-top:10px;font-size:12px;margin-bottom:0">Assisted By : Amit Kumar</p>
                    </div>
                </div>
                <!-- <div class="tm_right_footer">
                  <div class="tm_sign tm_text_center">
                    <img src="backend/assets/images/invoice/sign.svg" alt="">
                    <p class="tm_m0 tm_ternary_color">Jhon Donate</p>
                    <p class="tm_m0 tm_f16 tm_primary_color">Accounts Manager</p>
                  </div>
                </div> -->
              </div>
            </div>
            <div style="display:flex;justify-content: space-between; align-items:center; margin-top:50px">
              <span>Customer Signature .................................</span>
              <span>Manager Signature .................................</span>
            </div>
            <!-- <div class="tm_note tm_font_style_normal">
              <hr class="tm_mb15">
              <p class="tm_mb2"><b class="tm_primary_color">Terms & Conditions:</b></p>
              <p class="tm_m0">If you want to cancel the booking please inform us before 3 days, otherwise, you will not get any refund. <br>Invoice was created on a computer and is valid without the signature and seal.</p>
            </div> -->
          </div>
        </div>
      </div>
      <div class="tm_invoice_btns tm_hide_print">
        <a href="javascript:window.print()" class="tm_invoice_btn tm_color1">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M384 368h24a40.12 40.12 0 0040-40V168a40.12 40.12 0 00-40-40H104a40.12 40.12 0 00-40 40v160a40.12 40.12 0 0040 40h24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><rect x="128" y="240" width="256" height="208" rx="24.32" ry="24.32" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><path d="M384 128v-24a40.12 40.12 0 00-40-40H168a40.12 40.12 0 00-40 40v24" fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="32"/><circle cx="392" cy="184" r="24" fill='currentColor'/></svg>
          </span>
          <span class="tm_btn_text">Print</span>
        </a>
        <button id="tm_download_btn" class="tm_invoice_btn tm_color2">
          <span class="tm_btn_icon">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon" viewBox="0 0 512 512"><path d="M320 336h76c55 0 100-21.21 100-75.6s-53-73.47-96-75.6C391.11 99.74 329 48 256 48c-69 0-113.44 45.79-128 91.2-60 5.7-112 35.88-112 98.4S70 336 136 336h56M192 400.1l64 63.9 64-63.9M256 224v224.03" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
          </span>
          <span class="tm_btn_text">Download</span>
        </button>
      </div>
    </div>
  </div>

  <script src="{{url('backend/assets/js/invoice/jquery.min.js')}}"></script>
  <script src="{{url('backend/assets/js/invoice/jspdf.min.js')}}"></script>
  <script src="{{url('backend/assets/js/invoice/html2canvas.min.js')}}"></script>
  <script src="{{url('backend/assets/js/invoice/main.js')}}"></script>
</body>
@php

function numToWordsfinal($number) {
    $words = array(
        0 => 'zero', 1 => 'one', 2 => 'two',
        3 => 'three', 4 => 'four', 5 => 'five',
        6 => 'six', 7 => 'seven', 8 => 'eight',
        9 => 'nine', 10 => 'ten', 11 => 'eleven',
        12 => 'twelve', 13 => 'thirteen', 
        14 => 'fourteen', 15 => 'fifteen',
        16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
        19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
        40 => 'forty', 50 => 'fifty', 60 => 'sixty',
        70 => 'seventy', 80 => 'eighty',
        90 => 'ninety'
    );

    if ($number < 20) {
        return $words[$number];
    }

    if ($number < 100) {
        return $words[10 * floor($number / 10)] .
               ' ' . $words[$number % 10];
    }

    if ($number < 1000) {
        return $words[floor($number / 100)] . ' hundred ' 
               . numToWordsfinal($number % 100);
    }

    if ($number < 1000000) {
        return numToWordsfinal(floor($number / 1000)) .
               ' thousand ' . numToWordsfinal($number % 1000);
    }

    return numToWordsfinal(floor($number / 1000000)) .
           ' million ' . numToWordsfinal($number % 1000000);
}

@endphp