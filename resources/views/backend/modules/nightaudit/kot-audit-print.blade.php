<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Night Audit - KOT</title>
  <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/night-audit.css')}}">
</head>
<body>
  <!-- KOT Audit Section -->
  <div class="section">
    <h2>KOT Audit : {{date('d-m-Y')}}</h2>
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
