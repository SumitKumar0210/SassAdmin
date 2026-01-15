
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>
    @if($showPerforma > 0)
      Invoice
    @else
    Performa
    @endif
  </title>
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
    color: #000 !important;
}
.color_blk{
    color: #000 !important;
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
                  <b class="tm_f30 tm_medium tm_primary_color">Tax invoice</b>
                  <p class="tm_m0"><b>Company</b> : {{$company->name}}</p>
                  <p class="tm_m0"> <b>Address</b> :{{$company->address}},<br> {{$company->state}} - {{$company->pincode}}</p>
                  <p class="tm_m0"><b>Tel-No</b> :  {{$company->mobile}}</p>
                  <p class="tm_m0"><b>GST No</b> : {{$company->gst}}</p>
                  <p class="tm_m0"><b>HSN No</b> : {{ $company->hsn }}</p> 
                </div>
                @endforeach
                <div class="scanner"><img src="{{asset('backend/assets/images/scan_me.jpg')}}" alt="Logo"></div>
            </div>
            <div class="tm_invoice_info tm_mb25">
              <div class="tm_invoice_info_right" style="width:100%">
                <div class="tm_grid_row tm_col_4 tm_col_2_sm tm_invoice_info_in tm_gray_bg tm_round_border">
                  
                  @if($showPerforma > 0)
                  <div>
                    <span class="color_blk">Bill No:</span> <br>
                    <b class="tm_primary_color">{{$created_invoice}}</b>
                  </div>
                  <div>
                    <span class="color_blk">Bill Date:</span> <br>
                    <b class="tm_primary_color">{{$invoice_date}}</b>
                  </div>
                  @endif
                  @if($basic[0]['type'] == 'Room')
                    <div>
                      <span class="color_blk">Room:</span> <br>
                      <b class="tm_primary_color">{{$basic[0]['type_number']}}</b>
                    </div>
                  @else
                    <div>
                      <span class="color_blk">Table:</span> <br>
                      <b class="tm_primary_color">{{$basic[0]['type_number']}}</b>
                    </div>
                  @endif
                  <div>
                    <span class="color_blk">Company:</span> <br>
                    <b class="tm_primary_color">{{$guest_name}} @if($company_gst != '')- {{$company_gst}} @endif</b>
                  </div>
                </div>
              </div>
            </div>
            </div>
            <div class="tm_table tm_style1">
              <div class="tm_round_border">
                <div class="tm_table_responsive">
                <table>
                  <thead>
                    <tr>
                      <th class="tm_primary_color">Sl. No</th>
                      <th class="tm_primary_color">Description</th>
                      <th class="tm_primary_color">Rate</th>
                      <th class="tm_primary_color">Qty</th>
                      <th class="tm_primary_color" style="text-align:right">Amount</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $no = 1;
                    @endphp
                    @foreach($kotList as $kot)
                    <tr>
                      <td data-label="Room Charges" style="text-align:left;color:#000;">{{$no++}}</td>
                      <td data-label="Room Charges" style="text-align:left;color:#000;"> {{$kot['item_name']}}</td>
                      <td data-label="Extra Pax Amount" style="text-align:left;color:#000;">₹ {{$kot['price']}}</td>
                      <td data-label="No Of Days" style="text-align:left;color:#000;">{{$kot['qty']}}</td>
                      <td data-label="Total" style="text-align:right;color:#000;">₹ {{$kot['total']}}</td>
                    </tr>
                    @endforeach
                    <!-- Additional rows as needed -->
                  </tbody>
                </table>
                </div>
              </div>
              <div class="tm_invoice_footer tm_mb15">
                <div class="tm_left_footer"></div>
                <div class="tm_right_footer">
                  <table class="tm_mb15">
                    <tbody>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Sub Total</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">₹ {{$total_amount}}</td>
                      </tr> 
                      @if($dicount_percentage_value > 0 && $dicount_percentage_value != '')
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Discount {{$dicount_percentage_value}}%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">₹ {{$dicount_amount_value}}</td>
                      </tr> 
                      @endif
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">CGST {{$tax_value/2}}%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">₹ {{$total_cgst_value}}</td>
                      </tr>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">SGST {{$tax_value/2}}%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">₹ {{$total_sgst_value}}</td>
                      </tr>
                      @if($round_off > 0 && $round_off != '')
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Round Off</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">₹ {{$round_off}}</td>
                      </tr>
                       @endif
                      <tr>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_gray_bg tm_radius_6_0_0_6" style="font-size:14px">Pay Amount</td>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_text_right tm_gray_bg tm_radius_0_6_6_0" style="font-size:14px">₹ {{$remaining_amount}}</td>
                      </tr> 
                    </tbody>
                  </table>
                  <!-- <p style="display:flex; align-items:center justify-content:space-between"><span>Total</span><span>$1200</span></p> -->
                  @if($remaining_amount > 0)
                  <p style="margin-top:-8px;margin-left: 17px;;color:#000;"> <b>In words :</b> {{ convertToIndianCurrency($remaining_amount) }} Only</p>
                  @endif
                </div>
              </div>
              <div class="tm_invoice_footer tm_type1">
                <div class="tm_left_footer" style="width:100%">
                    <div class="tm_invoice_info_in tm_round_border">
                        <b class="tm_primary_color">Please Notes</b>
                        <p class="tm_m0" style="margin-top:6px; font-size:12px;">The customer is liable to pay the net amount mentioned in this invoice. Any disputes are subject to Bihar jurisdiction. We appreciate your business and regret any inconvenience. Looking forward to serving you again. Thank you!
                        </p>
                        <p style="margin-top:10px;font-size:12px;margin-bottom:0;color:#000;">Assisted By : {{Auth::user()->name}}</p>
                    </div>
                </div>
              </div>
            </div>
            <div style="display:flex;justify-content: space-between; align-items:center; margin-top:50px">
              <span class="color_blk">Customer Signature .................................</span>
              <span class="color_blk">Manager Signature .................................</span>
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