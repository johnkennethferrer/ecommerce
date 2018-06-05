@extends('shop.shopapp')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12 p-0" style="height: 300px;">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" style="height:300px;" src="{{ asset('storage/banner/banner3.png') }}" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" style="height:300px;" src="{{ asset('storage/banner/banner4.jpg') }}" alt="Second slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" style="height:300px;" src="{{ asset('storage/banner/banner5.jpg') }}" alt="Third slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" style="height:300px;" src="{{ asset('storage/banner/banner6.jpg') }}" alt="Third slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" style="height:300px;" src="{{ asset('storage/banner/banner7.jpg') }}" alt="Third slide">
                </div>
              </div>
              <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-3 border">
            <div class="col-md-12 p-0 mt-3">
                <h6 class="text-center"><strong>CATEGORIES</strong></h6>
                <ul class="list-group">
                    @foreach($categories as $category)
                        <a href="{{ route('shop.category', ['id' => $category->id ]) }}" style="text-decoration: none;"><li class="category-link list-group-item">{{ $category->name }}</li></a>
                    @endforeach
                </ul>
            </div>
            
        </div>

        <div class="col-md-9 border">
            <div class="container mt-3">
                <div class="row border-bottom mb-3">
                  <h4 class="p-3">All Products</h4>
                </div>
                <div class="row">
                    @foreach($products as $product)
                        <a data-toggle="modal" data-target=".view_details{{$product->id}}" style="cursor: pointer;">
                        <div class="col-md-4 mb-4">
                            <div class="card" style="width: 100%; height:370px;">
                                @if($product->image == null)
                                <img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image" style="height:200px;">
                                @else
                                <img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $product->image }}" style="height:200px;">
                                @endif
                              <div class="card-body">
                                <h5 class="card-title text-center"><strong>{{ $product->name }}</strong></h5>
                                <p class="card-text text-center"><span>&#8369; </span>{{ number_format($product->price, 2) }}</p>
                                <hr>
                                <a href="{{ route('product.addToCart', ['id' => $product->id])}}" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add to cart</a>
                              </div>
                            </div>
                        </div>
                        </a>

                        <!-- Large modal / view product details -->
                        <div class="modal fade bd-example-modal-lg view_details{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                              <div class="modal-header bg-secondary text-white">
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
                                        <label class="col-form-label"><strong>Price : </strong><span>&#8369; </span>{{ number_format($product->price, 2) }}</label>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-form-label"><strong>Stock : </strong>{{ $product->stock }}</label>
                                      </div>
                                      <div class="form-group">
                                        <label class="col-form-label"><strong>Description : </strong>{{ $product->description }}</label>
                                      </div>

                                      <div class="form-group">
                                        <a href="{{ route('product.addToCart', ['id' => $product->id])}}" class="btn btn-success form-control"><i class="fa fa-plus"></i> Add to cart</a>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                
                              </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                </div>
                            </div>
                          </div>
                        </div>
                    @endforeach
                </div>

                <div class="row div-center">
                  <div class="col-md-3">
                    {!! $products->links(); !!}
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection