<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Night Audit - Revenue</title>
  <link rel="stylesheet" type="text/css" href="{{asset('backend/assets/css/night-audit.css')}}">
</head>
<body>
  <div class="section">
    <h2>Revenue Audit: {{date('d-m-Y')}}</h2>
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
  </body>
</html>