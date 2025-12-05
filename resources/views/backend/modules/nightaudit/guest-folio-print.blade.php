<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Night Audit - Guest Folio</title>
  <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/night-audit.css')}}">
</head>
<body>
  <div class="section">
    <h2>Guest Folio Audit: {{date('d-m-Y')}}</h2>
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
  </body>
</html>