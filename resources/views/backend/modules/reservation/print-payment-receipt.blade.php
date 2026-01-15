
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Hotel Booking</title>
  {{-- <link rel="stylesheet" href="{{url('backend/assets/css/invoice/style.css')}}"> --}}
    <link rel="stylesheet" href="{{asset('backend/assets/invoice/assets/css/style.css')}}">
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
@media print{
  body, * {
      color: #000 !important;
  }
}
</style>
<body>
  <div class="tm_container" style="font-size:13px">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_content">
            <div class="header">
                <div class="logo-img"><img src="{{ asset('backend/'.$hotlr[0]->logo.'')}}" alt="Logo"></div>
                @foreach($hotlr as $company)
                <div class="tax-invoice">
                  <b class="tm_f30 tm_medium tm_primary_color">Advance Voucher</b>
                  <p class="tm_m0"><b>Company</b> : {{$company->name}}</p>
                  <p class="tm_m0"> <b>Address</b> :{{$company->address}},<br> {{$company->state}} - {{$company->pincode}}</p>
                  <p class="tm_m0"><b>Tel-No</b> :  {{$company->mobile}}</p>
                  <p class="tm_m0"><b>GST No</b> : {{$company->gst}}</p>
                  <p class="tm_m0"><b>HSN No</b> : {{ $company->hsn }}</p> 
                </div>
                @endforeach
                <div class="scanner"><img src="{{asset('backend/assets/images/scan_me.jpg')}}" alt="Logo"></div>
            </div>
            <div class="tm_grid_row tm_col_2 tm_invoice_info_in tm_round_border tm_mb30" style="grid-template-columns: repeat( 2, 1fr);">
                <div class=" tm_border_none_sm">
                    <b class="tm_primary_color">Date : {{ $paymentDetail['date'] }}</b>
                    <p class="tm_m0">Receipt No : {{ $paymentDetail['id'] }}</p>
                    <p class="tm_m0">Name : {{ $paymentDetail['name'] }}</p>
                    <p class="tm_m0">Room No : {{ $paymentDetail['room'] }}</p>
                    <p class="tm_m0">Mode : {{ $paymentDetail['mode'] }}</p>
                    <p class="tm_m0">Rupees : {{ $paymentDetail['amount'] }}</p>
                    <p class="tm_m0">Amount In Words : {{ $paymentDetail['in_word'] }} Only</p>
                </div>
            </div>
            <div style="display:flex;justify-content: space-between; align-items:center; margin-top:50px">
              <span>Receiver Signature </span>
              <span>Manager Signature </span>
              <span>Managing Particular </span>
            </div>
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