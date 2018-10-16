<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/ico_logo.png') }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

</head>
<body>
    <div class="container">
        <br>
        <div class="row">
            <div class="offset-md-6 col-md-1 text-center">
                <h1>Menú</h1>
            </div>
            <div class="offset-md-2 col-md-2 text-right">
                <i class="fa fa-cart-plus fa-3x" aria-hidden="true"></i>
            </div>
        </div>
        <br>

        <div class="row">
            @foreach ($menus as $menu)
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="offset-sm-3 col-sm-8 card">

                                @if(count($menu->join) > 0)
                                <div class="card-img-top">
                                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @foreach($menu->join as $image)
                                                <li data-target="#carouselExampleIndicators" data-slide-to="{{$loop->index}}" @if($loop->index==0) class="active" @endif ></li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach($menu->join as $image)
                                                <div class="carousel-item @if($loop->index==0) active @endif">
                                                    <img class="d-block w-100" src="{{ asset('images/menu/' . $image->path) }}" alt="{{$image->path}}">
                                                </div>
                                            @endforeach
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
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title">{{ $menu->title  }}</h5>
                                    <p class="card-text">{{ $menu->description  }}</p>
                                    <p>MXN ${{ number_format($menu->price, 2, '.', ',') }}</p>
                                    <a href="#" class="btn btn-primary">Ordenar</a>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>
            @endforeach
        </div>
        <br>
    </div>
</body>
</html>
