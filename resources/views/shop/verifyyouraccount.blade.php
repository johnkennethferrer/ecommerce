@extends('shop.shopapp')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-10 p-0" style="margin:auto;">
				<h3 class="p-3 text-center">Successfully register your account.</h3>
				<h4 class="p-3 text-center">Verify your account. Check you gmail account for verification.</h4>
				<div class="div-center">
					<a href="https://www.google.com/gmail/" target="_blank"><img style="width:100px; height:100px;" src="{{ asset('storage/gmail.png') }}"></a> 
				</div>
				<div class="col-md-8 mb-3" style="margin:auto;">
					<a href="/shop" class="btn btn-success form-control"><i class="fa fa-home"></i> BACK TO HOME</a>
				</div>
			</div>
		</div>
	</div>

@endsection