@extends('shop.shopapp')

@section('content')

	<div class="container">
		<div class="row">
			<div class="col-md-12 p-0 border">
				<h4 class="p-3 bg-secondary text-white">My orders</h4>
				<div class="col-md-10 mt-3" style="margin:auto;">
					<table class="table table-striped">
						<thead>
							<th>Order #</th>
							<th>Total amount</th>
							<th>Date ordered</th>
							<th>Status</th>
							<th>Action</th>
						</thead>
						<tbody>
							@foreach($transactions as $transaction)
								<tr>
									<td>{{ $transaction->id}}</td>
									<td><span>&#8369; </span> {{ number_format($transaction->total_amount, 2) }}</td>
									<td>{{ $transaction->created_at }}</td>
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
								</tr>
							@endforeach
						</tbody>
					</table>

				</div>
			</div>
		</div>
	</div>

@endsection