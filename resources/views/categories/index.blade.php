@extends('layouts.app')

@section('content')

	@include('partials.sidebar')

	<main role="main" class="col-md-9 col-lg-9 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

		@include('partials.errors')
        @include('partials.success') 

	  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
	    <h1 class="h2"><i class="fa fa-list"></i> Categories</h1>
	    <div class="btn-toolbar mb-2 mb-md-0">
	      <div class="btn-group mr-2">
	        <button class="btn btn-primary p-3" data-toggle="modal" data-target=".add-category"><i class="fa fa-plus"></i> Add Category</button>
	        <!-- <button class="btn btn-success p-3">Import CSV file</button> -->
	      </div>
	    </div>
	  </div>

	  <div class="table-responsive">
        <table class="table table-striped table-sm" id="table">
          <thead>
            <tr>
              <th>Category ID</th>
              <th>Name</th>
              <th width="200px">Description</th>
              <th width="200px">Action</th>
            </tr>
          </thead>
          <tbody>
          	@foreach($categories as $category)
            <tr>
              <td>{{ $category->id }}</td>
              <td>{{ $category->name }}</td>
              <td>
              		<textarea class="form-control" rows="3" readonly>{{ $category->description }}</textarea></td>
              <td>
	                <a class="btn btn-primary" href="/categories/{{$category->id}}/edit"><i class="fa fa-pencil-square-o"></i> Edit</a> &nbsp;
	                <button class="btn btn-danger" data-toggle="modal" data-target=".delete{{$category->id}}"><i class="fa fa-times"></i> Delete</button>

                    <!-- Modal -->
                    <div class="modal fade bd-example-modal-lg delete{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                      <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">

                          <div class="modal-header bg-danger">
                            <h6 class="modal-title text-white" id="exampleModalLabel">Delete category</h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>

                          <div class="modal-body">
                            Are you sure do you want to delete category?
                          </div>

                          <div class="modal-footer">
                             <form id="delete-form" action="{{ route('categories.destroy', [$category->id]) }}" 
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
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
	</main>

	<!-- Large modal -->
	<div class="modal fade bd-example-modal-lg add-category" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
	    <div class="modal-content">
	      <div class="modal-header bg-primary text-white">
	        <h5 class="modal-title" id="exampleModalLabel">Add category</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <div class="modal-body">
	      	<form method="post" action="{{ route('categories.store') }}">
              @csrf

              <div class="col-md-12">
                <div class="row">

	                  <div class="col-md-8">
	                    <div class="form-group">
	                      <label for="category-name" class="col-form-label">Category Name:</label>
	                      <input type="text" class="form-control" id="category-name" name="name" placeholder="Category name" required>
	                    </div>
	                  </div>

	                  <div class="col-md-8">
	                    <div class="form-group">
	                      <label for="description" class="col-form-label">Description:</label>
	                      <textarea class="form-control" rows="4" id="description" name="description" placeholder="Description" required></textarea>
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

	<script> 
    $(document).ready( function () {
        $('#table').DataTable();
    });
  </script>

@endsection