@extends('shop.shopapp')

@section('content')

	@if(Session::has('cart'))
		<div class="container">
			<div class="col-md-8" style="margin:auto;">
				<div class="row">
					<div class="col-sm-12 col-md-12 col-md-offset-3 col-sm-offset-3">
						<h4>Your items cart</h4>
						<ul class="list-group">
							@foreach($products as $product)
								<li class="list-group-item">
									<h4><span class="badge badge-success float-right">{{ $product['qty'] }}</span></h4>
									<strong>{{ $product['item']['name'] }}</strong>
									<span class="badge badge-info"><span>&#8369; </span>{{ $product['price'] }}</span>
									<div class="btn-group">
										<button class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">Action <span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li><a href="#">Reduce by 1</a></li>
											<li><a href="#">Reduce All</a></li>
										</ul>
									</div>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12 col-md-12 col-md-offset-3 col-sm-offset-3">
						<h3><strong>Total: <span>&#8369; </span> {{ $totalPrice }}</strong></h3>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3" style="margin:auto;">
						<button class="btn btn-success form-control" type="button">Checkout</button>
					</div>
				</div>
			</div>
		</div>	
	@else
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-6 col-md-offset-3 col-sm-offset-3">
					<h2>No items in cart.</h2>
				</div>
			</div>
		</div>
	@endif

@endsection