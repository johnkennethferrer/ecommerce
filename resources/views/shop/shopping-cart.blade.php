@extends('shop.shopapp')

@section('content')

	@if(Session::has('cart'))
		<div class="container">
			<div class="row mb-4">
	            <div style="display: table; margin: auto;">
	                <div class="btn-group">
	                	<a href="/shopping-cart" class="btn btn-primary p-3 pl-5 pr-5">Cart</a>
						<button class="btn btn-default p-3 pl-5 pr-5">Checkout</button>
						<button class="btn btn-default p-3 pl-5 pr-5">Thank you</button>
	                </div>
	            </div>
	        </div>
			<div class="col-md-10 border p-0" style="margin:auto;">
				<h5 class="p-3 bg-secondary text-white">Your cart item/s ( {{$totalQty}} )</h5>
				<div class="col-md-12" style="overflow-y: scroll; height: 350px;">
					<table class="table table-striped table-bordered">
						<thead>
							<th width="100px">Image</th>
							<th>Product name</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Subtotal</th>
						</thead>
						<tbody>
							@foreach($products as $product)
								<tr>
									<td>
										@if($product['item']['image'] == null)
		                                	<img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image" style="height:100px; width:100px">
		                                @else
		                                	<img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $product['item']['image'] }}" style="height:100px; width:100px">
		                                @endif
		                           	</td>
		                           	<td><h5>{{ $product['item']['name'] }}</h5></td>
	                           		<td>
	                           			<h3><span class="badge badge-info"><span>&#8369; </span>{{ $product['item']['price'] }}</span></h3>
	                           		</td>	
		                           	<td><h4>
			                           		<a href="{{ route('product.reduceByOne', ['id' => $product['item']['id']] )}}" class="btn btn-danger">-</a>
			                           			<span class="badge"><h2>{{ $product['qty'] }}</h2></span>
			                           		<a href="{{ route('product.addByOne', ['id' => $product['item']['id']] )}}" class="btn btn-primary">+</a>

			                           		<a href="{{ route('product.revomeItem', ['id' => $product['item']['id']] )}}" class="btn btn-danger float-right mt-2">Remove</a>

		                           		</h4>
		                           	</td>
		                           	<td>
	                           			<h3><span class="badge badge-success"><span>&#8369; </span>{{ number_format($product['item']['price'] * $product['qty'], 2) }}</span></h3>
	                           		</td>	
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<div class="col-md-12">
					<h3><strong>Total: <span>&#8369; </span> {{ number_format($totalPrice, 2) }}</strong></h3>
				</div>
				<hr>
				<div class="col-md-6 mb-3">
					<a href="{{ route('checkout') }}" class="btn btn-success form-control" >Checkout</a>
				</div>	
			</div>
		</div>

	@else
		<div class="container">
			<div class="row">
				<div class="col-md-10 border p-0" style="margin:auto;">
					<h3 class="p-3 text-center">No items in your cart.</h3>
					<div class="col-md-12 mb-3">
						<a href="/shop" class="btn btn-success form-control">BACK TO HOME</a>
					</div>
				</div>
			</div>
		</div>
	@endif

@endsection