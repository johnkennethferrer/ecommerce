@extends('layouts.app')

@section('content')

	@include('partials.sidebar')

	<main role="main" class="col-md-9 col-lg-9 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

		@include('partials.errors')
        @include('partials.success') 

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
		  <h1 class="h2"><a href="/categories">Categories/</a>Update category</h1>
		</div>

		<div class="container">
      <div class="row">
          <div class="col-md-8 mt-5">

            <form method="post" action="{{ route('categories.update', [$category->id]) }}">
            <input type="hidden" name="_method" value="put">
            @csrf
            <div class="row">
                                   
                <div class="col-md-5">
                  <div class="form-group">
                    <label for="id" class="col-form-label">Category ID:</label>
                    <input type="text" class="form-control bg-white" id="id" value="{{ $category->id }}" readonly disabled>
                  </div>
                </div>

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="category-name" class="col-form-label">Category name:</label>
                    <input type="text" class="form-control bg-white" name="name" id="category-name" value="{{ $category->name }}" placeholder="Category name" required>
                  </div>
                </div>            

                <div class="col-md-8">
                  <div class="form-group">
                    <label for="address-text" class="col-form-label">Description:</label>
                    <textarea class="form-control bg-white" rows="4" name="description" id="desciption" placeholder="Description">{{ $category->description }}</textarea>
                  </div>
                </div>


                <div class="col-md-12">
                    <div class="form-group float-right">
                      <button class="btn btn-primary float-right" type="submit">Save</button>
                    </div>
                </div>

              </div>
            </form>

          </div>

      </div>            
    </div>

	  
	</main>

@endsection