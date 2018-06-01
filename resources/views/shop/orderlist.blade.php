@extends('shop.shopapp')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-12 p-0 border">
				<h4 class="p-3 bg-secondary text-white">Order list of order <strong>#{{$transaction->id}}</strong>.</h4>

				@if($transaction->status == "Pending")
					<div class="col-md-12 mb-5 mt-3"> 
						<div class="row"  style="display: flex; justify-content: center;">
							<button class="btn btn-success rounded-circle" style="padding-left:18px; padding-right: 18px;"><i class="fa fa-check-circle"></i></button>
							<div class="left-status">Pending</div>
							<div class="col-md-2 p-0">
								<div class="progress mt-3">
									<div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
							<button class="btn btn-default rounded-circle p-4"></button>
							<div class="centered-status">Processed</div>
							<div class="col-md-2 p-0">
								<div class="progress mt-3">
									<div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>	
							<button class="btn btn-default rounded-circle p-4"></button>
							<div class="right-status">Completed</div>
						</div>
					</div>
				@elseif($transaction->status == "Processed")
					<div class="col-md-12 mb-5 mt-3"> 
						<div class="row"  style="display: flex; justify-content: center;">
							<button class="btn btn-success rounded-circle" style="padding-left:18px; padding-right: 18px;"><i class="fa fa-check-circle"></i></button>
							<div class="left-status">Pending</div>
							<div class="col-md-2 p-0">
								<div class="progress mt-3">
									<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
							<button class="btn btn-success rounded-circle" style="padding-left:18px; padding-right: 18px;"><i class="fa fa-check-circle"></i></button>
							<div class="centered-status">Processed</div>
							<div class="col-md-2 p-0">
								<div class="progress mt-3">
									<div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>	
							<button class="btn btn-default rounded-circle p-4"></button>
							<div class="right-status">Completed</div>
						</div>
					</div>
				@elseif($transaction->status == "Completed")
					<div class="col-md-12 mb-5 mt-3"> 
						<div class="row"  style="display: flex; justify-content: center;">
							<button class="btn btn-success rounded-circle" style="padding-left:18px; padding-right: 18px;"><i class="fa fa-check-circle"></i></button>
							<div class="left-status">Pending</div>
							<div class="col-md-2 p-0">
								<div class="progress mt-3">
									<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>
							<button class="btn btn-success rounded-circle" style="padding-left:18px; padding-right: 18px;"><i class="fa fa-check-circle"></i></button>
							<div class="centered-status">Processed</div>
							<div class="col-md-2 p-0">
								<div class="progress mt-3">
									<div class="progress-bar bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
								</div>
							</div>	
							<button class="btn btn-success rounded-circle" style="padding-left:18px; padding-right: 18px; padding-top:13px; padding-bottom:13px;"><i class="fa fa-check-circle"></i></button>
							<div class="right-status">Completed</div>
						</div>
					</div>
				@elseif($transaction->status == "Cancelled")
					<div class="col-md-12 mb-5 mt-3"> 
						<div class="row"  style="display: flex; justify-content: center;">
							<h4>You <span class="badge badge-danger">Cancelled</span> this order.</h4>
						</div>
					</div>
				@elseif($transaction->status == "Rejected")
					<div class="col-md-12 mb-5 mt-3"> 
						<div class="row"  style="display: flex; justify-content: center;">
							<h4>Your order has been <span class="badge badge-warning text-white">Rejected</span> by the administrator.</h4>
						</div>
					</div>
				@endif

				<div class="col-md-10 mt-5" style="margin:auto;">
					<div style="overflow-y: scroll; height: 300px;">
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
					</div>
					<hr>
					<h4 class="p-3">Total amount : <span>&#8369; </span> {{ number_format($transaction->total_amount, 2) }}</h4>
					<div class="col-md-8 mb-3" style="margin:auto;">
						<a href="/user/customer_orders" class="btn btn-success form-control"><i class="fa fa-chevron-left"></i> BACK TO ORDER</a>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection