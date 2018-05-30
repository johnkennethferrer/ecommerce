@extends('shop.shopapp')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-12 p-0 border">

				@include('partials.success')

				<h4 class="p-3 bg-secondary text-white">My orders</h4>
				<div class="col-md-10 mt-3" style="margin:auto; height: 550px; overflow-y: scroll;" >
					<table class="table table-striped">
						<thead>
							<th>Order #</th>
							<th>Total amount</th>
							<th>Date ordered</th>
							<th>Status</th>
							<th width="201px">Action</th>
						</thead>
						<tbody>
							@foreach($transactions as $transaction)
								<tr>
									<td>{{ $transaction->id}}</td>
									<td><span>&#8369; </span> {{ number_format($transaction->total_amount, 2) }}</td>
									<td>
										<?php 
											$datetime = $transaction->created_at;
											$datetimeformatted = date("M d, Y H:m A", strtotime($datetime));
											echo $datetimeformatted;
										 ?>
									</td>
									<td>
										@if($transaction->status == "Pending")
											<span class="badge badge-info">Pending</span>
										@elseif($transaction->status == "Processed")
											<span class="badge badge-primary">Processed</span>
										@elseif($transaction->status == "Completed")
											<span class="badge badge-success">Completed</span>
										@elseif($transaction->status == "Cancelled")
											<span class="badge badge-danger">Cancelled</span>
										@endif
									</td>
									<td>
										<a href="{{ route('order.vieworder', ['id' => $transaction->id] )}}" class="btn btn-success">View</a>
										<button class="btn btn-danger" data-toggle="modal" data-target=".cancel{{$transaction->id}}">Cancel Order</button>
										
										<!--Cancell order modal -->

										<div class="modal fade bd-example-modal-sm cancel{{$transaction->id}}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
										  <div class="modal-dialog modal-md modal-dialog-centered">
										    <div class="modal-content">
										       	<div class="modal-header bg-danger text-white">
										        	<h5 class="modal-title" id="exampleModalLabel">New message</h5>
										        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										          	<span aria-hidden="true">&times;</span>
										        	</button>
										      	</div>
										      	<div class="modal-body">
										        	<strong>Are you sure do you want to cancel the order?</strong>
										      	</div>
										      	<div class="modal-footer">
										      		<form method="post" action="{{ route('cancelorder') }}">
										      			@csrf
										      			<input type="hidden" name="id" value="{{ $transaction->id }}">
										      			<button type="submit" class="btn btn-primary">Yes</button>
										      		</form>
										        	<button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
										      	</div>
										    </div>
										  </div>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>

@endsection