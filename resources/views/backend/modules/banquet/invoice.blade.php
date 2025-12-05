
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <!-- Site Title -->
  <title>Banquet Invoice</title>
  <link rel="stylesheet" href="{{asset('backend/assets/invoice/assets/css/style.css')}}">
 
</head>

<body>
  <div class="tm_container" style="font-size: 12px;">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_content">
            <div class="tm_invoice_head tm_mb30">
              <div class="tm_invoice_left">
                <div class="tm_logo">
                  {{-- <img src="{{asset('backend/assets/invoice/assets/img/logo.svg')}}" alt="Logo"> --}}
                  <img src="{{ asset('backend/'.$company[0]->logo.'')}}" alt="Logo">
                </div>
              </div>
              <div class="tm_invoice_right tm_text_right">
                <b class="tm_f30 tm_medium tm_primary_color">Tax Invoice</b>
                <p class="tm_m0">Invoice Number - {{$company[0]->invoice_prefix}}BQ0{{$banquet_bookings[0]->id}}</p>
              </div>
            </div>
            <div class="tm_invoice_info">
              <div class="tm_invoice_info_left">
                <p class="tm_mb17">
                  <b class="tm_f18 tm_primary_color">{{$company[0]->name}}</b> <br>
                  {{$company[0]->address}},<br>{{$company[0]->state}}<br>
                  @if($company[0]->email != '')
                    {{$company[0]->email}}<br>
                  @endif
                  @if($company[0]->mobile != '')
                    {{$company[0]->mobile}}
                  @endif
                </p>
              </div>
              <div class="tm_invoice_info_right tm_text_right">
                 <p class="tm_mb17" style="text-align: left; position: absolute; right:0;">
                  <b class="tm_f18 tm_primary_color">{{$banquet_bookings[0]->client_name}}</b> <br>
                  {{$banquet_bookings[0]->contact_no}}  @if($banquet_bookings[0]->comapny_gst != '') <br>{{$banquet_bookings[0]->comapny_gst}} <br>{{$banquet_bookings[0]->company_name}}<br>{{$banquet_bookings[0]->comapny_address}} @endif
                </p>
              </div>
            </div>
            <div class="tm_grid_row tm_col_4 tm_col_2_sm tm_invoice_info_in tm_gray_bg tm_round_border tm_mb25">
                  <div>
                    <span>Booking ID:</span> <br>
                    <b class="tm_primary_color">BQ0{{$banquet_bookings[0]->event_id}}</b>
                  </div>
                  <div>
                    <span>Event Date:</span> <br>
                    <b class="tm_primary_color">{{date('d-m-Y',strtotime($banquet_bookings[0]->event_date))}}</b>
                  </div>
                  <div>
                    <span>Event Type:</span> <br>
                    <b class="tm_primary_color">{{$banquet_bookings[0]->event_name}}</b>
                  </div>
                  
                  <div>
                    <span>Start Time:</span> <br>
                    <b class="tm_primary_color">{{ date("g:i A", strtotime($banquet_bookings[0]->start_time))}}</b>
                  </div>
                  <div>
                    <span>End Time:</span> <br>
                    <b class="tm_primary_color">{{ date("g:i A", strtotime($banquet_bookings[0]->end_time))}}</b>
                  </div>
                  <div>
                    <span>Expected Guests:</span> <br>
                    <b class="tm_primary_color">{{$banquet_bookings[0]->expected_guest_count}}</b>
                  </div>
                  <div>
                    <span>Hall Name:</span> <br>
                    <b class="tm_primary_color">{{$banquet_bookings[0]->hall_name}}</b>
                  </div>
                  {{-- <div>
                    <span>Hall Area / Capacity:</span> <br>
                    <b class="tm_primary_color">{{$banquet_bookings[0]->hall_capacity}}</b>
                  </div> --}}
                </div> 
            </div>
            <div class="tm_table tm_style1">
              <div class="tm_round_border" style="margin-bottom:10px;">
                <div class="tm_table_responsive">
                  <table>
                    <thead>
                      <tr>
                        <th class="tm_width_1 tm_semi_bold tm_primary_color">S NO</th>
                        <th class="tm_width_4 tm_semi_bold tm_primary_color">Description</th>
                        <th class="tm_width_3 tm_semi_bold tm_primary_color">Rate (₹)</th>
                        <th class="tm_width_3 tm_semi_bold tm_primary_color tm_text_right">Total (₹)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="tm_width_1">1</td>
                        <td class="tm_width_4">Hall Charges	</td>
                        <td class="tm_width_3">{{$banquet_bookings[0]->hall_rate}}</td>
                        <td class="tm_width_3 tm_text_right">{{$banquet_bookings[0]->discount_amount}}</td>
                      </tr>
                      @if(count($banquet_menu_items) > 0)
                        <tr>
                          <td colspan="4" class="tm_width_12 tm_gray_bg tm_semi_bold">Menu</td>
                        </tr>
                        @php
                          $i = 1;
                          $ii = 1; 
                        @endphp
                        @foreach ($banquet_menu_items as $menu_items)
                          <tr>
                            <td class="tm_width_2">{{$i}}</td>
                            <td class="tm_width_5">{{$menu_items->menuCategoryData->name}}</td>
                            <td class="tm_width_3">{{$menu_items->item_name}}</td>
                            <td class="tm_width_2 tm_text_right">{{date("g:i A", strtotime($menu_items->serve_time))}}</td>
                          </tr>
                          @php
                            $i++;
                          @endphp
                        @endforeach
                      @endif
                      @if(count($banquet_accesories) > 0)
                        <tr>
                          <td colspan="4" class="tm_width_12 tm_gray_bg tm_semi_bold">Stationary Accessories</td>
                        </tr>
                        @foreach ($banquet_accesories as $accesories)
                          <tr>
                            <td class="tm_width_2">{{$ii}}</td>
                            <td class="tm_width_5">{{$accesories->accesories_name}}</td>
                            <td class="tm_width_2">{{$accesories->accesories_rate}} * {{$accesories->accesories_qty}}</td>
                            <td class="tm_width_3 tm_text_right">₹ {{$accesories->accesories_amount}}</td>
                          </tr>
                          @php
                            $ii++;
                          @endphp
                        @endforeach
                      @endif
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tm_invoice_footer tm_mb15">
                <div class="tm_left_footer">
                  @if(count($paymentList) > 0)
                  <p class="tm_mb2"><b class="tm_primary_color">Payment info:</b></p>
                  <div class="tm_round_border">
                    <div class="tm_table_responsive1">
                      <table>
                        <thead>
                          <tr>
                            <th class="tm_width_2 tm_semi_bold tm_primary_color">Date</th>
                            <th class="tm_width_2 tm_semi_bold tm_primary_color">Amount</th>
                            <th class="tm_width_2 tm_semi_bold tm_primary_color">Mode</th>
                            <th class="tm_width_2 tm_semi_bold tm_primary_color">Received By</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach($paymentList as $list)
                            <tr >
                              <td class="tm_width_2">{{$list['date']}}</td>
                              <td class="tm_width_2">{{$list['amount']}}</td>
                              <td class="tm_width_2">{{$list['mode']}}</td>
                              <td class="tm_width_2">{{$list['received_by']}}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                  @endif
                </div>
                <div class="tm_right_footer">
                  <table class="tm_mb15">
                    <tbody>
                      @if($banquet_bookings[0]->total_food_charge > 0)
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">F&B Charges</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt5">₹ {{$banquet_bookings[0]->total_food_charge}}</td>
                      </tr>
                      @endif
                      @if($banquet_bookings[0]->extra_room_charge > 0)
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Extra Room Charges</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">₹ {{$banquet_bookings[0]->extra_room_charge}}</td>
                      </tr>
                      @endif
                      @if($banquet_bookings[0]->sub_total > 0)
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtoal</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">₹ {{$banquet_bookings[0]->sub_total}}</td>
                      </tr>
                      @endif
                      @if($banquet_bookings[0]->total_discount > 0)
                      <tr>
                        <td class="tm_width_3 tm_danger_color tm_border_none tm_pt0">Discount (₹)</td>
                        <td class="tm_width_3 tm_danger_color tm_text_right tm_border_none tm_pt0">-₹ {{$banquet_bookings[0]->total_discount}}</td>
                      </tr>
                      @endif
                      @if($banquet_bookings[0]->total_amount > 0)
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Total Amount</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">+₹ {{$banquet_bookings[0]->total_amount}}</td>
                      </tr>
                      @endif
                      @if($banquet_bookings[0]->gst_amount > 0)
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">CGST ({{($banquet_bookings[0]->gst)/2}}%)</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">+₹ {{($banquet_bookings[0]->gst_amount)/2}}</td>
                      </tr>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">SGST ({{($banquet_bookings[0]->gst)/2}}%)</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">+₹ {{($banquet_bookings[0]->gst_amount)/2}}</td>
                      </tr>
                      @endif
                      @if($banquet_bookings[0]->adjustment > 0)
                      <tr>
                        <td class="tm_width_3 tm_danger_color tm_border_none tm_pt0">Adjustment</td>
                        <td class="tm_width_3 tm_danger_color tm_text_right tm_border_none tm_pt0">-₹ {{$banquet_bookings[0]->adjustment}}</td>
                      </tr>
                      @endif
                      <tr>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_gray_bg tm_radius_6_0_0_6">Grand Total	</td>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_text_right tm_gray_bg tm_radius_0_6_6_0">₹ {{$banquet_bookings[0]->grand_total}}</td>
                      </tr>
                    </tbody>
                  </table>
                  <p style="margin-top:-8px;margin-left: 17px;"> <b>In words :</b> {{ convertToIndianCurrency($banquet_bookings[0]->grand_total) }}</p>
                </div>
              </div>
              <div class="tm_invoice_footer tm_type1">
                <div class="tm_left_footer"></div>
                <div class="tm_right_footer">
                  <div class="tm_sign tm_text_center">
                    <img src="assets/img/sign.svg" alt="">
                    <p class="tm_m0 tm_ternary_color">{{$users[0]->name}}</p>
                    <p class="tm_m0 tm_f16 tm_primary_color">{{$users[0]->designation}}</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="tm_note tm_text_center tm_font_style_normal">
              <hr class="tm_mb15">
              <p class="tm_mb2"><b class="tm_primary_color">Terms & Conditions:</b></p>
              <p class="tm_m0">If you want to cancel the booking please inform us before 3 days, otherwise, you will not get any refund. <br>Invoice was created on a computer and is valid without the signature and seal.</p>
            </div><!-- .tm_note -->
             <div style="display:flex;justify-content: space-between; align-items:center; margin-top:50px">
              <span>Customer Signature .................................</span>
              <span>Manager Signature .................................</span>
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
  <script src="{{asset('backend/assets/invoice/assets/js/jquery.min.js')}}"></script>
  <script src="{{asset('backend/assets/invoice/assets/js/jspdf.min.js')}}"></script>
  <script src="{{asset('backend/assets/invoice/assets/js/html2canvas.min.js')}}"></script>
  <script src="{{asset('backend/assets/invoice/assets/js/main.js')}}"></script>

</body>