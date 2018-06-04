@extends('shop.shopapp')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-12 p-0 border">

				@include('partials.success')

				<h4 class="p-3 bg-secondary text-white">My profile</h4>
				<div class="col-md-10 mt-3" style="margin:auto;">
					
					<div class="form-group">
						<label for="name"><strong>Name :</strong></label>
						<p>{{ $profile->name }}</p>
					</div>

					<div class="form-group">
						<label for="name"><strong>Email address :</strong></label>
						<p>{{ $profile->email }}</p>
					</div>

					<div class="form-group">
						<label for="name"><strong>Contact no :</strong></label>
						<p>{{ $profile->contact_no }}</p>
					</div>

					<div class="form-group">
						<label for="name"><strong>Address :</strong></label>
						<p>{{ $profile->address }}</p>
						<button class="btn btn-primary" data-toggle="modal" data-target=".profile"><i class="fa fa-pencil-square-o"></i> Edit Profile</button>
						<a href="/user/customer_orders" class="btn btn-primary"><i class="fa fa-list"></i> My orders</a>
					</div>

				</div>
			</div>
		</div>
	</div>

	<!-- Large modal / my profile -->
	<div class="modal fade bd-example-modal-lg profile" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-primary text-white">
	        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		      	<form method="post" action="{{ route('editprofile') }}">
		        	@csrf
		        	<input type="hidden" name="id" value="{{ $profile->id }}">
		        	<div class="col-md-8">
		        		<div class="form-group">
				      		<label for="name">Name :</label>
				      		<input id="name" class="form-control" type="text" name="name" value="{{ $profile->name }}" placeholder="Name" required>
				      	</div>

				      	<div class="form-group">
				      		<label for="contact">Contact no :</label>
				      		<input id="contact" class="form-control" type="text" name="contact" value="{{ $profile->contact_no }}" placeholder="Contact no" required>
				      	</div>

				      	<div class="form-group">
				      		<label for="name">Address :</label>
				      		<textarea name="address" class="form-control" rows="3">{{ $profile->address }}</textarea>
				      	</div>
		        	</div>

			      	<div class="modal-footer">
			            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
		                <button type="submit" class="btn btn-primary"><i class="fa fa-arrow-down"></i> Save</button>
			        </div>
			    </form>		      	
		   </div>
	    </div>
	  </div>
	</div>

@endsection