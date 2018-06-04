@extends('layouts.app')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-6 p-0 border" style="margin:auto;">

				@include('partials.success')

				<h4 class="p-3 bg-secondary text-white">My profile</h4>
				<div class="col-md-10 mt-3" style="margin:auto;">
					
					<div class="form-group">
						<label for="name"><strong>Name :</strong></label>
						<p>{{ Auth::user()->name }}</p>
					</div>

					<div class="form-group">
						<label for="name"><strong>Email address :</strong></label>
						<p>{{ Auth::user()->email }}</p>
					</div>

					<div class="form-group">
						<label for="name"><strong>Contact no :</strong></label>
						<p>{{ Auth::user()->contact_no }}</p>
						<button class="btn btn-primary" data-toggle="modal" data-target=".profile"><i class="fa fa-pencil-square-o"></i> Edit Profile</button>
						<button class="btn btn-success" data-toggle="modal" data-target=".changepassword"><i class="fa fa-pencil-square-o"></i> Change password</button>
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
		      	<form method="post" action="">
		        	@csrf
		        	<input type="hidden" name="id" value="{{ Auth::user()->id }}">
		        	<div class="col-md-8">
		        		<div class="form-group">
				      		<label for="name">Name :</label>
				      		<input id="name" class="form-control" type="text" name="name" value="{{ Auth::user()->name }}" placeholder="Name" required>
				      	</div>

				      	<div class="form-group">
				      		<label for="contact">Contact no :</label>
				      		<input id="contact" class="form-control" type="text" name="contact" value="{{ Auth::user()->contact_no }}" placeholder="Contact no" required>
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

	<!-- Large modal / change password -->
	<div class="modal fade bd-example-modal-lg changepassword" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-success text-white">
	        <h5 class="modal-title" id="exampleModalLabel">Change password</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		      	<form method="post" action="">
		        	@csrf
		        	<input type="hidden" name="id" value="{{ Auth::user()->id }}">
		        	<div class="col-md-8">
		        		<div class="form-group">
				      		<label for="opass">Old password :</label>
				      		<input id="opass" class="form-control" type="password" name="oldpassword" placeholder="Old password" required>
				      	</div>

				     	<div class="form-group">
				      		<label for="newpass">New password :</label>
				      		<input id="newpass" class="form-control" type="password" name="newpassword" placeholder="New password" required>
				      	</div>

				      	<div class="form-group">
				      		<label for="cpass">Confirm password :</label>
				      		<input id="cpass" class="form-control" type="password" placeholder="Confirm password" required>
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