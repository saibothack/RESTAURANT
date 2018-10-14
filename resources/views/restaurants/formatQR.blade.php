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
<div id="app">

    <div class="container">

        @foreach ($urls as $url)
            <div class='col-md-12 text-center'>
                <h1>{{ $url['restaurant'] }}</h1>
            </div>
            <div class='col-md-12 text-center'>
                <h3>Mesa {{ $url['table'] }}</h3>
            </div>
            <div class='col-md-12 text-center'>
                <div class="visible-print text-center">
                    <p>Escanea para realizar tu orden.</p>
                    <img src="{{ asset($url['urlQR']) }}" align="Code QR">
                    <p>Si tenes algun problema para escanear por favor dirigete a las siguiente url.</p>
                    <a href="#">{{ $url['url'] }}</a>
                </div>
            </div>

            <hr style="border:1.5px dashed gray; width:100%" />

        @endforeach

    </div>

</div>
</body>
</html>
