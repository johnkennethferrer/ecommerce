@extends('layouts.app')

@section('content')

	@include('partials.sidebar')

	<main role="main" class="col-md-9 col-lg-9 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

		@include('partials.errors')
        @include('partials.success') 

	  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
	    <h1 class="h2"><i class="fa fa-shopping-cart"></i> Products</h1>
	    <div class="btn-toolbar mb-2 mb-md-0">
	      <div class="btn-group mr-2">
	        <button class="btn btn-primary p-3" data-toggle="modal" data-target=".add-product"><i class="fa fa-plus"></i> Add Product</button>
	        <button class="btn btn-success p-3" data-toggle="modal" data-target=".import-excel"><i class="fa fa-download"></i> Import CSV file</button>
	        <a href="{{ route('exportproduct') }}" target="_blank" class="btn btn-secondary p-3 text-white"><i class="fa fa-upload"></i> Export to Excel file</a>
	        <button class="btn btn-warning p-3 text-white" data-toggle="modal" data-target=".trashed"><i class="fa fa-trash-o"></i> Trashed</button>
	      </div>
	    </div>
	  </div>

	  <div class="table-responsive">
        <table class="table table-striped table-sm" id="table">
          <thead>
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Category</th>
              <th width="200px">Description</th>
              <th width="250px">Action</th>
            </tr>
          </thead>
          <tbody>
          	@foreach($products as $product)
            <tr>
              <td>{{ $product->id }}</td>
              <td>{{ $product->name }}</td>
              <td><span>&#8369; </span>{{ $product->price }}</td>
              <td>{{ $product->stock }}</td>
              <td>{{ $product->category->name}}</td>
              <td>
              		<textarea class="form-control" rows="3" readonly>{{ $product->description }}</textarea></td>
              <td>
              		<button class="btn btn-success" data-toggle="modal" data-target=".view_details{{$product->id}}"><i class="fa fa-eye"></i> View</button> &nbsp;
	                <a class="btn btn-primary" href="/products/{{$product->id}}/edit"><i class="fa fa-pencil-square-o"></i> Edit</a> &nbsp;
	                <button class="btn btn-danger" data-toggle="modal" data-target=".delete{{$product->id}}"><i class="fa fa-times"></i> Delete</button>

		                <!-- Modal -->
	                    <div class="modal fade bd-example-modal-lg delete{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	                      <div class="modal-dialog modal-md modal-dialog-centered">
	                        <div class="modal-content">

	                          <div class="modal-header bg-danger">
	                            <h6 class="modal-title text-white" id="exampleModalLabel">Delete product</h6>
	                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                              <span aria-hidden="true">&times;</span>
	                            </button>
	                          </div>

	                          <div class="modal-body">
	                            Are you sure do you want to delete product?
	                          </div>

	                          <div class="modal-footer">
	                             <form id="delete-form" action="{{ route('products.destroy', [$product->id]) }}" 
	                              method="POST">
	                                  <input type="hidden" name="_method" value="delete">
	                                      @csrf
	                                  <button type="submit" class="btn btn-primary">Yes</button>
	                            </form> 
	                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
	                          </div>

	                        </div>
	                      </div>
	                    </div>
	                    <!--  End modal -->

	                    <!-- Large modal / view product details -->
						<div class="modal fade bd-example-modal-lg view_details{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						  <div class="modal-dialog modal-lg" role="document">
						    <div class="modal-content">
						      <div class="modal-header bg-success text-white">
						        <h5 class="modal-title" id="exampleModalLabel">Product details</h5>
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						          <span aria-hidden="true">&times;</span>
						        </button>
						      </div>
						      <div class="modal-body">
						      	
						      	<div class="col-md-12">
						      		<div class="row">
						      			<div class="col-md-5">
							      			@if($product->image == null)
			                                <img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image">
			                                @else
			                                <img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $product->image }}">
			                                @endif
							      		</div>

							      		<div class="col-md-7">
							      			<div class="form-group">
							      				<label class="col-form-label"><strong>Product ID : </strong>{{ $product->id }}</label>
							      			</div>
							      			<div class="form-group">
							      				<label class="col-form-label"><strong>Category : </strong>{{ $product->category->name }}</label>
							      			</div>
							      			<div class="form-group">
							      				<label class="col-form-label"><strong>Product name : </strong>{{ $product->name }}</label>
							      			</div>
							      			<div class="form-group">
							      				<label class="col-form-label"><strong>Price : </strong><span>&#8369; </span>{{ $product->price }}</label>
							      			</div>
							      			<div class="form-group">
							      				<label class="col-form-label"><strong>Stock : </strong>{{ $product->stock }}</label>
							      			</div>
							      			<div class="form-group">
							      				<label class="col-form-label"><strong>Description : </strong>{{ $product->description }}</label>
							      			</div>
							      		</div>
						      		</div>
						      	</div>
						      	
						      </div>
						      	<div class="modal-footer">
						            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
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
	</main>

	<!-- Large modal / Add prodcut -->
	<div class="modal fade bd-example-modal-lg add-product" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-primary text-white">
	        <h5 class="modal-title" id="exampleModalLabel">Add product</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<form method="post" action="{{ route('products.store') }}" enctype="multipart/form-data">
              @csrf

              <div class="col-md-12">
                <div class="row">

                	  <div class="col-md-8">
	                    <div class="form-group">
	                      <label for="product-image" class="col-form-label">Image:</label>
	                      <input type="file" class="form-control" id="product-image" name="image">
	                    </div>
	                  </div>

	                  <div class="col-md-8">
	                    <div class="form-group">
	                      <label for="product-category" class="col-form-label">Category:</label>
	                      <select class="form-control" id="product-category" name="category">
	                      	@foreach($categories as $category)
	                    	<option value="{{ $category->id }}">{{ $category->name }}</option>
	                    	@endforeach
	                      </select>
	                    </div>
	                  </div>

	                  <div class="col-md-8">
	                    <div class="form-group">
	                      <label for="product-name" class="col-form-label">Product Name:</label>
	                      <input type="text" class="form-control" id="product-name" name="name" placeholder="Product name" required>
	                    </div>
	                  </div>

	                  <div class="col-md-6">
	                    <div class="form-group">
	                      <label for="price" class="col-form-label">Price:</label>
	                      <input type="number" class="form-control" id="price" name="price" placeholder="Price" required>
	                    </div>
	                  </div>

	                  <div class="col-md-6">
	                    <div class="form-group">
	                      <label for="stock" class="col-form-label">Stock:</label>
	                      <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock">
	                    </div>
	                  </div>

	                  <div class="col-md-8">
	                    <div class="form-group">
	                      <label for="description" class="col-form-label">Description:</label>
	                      <textarea class="form-control" rows="4" id="description" name="description" placeholder="Description"></textarea>
	                    </div>
	                  </div>

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

	<!-- Large modal / trash Products -->
	<div class="modal fade bd-example-modal-lg trashed" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-warning text-white">
	        <h5 class="modal-title" id="exampleModalLabel">Deleted product</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">

	      	<table class="table table-striped table-sm" id="tableTrashed">
	          <thead>
	            <tr>
	              <th>Product ID</th>
	              <th>Product Name</th>
	              <th>Price</th>
	              <th>Stock</th>
	              <th width="180px">Action</th>
	            </tr>
	          </thead>
	          <tbody>
	          	@foreach($trashedProduct as $product)
	            <tr>
	              <td>{{ $product->id }}</td>
	              <td>{{ $product->name }}</td>
	              <td>{{ $product->price }}</td>
	              <td>{{ $product->stock }}</td>	
	              <td>
	              		<a class="btn btn-success" href=""><i class="fa fa-chevron-down"></i> Restore</a> &nbsp;
		                <!-- <button class="btn btn-danger" data-toggle="modal" data-target=".delete{{$product->id}}">Force Delete</button> -->

			                <!-- Modal -->
		                    <!-- <div class="modal fade bd-example-modal-lg delete{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		                      <div class="modal-dialog modal-md modal-dialog-centered">
		                        <div class="modal-content">

		                          <div class="modal-header bg-danger">
		                            <h6 class="modal-title text-white" id="exampleModalLabel">Delete product</h6>
		                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		                              <span aria-hidden="true">&times;</span>
		                            </button>
		                          </div>

		                          <div class="modal-body">
		                            Are you sure do you want to delete product?
		                          </div>

		                          <div class="modal-footer">
		                             <form id="delete-form" action="{{ route('products.destroy', [$product->id]) }}" 
		                              method="POST">
		                                  <input type="hidden" name="_method" value="delete">
		                                      @csrf
		                                  <button type="submit" class="btn btn-primary">Yes</button>
		                            </form> 
		                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
		                          </div>

		                        </div>
		                      </div>
		                    </div> -->
		                    <!--  End modal -->
	              </td>
	            </tr>
	            @endforeach
	          </tbody>
	        </table>
	      	
	      </div>
	      	<div class="modal-footer">
	            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
	        </div>
	    </div>
	  </div>
	</div>

	<!-- Large modal / import excel -->
	<div class="modal fade bd-example-modal-lg import-excel" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-success text-white">
	        <h5 class="modal-title" id="exampleModalLabel">Import excel</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
		      	<form method="post" action="{{ route('importexcel') }}" enctype="multipart/form-data">
		        	@csrf
			      	<div class="form-group">
			      		<label for="excelfile">File (.xlxs):</label>
			      		<input id="excelfile" type="file" name="excel_file" class="form-control">
			      	</div>

			      	<div class="modal-footer">
			            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
		                <button type="submit" class="btn btn-primary"><i class="fa fa-folder-open"></i> Parse</button>
			        </div>
			    </form>		      	
		   </div>
	    </div>
	  </div>
	</div>

	<script> 
    $(document).ready( function () {
        $('#table').DataTable();
        $('#tableTrashed').DataTable();
    });
  </script>

@endsection