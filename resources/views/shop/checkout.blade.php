@extends('shop.shopapp')

@section('content')

<div id="loader" hidden></div>

	<div class="container" id="container-checkout">
		<div class="row mb-4">
            <div style="display: table; margin: auto;">
                <div class="btn-group">
                	<a href="/shopping-cart" class="btn btn-primary p-3 pl-5 pr-5"><i class="fa fa-shopping-cart"></i> Cart <sup><i class="fa fa-check-circle"></i></sup></a>
					<button class="btn btn-success p-3 pl-5 pr-5"><i class="fa fa-money"></i> Checkout</button>
					<button class="btn btn-default p-3 pl-5 pr-5">Thank you <i class="fa fa-smile-o"></i></button>
                </div>
            </div>
        </div>
		<div class="row">
			<div class="col-md-7 border p-0">
				<h5 class="p-3 bg-secondary text-white">Checkout</h5>

				<div class="col-md-12">
					<div class="form-group">
					  <label class="col-form-label"><strong>Name:</strong></label>
					  <p>{{ Auth::user()->name}}</p>
					</div>

					<div class="form-group">
					  <label class="col-form-label"><strong>Home Address:</strong></label>
					  <p>{{ Auth::user()->address}}</p>
					</div>

					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
								  <label class="col-form-label"><strong>Email Address:</strong></label>
								  <p>{{ Auth::user()->email}}</p>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
								  <label class="col-form-label"><strong>Contact number:</strong></label>
								  <p>{{ Auth::user()->contact_no}}</p>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

			<div class="col-md-5 border p-0">
				<h5 class="p-3 bg-secondary text-white">Review Order</h5>
				<div style="overflow-y: scroll; height:200px;">
					<table class="table table-striped">
						<thead>
							<th>Product name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Subtotal</th>
						</thead>
						<tbody>
							@foreach($carts as $cart)
								<tr>
									<td>{{ $cart['item']['name']}}</td>
									<td><span>&#8369; </span> {{ number_format($cart['item']['price'], 2) }}</td>
									<td>{{ $cart['qty'] }}</td>
									<td><span>&#8369; </span> {{ number_format($cart['item']['price'] * $cart['qty'], 2) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<hr>
				<h4 class="p-3">Your total : <span>&#8369; </span> {{ number_format($total, 2) }}</h4>
				<div class="col-md-12 mb-3">
					<form action="{{ route('checkout') }}" method="post">
						@csrf
						<button class="btn btn-success form-control" id="place-order"><i class="fa fa-arrow-circle-down"></i> PLACE ORDER</button>
					</form>	
				</div>
			</div>
		</div>
	</div>

@endsection