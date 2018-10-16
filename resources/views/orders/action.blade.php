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
    <div class='col-lg-12'>

        <h3><i class='fa fa-key'></i> Agregar permisos</h3>
        <hr>

        <div class="row">
            <div class="col-sm-12 text-center">
                <label>¿Que acción desea realizar?</label>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 text-center">
                <a href="{{ URL::to('restaurant/' . $restaurant . '/' . $table . '/client/' . $idClient) }}" class="btn btn-primary">Seguir ordenando</a>
            </div>
            <div class="col-sm-6 text-center">
                <input type="button" value="Finalizar" class="btn btn-success">
            </div>
        </div>
    </div>
</div>
</body>
</html>
