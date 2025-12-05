
<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
  <!-- Meta Tags -->
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="author" content="Laralink">
  <!-- Site Title -->
  <title>Hotel Booking Invoice</title>
  {{-- <link rel="stylesheet" href="assets/css/style.css"> --}}
  <link rel="stylesheet" href="{{url('backend/assets/css/invoice/style.css')}}">
</head>

<body>
  @php
   $checkinDate = new DateTime($reservationRoomDetails[0]->checkin);
   $checkoutDate = new DateTime($reservationRoomDetails[0]->checkout);
   $interval = $checkinDate->diff($checkoutDate);
   $interval_in_days = $interval->days;
   $room_amount = $reservationRoomDetails[0]->amount;
   $total_room_amount = $room_amount * $interval_in_days;
  @endphp
  <div class="tm_container">
    <div class="tm_invoice_wrap">
      <div class="tm_invoice tm_style2" id="tm_download_section">
        <div class="tm_invoice_in">
          <div class="tm_invoice_content">
            <div class="tm_invoice_head tm_mb30">
              <div class="tm_invoice_left">
                <div class="tm_logo"><img src="{{url('backend/assets/images/logo/logo_dark.png')}}" alt="Logo"></div>
              </div>
              <div class="tm_invoice_right tm_text_right">
                <b class="tm_f30 tm_medium tm_primary_color">Invoice</b>
                <p class="tm_m0">Invoice Number - RS0{{$reservationRoomDetails[0]->id}}</p>
                <p class="tm_m0">Invoice Date - {{$curr_date}}</p>
              </div>
            </div>
            <div class="tm_invoice_info tm_mb25">
              <div class="tm_invoice_info_left">
                <p class="tm_mb17">
                  <b class="tm_f18 tm_primary_color">Hotel Yuvraj Deluxe</b> <br>
                 Barauni Zero Mile, Barauni - Purnea Highway, Begusarai, Bihar 851126<br>
                  test@gmail.com <br>
                  +91 123 456 7890
                </p>
              </div>
              <div class="tm_invoice_info_right">
                <div class="tm_grid_row tm_col_3 tm_col_2_sm tm_invoice_info_in tm_gray_bg tm_round_border">
                  <div>
                    <span>Check In:</span> <br>
                    <b class="tm_primary_color">{{$reservationRoomDetails[0]->checkin}}</b>
                  </div>
                  <div>
                    <span>Check Out:</span> <br>
                    <b class="tm_primary_color">{{$reservationRoomDetails[0]->checkout}}</b>
                  </div>
                  <div>
                    <span>Booking ID:</span> <br>
                    <b class="tm_primary_color">{{$reservationRoomDetails[0]->reservation_id}}</b>
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
                    <b class="tm_primary_color">{{$reservationRoomDetails[0]->room_alloted}}/{{$reservationRoomDetails[0]->room_type}}</b>
                  </div>
                </div>
              </div>
            </div>
            <div class="tm_grid_row tm_col_2 tm_invoice_info_in tm_round_border tm_mb30">
              <div class="tm_border_right tm_border_none_sm">
                <b class="tm_primary_color">Guest Info</b>
                <p class="tm_m0">Name: {{$reservationDetails[0]->name}} <br>Phone: {{$reservationDetails[0]->mobile}}</p>
              </div>
              <div>
                <b class="tm_primary_color">Address:</b>
                <p class="tm_m0">#{{$reservationDetails[0]->address}}</p>
                <p class="tm_m0">Email: {{$reservationDetails[0]->email}}</p>
              </div>
            </div>
            <div class="tm_table tm_style1">
              <div class="tm_round_border">
                <div class="tm_table_responsive">
                  <table>
                    <thead>
                      <tr>
                        <th class="tm_width_6 tm_semi_bold tm_primary_color">Description</th>
                        <th class="tm_width_4 tm_semi_bold tm_primary_color">Rate</th>
                        <th class="tm_width_2 tm_semi_bold tm_primary_color tm_text_right">Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      <tr>
                        <td class="tm_width_6">Room Charges	</td>
                        <td class="tm_width_4">₹{{$room_amount}} X {{$interval_in_days}} Nights</td>
                        <td class="tm_width_2 tm_text_right">₹{{$total_room_amount}}</td>
                      </tr>
                      <tr>
                        <td class="tm_width_6">Breakfast</td>
                        <td class="tm_width_4">₹00.00 X 0 Days</td>
                        <td class="tm_width_2 tm_text_right">₹00</td>
                      </tr>
                      <tr>
                        <td class="tm_width_6">Service Fee (Included VAT)</td>
                        <td class="tm_width_4">₹00</td>
                        <td class="tm_width_2 tm_text_right">₹00</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tm_invoice_footer tm_mb15">
                <div class="tm_left_footer">
                  <p class="tm_mb2"><b class="tm_primary_color">Payment info:</b></p>
                  <p class="tm_m0">Name: {{$reservationDetails[0]->name}} <br>Method: Cash</p>
                </div>
                <div class="tm_right_footer">
                  <table class="tm_mb15">
                    <tbody>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_bold">Subtoal</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_bold">₹{{$total_room_amount}}</td>
                      </tr>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Discount 0%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">-₹00</td>
                      </tr>
                      <tr>
                        <td class="tm_width_3 tm_primary_color tm_border_none tm_pt0">Tax 0%</td>
                        <td class="tm_width_3 tm_primary_color tm_text_right tm_border_none tm_pt0">+₹00</td>
                      </tr>
                      <tr>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_gray_bg tm_radius_6_0_0_6">Grand Total	</td>
                        <td class="tm_width_3 tm_border_top_0 tm_bold tm_f18 tm_primary_color tm_text_right tm_gray_bg tm_radius_0_6_6_0">₹{{$total_room_amount}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tm_invoice_footer tm_type1">
                <div class="tm_left_footer">
                    <div class="tm_invoice_info_in tm_round_border">
                        <b class="tm_primary_color">Room & Service Details:</b>
                        <p class="tm_m0">Room service is a hotel service enabling guests to choose items of food and drink for delivery to their hotel room for consumption.</p>
                    </div>
                </div>
                <div class="tm_right_footer">
                  <div class="tm_sign tm_text_center">
                    <img src="{{url('backend/assets/images/logo/logo_dark.png')}}" alt="Sign">
                    <p class="tm_m0 tm_ternary_color">Mr.Kundan</p>
                    <p class="tm_m0 tm_f16 tm_primary_color">Accounts Manager</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="tm_note tm_font_style_normal">
              <hr class="tm_mb15">
              <p class="tm_mb2"><b class="tm_primary_color">Terms & Conditions:</b></p>
              <p class="tm_m0">If you want to cancel the booking please inform us before 3 days, otherwise, you will not get any refund. <br>Invoice was created on a computer and is valid without the signature and seal.</p>
            </div><!-- .tm_note -->
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
  <!--<script src="{{url('backend/assets/js/invoice/html2canvas.min.js')}}"></script>-->
  <script src="{{url('backend/assets/js/invoice/main.js')}}"></script>
</body>