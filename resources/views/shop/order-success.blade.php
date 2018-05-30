@extends('shop.shopapp')

@section('content')

	<div class="container">
		<div class="row mb-4">
            <div style="display: table; margin: auto;">
                <div class="btn-group">
                	<a href="/shopping-cart" class="btn btn-primary p-3 pl-5 pr-5">Cart</a>
					<button class="btn btn-primary p-3 pl-5 pr-5">Checkout</button>
					<button class="btn btn-success p-3 pl-5 pr-5">Thank you</button>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-md-12 border">
				<h4 class="text-center mt-3">Thank you for ordering. Enjoy your shopping with us.</h4>
				<h4 class="text-center">Your order number is <strong>#{{$transaction->id}}</strong>.</h4>
				<h4 class="text-center">Your order status is <strong>{{$transaction->status}}</strong>.</h4>
				<div class="col-md-8 mt-3" style="margin:auto;">
					<table class="table table-striped">
						<thead>
							<th>Image</th>
							<th>Product name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Subtotal</th>
						</thead>
						<tbody>
							@foreach($orders as $order)
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
					<div class="col-md-12 mb-3">
						<a href="/shop" class="btn btn-success form-control">BACK TO HOME</a>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection