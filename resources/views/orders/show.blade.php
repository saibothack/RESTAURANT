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
        <br>
        <div class="row">
            <div class="col text-left">
                <a href="{{ URL::to('restaurant/' . $restaurant . '/' . $table . '/client/' . $idClient) }}" class="btn btn-danger">Regresar</a>
            </div>
            <div class="col text-right">
                <input type="submit" value="Continuar" class="btn btn-success">
            </div>
        </div>
        <div class="row">
            <div class="col text-center">
                <h1>Orden</h1>
            </div>
        </div>
        <div class="row">
            <div class="col text-right">

            </div>
        </div>
        <hr>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Platillo</th>
                    <th>Precio</th>
                    <th>Opciones</th>
                </tr>
                </thead>

                <tbody>
                @foreach ($data as $dat)
                    <tr>
                        <td>{{ $dat['name'] }}</td>
                        <td>{{ $dat['price'] }}</td>
                        <td class="tdOptions">
                            <div class="text-right" style="display: inline-flex;">
                                {{ Form::open(array('url' => 'restaurant/' . $restaurant . '/' . $table . '/client/' . $idClient . '/detail/'. $loop->index)) }}
                                <button class="btn btn-danger" type="submit" style="margin-right: 1px !important">
                                    <i class="fa fa-fw fa-trash"></i>
                                </button>
                                {!! Form::close() !!}
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
</body>
</html>
