<!DOCTYPE html>
<html>

<head>
	<title>Check-in and Check-out Report</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<style>
		section {
			padding: 0px 50px;
		}

		.img-logo,
		h4 {
			text-align: center;
		}

		.heading {
			text-align: center;
			margin: 0;
			word-spacing: 10px;
			font-size: 24px;
			font-weight: bold;
            font-family: "Nunito Sans", sans-serif;
		}

		.heading-border {
			width: 430px;
			margin: 0px auto;
		}

		.heading-border2 {
			width: 465px;
			margin: 10px auto;
		}

		.heading-border3 {
			width: 156px;
			margin: 0px auto;
		}

		.heading2 {
			/* word-spacing: 5px; */
			/* letter-spacing: 1px; */
			margin: 0;
			text-decoration: underline;
			font-size: 17px;
			font-weight: bold;
			font-family: "Nunito Sans", sans-serif;

		}

		.heading3 {
			margin: 0;
			font-family: "Nunito Sans", sans-serif;
			font-weight: bold;
			font-size: 12px;
		}

		.sub-heading {
			text-align: center;
			margin: 18px 0 0 0;
			font-size: 12px;
			font-family: "Nunito Sans", sans-serif;

		}

		.heading-border4 {
			border: 1px dashed rgba(34, 34, 34, 0.83);
		}

		.sub-heading2 {
			float: right;
			font-size: 12px;
			ont-family: "Nunito Sans", sans-serif;
			margin-right: 31px;
		}

		.sub-heading1 {
			margin: 10px 0;
			font-size: 12px;
			ont-family: "Nunito Sans", sans-serif;
		}

		.sub-heading3 {
			float: right;
			text-align: right;
			margin: -30px 0px;
			font-size: 12px;
			ont-family: "Nunito Sans", sans-serif;
		}

		.table-text {
			font-size: 12px;
		}

		.bold {
			font-weight: 700;
			color: #000;
			border: 1px solid;
			font-size: 10px;
		}

		.notes-pragraph {
			font-style: italic;
		}

		.notes-pragraph h5 {
			font-size: 12px;
			font-weight: bold;
			font-family: "Nunito Sans", sans-serif;
		}

		.notes-pragraph p {
			font-size: 10px;
			font-family: "Nunito Sans", sans-serif;
		}

		.word-title {
			padding: 20px 0 0 0;
			font-size: 12px;
			font-family: "Nunito Sans", sans-serif;
		}

		.word-title label {
			padding: 20px 0 0 0;
			font-size: 12px;
			ont-family: "Nunito Sans", sans-serif;
		}

		.footer-text {
			text-align: center;
			margin: 0;
			line-height: 15px;
		}

		.footer-text .text-add {
			font-size: 12px;
			font-family: "Nunito Sans", sans-serif;
		}

		.footer-text .text-add1 {
			font-size: 8px;
			font-family: "Nunito Sans", sans-serif;
		}

		.text-add,
		.text-add1 {
			margin: 0;
			line-height: 16px;
		}

		table,
		th {
			border: 1px solid black;
			border-collapse: collapse;
			text-align: left;
			font-size: 10px;
			font-weight: bold;
			font-family: "Nunito Sans", sans-serif;
		}

		table {
			border-left: 1px solid black;
			border-top: 1px solid black;
			border-right: 1px solid black;
			border-collapse: collapse;
			text-align: left;
		}

		table td {
			border: 1px solid black;
			font-size: 12px;
			ont-family: "Nunito Sans", sans-serif;
			font-weight: normal;
		}

		th,
		td {
			padding: 5px;
			font-family: "Nunito Sans", sans-serif;
			font-size: 12px;
		}
	</style>
	<script type="text/javascript">
		// window.print()
	</script>
</head>

<body>
    
	<section>
		<div class="img-logo">
			 <img class="img-fluid for-light" src="{{ asset('backend/'.$company[0]->logo.'')}}" style="height: 50px;" alt="logo">
		</div>
		{{-- <h1 class="heading">HOTLR</h1> --}}
		<hr class="heading-border" />
		<hr class="heading-border" />
		<br>
		<h4 class="heading2">Check-in & Check-out report ( {{date('d/m/Y')}} )</h4>
		<br>
		<table style="width:100%;text-align: center;" class="invoice_table">
            <thead>
                <tr>
                    <th style="text-align: center;">Sr.No</th>
                    <th style="text-align: center;">Reservation ID</th>
                    <th style="text-align: center;">Room No.</th>
                    <th style="text-align: center;">Room Category</th>
                    <th style="text-align: center;">Guest Name</th>
                    <th style="text-align: center;">Phone Number</th>
                    <th style="text-align: center;">No Of Pax </th>
                    <th style="text-align: center;">CheckIn Date</th>
                    <th style="text-align: center;">CheckIn Time</th>
                    <th style="text-align: center;">CheckOut Date</th>
                    <th style="text-align: center;">CheckOut Time</th>
                </tr>
            </thead>
            <tbody>
                @php
                   $no = 1;     
                @endphp 
                @foreach ($reservationList as $item) 
                    <tr>
                        <td style="text-align: center;">{{ $no++ }}</td>
                        <td style="text-align: center;">{{ $item['reservation'] }}</td>
                        <td style="text-align: center;">{{ $item['room_number'] }}</td>
                        <td style="text-align: center;">{{ $item['room_type'] }}</td>
                        <td style="text-align: center;">{{ $item['primary_guest'] }}</td>
                        <td style="text-align: center;">{{ $item['contact_number'] }}</td>
                        <td style="text-align: center;">{{ $item['no_of_person'] }}</td>
                        <td style="text-align: center;">{{ $item['check_in_date'] }}</td>
                        <td style="text-align: center;">{{ $item['check_in_time'] }}</td>
                        @if($item['check_out_date'] == '01-01-1970')
                            <td></td></td></td>    
                        @else
                            <td style="text-align: center;">{{ $item['check_out_date'] }}</td>
                            <td style="text-align: center;">{{ $item['check_out_time'] }}</td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
		</table>
	</section>
</body>

</html>