@extends('shop.shopapp')

@section('content')


<!-- <div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/">Home</a></li>
                    <li class="breadcrumb-item"><a href="category.html">Category</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
                </ol>
            </nav>
        </div>
    </div>
</div> -->
<div class="container">
    <div class="row">
        <div class="col-md-12 bg-dark" style="height: 300px;">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="" alt="First slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src=".../800x400?auto=yes&bg=666&fg=444&text=Second slide" alt="Second slide">
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src=".../800x400?auto=yes&bg=555&fg=333&text=Third slide" alt="Third slide">
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
                <ul class="list-group">
                    @foreach($categories as $category)
                        <a href=""><li class="list-group-item">{{ $category->name }}</li></a>
                    @endforeach
                </ul>
            </div>
            
        </div>

        <div class="col-md-9 border">
            <div class="container mt-3">
                <div class="row">
                    @foreach($products as $product)
                        <div class="col-md-4 mb-4">
                            <div class="card" style="width: 100%;">
                                @if($product->image == null)
                                <img class="card-img-top image-responsive" src="{{ asset('storage/no_image.png') }}" alt="No image">
                                @else
                                <img class="card-img-top image-responsive" src="{{ asset('storage/') }}/{{ $product->image }}">
                                @endif
                              <div class="card-body">
                                <h5 class="card-title text-center">{{ $product->name }}</h5>
                                <p class="card-text text-center"><span>&#8369; </span>{{ $product->price }}</p>
                                <hr>
                                <a href="#" class="btn btn-success form-control">Add to cart</a>
                              </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>




@endsection