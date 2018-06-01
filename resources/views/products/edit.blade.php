@extends('layouts.app')

@section('content')

	@include('partials.sidebar')

	<main role="main" class="col-md-9 col-lg-9 px-4"><div class="chartjs-size-monitor" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>

		@include('partials.errors')
        @include('partials.success') 

		<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
		  <h1 class="h2"><a href="/products">Products/</a>Update product</h1>
		</div>

		<div class="container">
            <div class="row">
              
                <div class="col-md-9 mt-5">

                  <form method="post" action="{{ route('products.update', [$product->id]) }}">
                  <input type="hidden" name="_method" value="put">
                  @csrf
                  <div class="row">
                                         
                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="id" class="col-form-label">Product ID:</label>
                          <input type="text" class="form-control bg-white" id="id" value="{{ $product->id }}" readonly disabled>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="company" class="col-form-label">Category:</label>
                          <select class="custom-select form-control" name="category">
                            <option value="{{$product->category_id}}" selected>{{ $product->category->name }}</option>
                            @foreach($categories as $category)
                              <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>

                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="name" class="col-form-label">Product Name:</label>
                          <input type="text" class="form-control bg-white" name="name" id="name" value="{{ $product->name }}" placeholder="Name" required>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="price" class="col-form-label">Price:</label>
                          <input type="number" class="form-control bg-white" name="price" id="price" value="{{ $product->price }}" placeholder="Price" required>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group">
                          <label for="stock" class="col-form-label">Stock:</label>
                          <input type="number" class="form-control bg-white" name="stock" id="stock" value="{{ $product->stock }}" placeholder="Stcok" required>
                        </div>
                      </div>             

                      <div class="col-md-8">
                        <div class="form-group">
                          <label for="description" class="col-form-label">Description:</label>
                          <textarea class="form-control bg-white" rows="3" name="description" id="description" placeholder="Description">{{ $product->description }}</textarea>
                        </div>
                      </div>

                      <div class="col-md-12">
                          <div class="form-group float-right">
                            <button class="btn btn-primary float-right" type="submit"><i class="fa fa-arrow-down"></i> Save</button>
                          </div>
                      </div>

                    </div>
                  </form>

                </div>

                <div class="col-md-2">
                  <div class="col-md-12 border p-0" style="height:160px;">
                    @if($product->image == null)
                      <img src=" {{ asset('storage/no_image.png') }}" class="form-control p-0" style="width:100%; height: 100%;">
                    @else
                      <img src=" {{ asset('storage/') }}/{{ $product->image }}" class="form-control p-0" style="width:100%; height: 100%;">
                    @endif
                  </div>
                  <div class="col-md-12 mt-2 p-0">

                    <form method="post" action="{{ route('update_image') }}" enctype="multipart/form-data" class="d-inline">
                      @csrf
                      <input type="hidden" name="productId" value="{{ $product->id }}">
                      <input type="file" name="uploadImage" class="form-control" id="choose_file" style="display: none;" required>
                      <button class="btn btn-success mt-2" id="save_image" onclick="save_image()" style="display: none;">SAVE</button>
                    
                    </form>

                    <button class="btn btn-primary ml-5" id="edit_image" onclick="edit_image()"><i class="fa fa-pencil-square-o"></i> EDIT</button>
                    <button class="btn btn-danger mt-2" id="cancel_image" onclick="cancel_image()" style="display: none;">CANCEL</button>

                  </div>
                </div>

            </div>            
          </div>
	</main>

  <script>
    //edit function
    function edit_image() {
      $("#save_image").show(500);
      $("#cancel_image").show(500);
      $('#choose_file').show(500);
      $("#edit_image").hide(500);
    }

    //cancel function
    function cancel_image() {
      $("#save_image").hide(500);
      $("#cancel_image").hide(500);
      $("#edit_image").show(500);
      $('#choose_file').hide(500);
    }   
  </script>

@endsection