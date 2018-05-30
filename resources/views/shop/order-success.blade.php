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
				<h4></h4>
				<h4>Thank you for ordering. Enjoy your shopping</h4>
			</div>
		</div>
	</div>

@endsection