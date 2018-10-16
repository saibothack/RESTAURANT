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
    <script src="{{ asset('js/jquery.formatCurrency-1.4.0.min.js') }}" defer></script>

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

    {{ Form::open(array('url' => 'restaurant/' . $restaurant . '/' . $table . '/client/' . $idClient . '/menu/' . $idMenu)) }}
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
                <label for="total">Total:</label>
                <label id="total">${{ number_format($menu->price, 2, '.', ',') }}</label>
                <input type="hidden" value="{{ number_format($menu->price, 2, '.', ',') }}" id="hTotal">
            </div>
        </div>
        <br>

        <div class="offset-sm-3 col-sm-6">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 card">

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
                                <p>MXN $ {{ number_format($menu->price, 2, '.', ',') }} C/U</p>
                                <input type="hidden" value="{{$menu->price}}" id="hPrice">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <label>Número de platillos</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="row">
                                            <div class="col">
                                                <input type="number" readonly="readonly" class="form-control" value="1" id="number_dish" name="number_dish">
                                            </div>
                                            <div class="col text-right">
                                                <input type="button" class="btn btn-primary" value="+" id="btnAddDish" onclick="addDish()">
                                            </div>
                                            <div class="col text-left">
                                                <input type="button" class="btn btn-primary" value="-" id="btnRemoveDish" onclick="removeDish()">
                                            </div>

                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                        function addDish() {
                                            $("#number_dish").val(parseInt($("#number_dish").val())+1);
                                            $("#btnRemoveDish").prop('disabled', false);

                                            $("#hTotal").val(parseInt($("#hPrice").val()) * parseInt($("#number_dish").val()));

                                            $("#total").html($("#hTotal").val());
                                            $('#total').formatCurrency();
                                        }

                                        function removeDish() {

                                            $("#number_dish").val(parseInt($("#number_dish").val())-1);

                                            $("#hTotal").val(parseInt($("#hPrice").val()) * parseInt($("#number_dish").val()));

                                            $("#total").html($("#hTotal").val());
                                            $('#total').formatCurrency();

                                            if (parseInt($("#number_dish").val()) > 1) {
                                                $("#btnRemoveDish").prop('disabled', false);
                                            } else {
                                                $("#btnRemoveDish").prop('disabled', true);
                                            }
                                        }

                                    </script>

                                </div>

                                <fieldset>
                                    <legend>Extras</legend>

                                    <div class="row">
                                        @foreach($selectExtras as $selectExtra)
                                            @if ($selectExtra->type == 1)
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-1">
                                                        {{ Form::checkbox('optionals[]',  $selectExtra->id, null, array('onclick' => 'checkedExtra(this);')) }}
                                                        <input type="hidden" id="{{$selectExtra->id}}" value="{{$selectExtra->price}}">
                                                    </div>
                                                    <div class="col-4">
                                                        {{ Form::label($selectExtra->name, ucfirst($selectExtra->name)) }}
                                                    </div>
                                                    <div class="col">
                                                        MXN ${{ number_format($selectExtra->price, 2, '.', ',') }}
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>

                                </fieldset>

                                <fieldset>
                                    <legend>Opcionales</legend>
                                    <div class="row">
                                        @foreach($selectExtras as $selectExtra)
                                            @if ($selectExtra->type == 2)
                                                <div class="col-sm-12">
                                                    <div class="row">
                                                        <div class="col-1">
                                                            {{ Form::checkbox('optionals[]',  $selectExtra->id, null, array('onclick' => 'checkedExtra(this);')) }}
                                                            <input type="hidden" id="{{$selectExtra->id}}" value="{{$selectExtra->price}}">
                                                        </div>
                                                        <div class="col-4">
                                                            {{ Form::label($selectExtra->name, ucfirst($selectExtra->name)) }}
                                                        </div>
                                                        <div class="col">
                                                            MXN ${{ number_format($selectExtra->price, 2, '.', ',') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach


                                    </div>

                                </fieldset>

                                <script type="text/javascript">
                                    function checkedExtra(element) {
                                        var valElement = element.value;

                                        if(element.checked) {
                                            $("#hTotal").val(parseInt($("#hTotal").val()) + parseInt($("#"+valElement).val()));

                                            $("#total").html($("#hTotal").val());
                                            $('#total').formatCurrency();

                                        } else {
                                            $("#hTotal").val(parseInt($("#hTotal").val()) - parseInt($("#"+valElement).val()));

                                            $("#total").html($("#hTotal").val());
                                            $('#total').formatCurrency();

                                        }
                                    }
                                </script>


                            </div>
                        </div>
                    </div>
                    <br>
                </div>
            </div>
        </div>

    {{ Form::close() }}
</div>
</body>
</html>
