@extends('shop.shopapp')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-12 p-0 border">
				<h4 class="p-3 bg-secondary text-white">Order list of order <strong>#{{$transaction->id}}</strong>.</h4>
				<h5 class="pl-3">Status : 
										@if($transaction->status == "Pending")
											<span class="badge badge-info"><h5>Pending</h5></span>
										@elseif($transaction->status == "Processed")
											<span class="badge badge-primary"><h5>Processed</h5></span>
										@elseif($transaction->status == "Completed")
											<span class="badge badge-success"><h5>Completed</h5></span>
										@elseif($transaction->status == "Cancelled")
											<span class="badge badge-danger"><h5>Cancelled</h5></span>
										@endif
				</h5>
				<div class="col-md-10 mt-3" style="margin:auto;">
					<table class="table table-striped">
						<thead>
							<th>Image</th>
							<th>Product name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Subtotal</th>
						</thead>
						<tbody>
							@foreach($orderlists as $order)
								<tr>
									<td>
										@if($order->image == null)
		                                	<img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image" style="height:100px; width:100px">
		                                @else
		                                	<img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $order->image }}" style="height:100px; width:100px">
		                                @endif
									</td>
									<td>{{ $order->name }}</td>
									<td><span>&#8369; </span> {{ $order->price }}</td>
									<td>{{ $order->quantity }}</td>
									<td><span>&#8369; </span> {{ number_format($order->price * $order->quantity, 2) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<hr>
					<h4 class="p-3">Total amount : <span>&#8369; </span> {{ number_format($transaction->total_amount, 2) }}</h4>
					<div class="col-md-8 mb-3" style="margin:auto;">
						<a href="/user/customer_orders" class="btn btn-success form-control">BACK TO ORDER</a>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection