<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Night Audit - Room</title>
  <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/night-audit.css')}}">
</head>
<body>
    <div class="section">
        <h2>Room Audit : {{date('d-m-Y')}}</h2>
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
</body>
</html>