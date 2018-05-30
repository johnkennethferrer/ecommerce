<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ecommerce</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{!! asset('js/datatables.js') !!}" defer></script>
    <!-- jQuery 2.1.4 -->
    <script src="{!! asset('js/jquery.min.js') !!}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{!! asset('css/datatables.css') !!}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/shop">Ecommerce</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarsExampleDefault">
                    <ul class="navbar-nav m-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="/shop">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact</a>
                        </li>
                        @if(Auth::check())
                            <li class="nav-item">
                                <a class="nav-link">{{ Auth::user()->name }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/user/customer_logout">Logout</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/user/customer_register">Sign up</a>
                            </li>
                        @endif
                       
                    </ul>

                    <form class="form-inline my-2 my-lg-0">
                        <a class="btn btn-success btn-sm ml-3" href="{{ route('product.shoppingCart')}}">
                            <i class="fa fa-shopping-cart"></i> Cart
                            <span class="badge badge-light">{{ Session::has('cart') ? Session::get('cart')->totalQty : ''}}</span>
                        </a>
                    </form>

                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="row">
                 @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
