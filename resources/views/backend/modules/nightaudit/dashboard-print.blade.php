<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Night Audit Dashboard</title>
  <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/night-audit.css')}}">
  <style>
  .progress-bar {
    background: #34a853;
    height: 100%;
    border-radius: 8px;
    width: {{$progress}}%;
  }
  </style>
</head>
<body>
    <!-- Dashboard Section -->
  <div class="section">
    <h1>Dashboard: {{date('d-m-Y')}}</h1>
    <div style="margin-bottom:10px;">
      <b>Audit Progress Overview</b>
      <div class="progress-bar-bg">
        <div class="progress-bar"></div>
      </div>
      <span>{{$progress}}% Completed &nbsp;|&nbsp; Remaining Time: <span style="color:#e4572e;">{{$duration}} Min</span></span>
    </div>
    <div class="cards-row" style="margin-top:18px;">
      <div class="card blue">
        <span class="big">{{$room_occupied}}/{{$total_rooms}}</span>
        <div class="label">Occupancy ({{$booking_per}}%)</div>
      </div>
      <div class="card green">
        <span class="big">{{$revenue_room}}</span>
        <div class="label">Room Revenue</div>
      </div>
      <div class="card gold">
        <span class="big">{{$arrival}}</span>
        <div class="label">Arrival (Tomorrow)</div>
      </div>
      <div class="card red">
        <span class="big">{{$departure}}</span>
        <div class="label">Departure (Today)</div>
      </div>
      <div class="card green">
        <span class="big">{{$revenue_kot}}</span>
        <div class="label">F&B Revenue</div>
      </div>
    </div>
  </div>

  <!-- Audit Check List Section -->
  <div class="section">
    <h2>Audit Check List</h2>
    <ul class="checklist">
      <li><span class="checkmark">@if($guest_folio_review_status == 1) {{ '✓'; }} @endif</span>Guest Folio Review</li>
      <li><span class="checkmark">@if($room_review_status == 1) {{ '✓'; }} @endif</span>Rooms/Inventory Review</li>
      <li><span class="checkmark">@if($revenue_review_status == 1) {{ '✓'; }} @endif</span>Revenue Audit</li>
      <li><span class="checkmark">@if($closer_review_status == 1) {{ '✓'; }} @endif</span>Closure/House Keeping Review</li>
      <li><span class="checkmark">@if($f_b_audit_status == 1) {{ '✓'; }} @endif</span>F&B Audit</li>
    </ul>
  </div>

  <div class="section">
    <h2>Guest Folio Audit</h2>
    <table>
      <tr>
        <th>Room No</th>
        <th>Guest Name</th>
        <th>Status</th>
        <th>Paid</th>
      </tr>
      @foreach($roomList as $room)
      <tr>
        <td>{{$room['room']}}</td>
        <td>{{$room['name']}}</td>
        <td>{{$room['status']}}</td>
        <td>{{$room['balance']}}</td>
      </tr>
      @endforeach
    </table>
  </div>

  <div class="section">
    <h2>Revenue Audit</h2>
    <table>
      <tr>
        <th>Mode</th>
        <th>Amount</th>
        <th>Department</th>
      </tr>
      @foreach ($paymentList as $list)
      <tr>
        <td>{{$list['name']}}</td>
        <td>{{$list['amount']}}</td>
        <td>{{$list['department']}}</td>
      </tr>
      @endforeach
    </table>
  </div>

  {{-- room --}}
  <div class="section">
        <h2>Room Audit </h2>
        <div class="cards-row">
            <div class="card blue">
                <span class="big">{{$total_rooms}}</span>
                <div class="label">Rooms</div>
            </div>
            <div class="card green">
                <span class="big">{{$arrival}}</span>
                <div class="label">Checked-In</div>
            </div>
            <div class="card gold">
                <span class="big">{{$departure}}</span>
                <div class="label">Checked-out</div>
            </div>
            <div class="card red">
                <span class="big">{{$total_closure}}</span>
                <div class="label">Closure</div>
            </div>
        </div>
        <div class="cards-row">
            <div class="card green">
                <span class="big">{{$room_occupied}}</span>
                <div class="label">Occupied Rooms <span style="color:#687882;">({{$booking_per}}%)</span></div>
            </div>
            <div class="card blue">
                <span class="big">{{$room_vacant}}</span>
                <div class="label">Vacant Available <span style="color:#687882;">({{$room_vacant_per}}%)</span></div>
            </div>
            <div class="card gold">
                <span class="big">{{$block_vacant}}</span>
                <div class="label">Vacant Blocked <span style="color:#687882;">({{$block_vacant_per}}%)</span></div>
            </div>
            <div class="card red">
                <span class="big">{{$departure}}</span>
                <div class="label">Check-out (Today)</div>
            </div>
            <div class="card gold">
                <span class="big">{{$under_cleaning}}</span>
                <div class="label">Under Cleaning (Today)</div>
            </div>
        </div>
        <table>
            <tr>
                <th>Room No</th>
                <th>Status</th>
            </tr>
            @foreach ($closedRoomList as $item)
            <tr>
                <td>{{$item['room']}}</td>
                <td class="f-w-500" style="color:{{$item['color']}} ">{{$item['closure']}}</td>
            </tr>
            @endforeach
        </table>
    </div>

    <div class="section">
    <h2>KOT Audit </h2>
    <div class="cards-row">
      <div class="card blue">
        <span class="big">{{$total_revenue ?? 0}}</span>
        <div class="label">Total Revenue</div>
      </div>
      <div class="card green">
        <span class="big">{{$total_kot ?? 0}}</span>
        <div class="label">Total KOT's</div>
      </div>
      <div class="card gold">
        <span class="big">{{$total_item_order ?? 0}}</span>
        <div class="label">Total Item Orders</div>
      </div>
      <div class="card red">
        <span class="big">{{$total_cancel_order ?? 0}}</span>
        <div class="label">Cancelled KOT</div>
      </div>
    </div>
    <div class="cards-row">
      <div class="card green">
        <span class="big">{{$kots_cash ?? 0}}</span>
        <div class="label">Cash Payment <span style="color:#687882;">({{$avg_cash}}%)</span></div>
      </div>
      <div class="card blue">
        <span class="big">{{$kots_card ?? 0}}</span>
        <div class="label">Card Payment <span style="color:#687882;">({{$avg_card}}%)</span></div>
      </div>
      <div class="card gold">
        <span class="big">{{$kots_upi ?? 0}}</span>
        <div class="label">UPI <span style="color:#687882;">({{$avg_upi}}%)</span></div>
      </div>
      <div class="card red">
        <span class="big">{{$total_cancel_order ?? 0}}</span>
        <div class="label">Cancelled KOT (Today)</div>
      </div>
      <div class="card gold">
        <span class="big">{{$is_complimentary ?? 0}}</span>
        <div class="label">Complimentary KOT (Today)</div>
      </div>
    </div>
    <table>
      <tr>
        <th>Room No.</th>
        <th>Guest Name</th>
        <th>Status</th>
        <th>Amount</th>
        <th>Pending</th>
      </tr>
      @foreach ($roomKot as $item)
        <tr>
            <td>{{$item['room']}}</td>
            <td>{{$item['name']}}</td>
            <td class="font-@if($item['status'] == 'Paid') {{ 'success'}} @else{{ 'danger'}} @endif f-w-500">{{$item['status']}}</td>
            <td>{{$item['grand_total']}}</td>
            <td>{{$item['due']}}</td>
        </tr>
       @endforeach
    </table>
  </div>
  </body>
</html>