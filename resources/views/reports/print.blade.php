<!DOCTYPE html>
<html>
<head>
	<title></title>
	<!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{!! asset('js/datatables.js') !!}" defer></script>
    <!-- jQuery 2.1.4 -->
    <script src="{!! asset('js/jquery.min.js') !!}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{!! asset('css/datatables.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/font-awesome.css') !!}" rel="stylesheet">
    <link href="{!! asset('css/ionicons.css') !!}" rel="stylesheet">
</head>
<body>

<?php 
	$df = new DateTime($datefrom);
	$dff = $df->format('M d, Y');

	$dt = new DateTime($dateto);
	$dtf = $dt->format('M d, Y');
 ?>
	<div class="col-md-12">
		<div class="col-md-12 bg-secondary">
			<h2 class="text-white text-center pt-2">Sales Report</h2>
			<h5 class="text-white text-center pb-2">{{ $dff }} - {{ $dtf }}</h5>
		</div>

		<div class="col-md-12">
			<table class="table table-bordered table-striped">
				<thead>
					<th>Order #</th>
					<th>Date ordered</th>
					<th>Total amount ordered</th>
				</thead>
				<tbody>
					@foreach($sales as $sale)
						<tr>
							<td>{{ $sale->id }}</td>
							<td><?php 
			                    $datetime = new DateTime($sale->created_at);
			                    $dtformat = $datetime->format('M d, Y H:m A');
			                    echo $dtformat
			                   ?></td>
							<td><p class="float-right"><span>&#8369; </span>{{ number_format($sale->total_amount, 2) }}</p></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="col-md-5 float-right ">
        	<h5 class="bg-success p-3 text-white float-right">Total sales: <strong><u><span>&#8369; </span>{{ number_format($totalsale, 2) }}</u></strong></h5>
      	</div>
	</div>
<script>
	window.print();
</script>
</body>
</html>