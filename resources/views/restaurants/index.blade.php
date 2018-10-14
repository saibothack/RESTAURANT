{{-- \resources\views\restaurants\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Restaurantes')


@section('styles')
    <style type="text/css">
        .tdOptions {
            width: 100px !important;
        }        
    </style>
@endsection

@section('content')

<div class="col-lg-12">
    <h3><i class="fa fa-users"></i>Restaurantes</h3>
    <hr>
     
    {!! Form::open(['route' => 'restaurants.index', 'method' => 'get']) !!}
    <div class="form-group row">
        <div class="col-md-2">
            <a href="{{ URL::to('restaurants/create') }}" class="btn btn-success">
                Agregar
            </a>
        </div>
        <div class="col-md-5">
            {{ Form::text('search', null, array('class' => 'form-control', 'placeholder' => 'Ingrese su busqueda')) }}
        </div>
        <div class="col-md-3">
            {{ Form::select('active', $arrayStatus, null, array('class' => 'form-control')) }}
        </div>
        <div class="col-md-2 text-right">
            <input type="submit" value="Buscar" class="btn btn-primary">
        </div>
    </div>
    {!! Form::close() !!}

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Día Cobro</th>
                    <th>Cargo</th>
                    <th>Estatus</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($restaurants as $restaurant)
                <tr>
                    <td>{{ $restaurant->name }}</td>
                    <td>{{ $restaurant->payment_day }}</td>
                    <td>$ {{ number_format($restaurant->price, 2, '.', ',') }}</td>
                    <td>{{ $arrayStatus[$restaurant->active] }}</td>

                    <td class="tdOptions">
                        <div style="display: inline-flex;">
                            <a href="{{ URL::to('restaurants/QR/'.$restaurant->id) }}" class="btn btn-primary" style="margin: 1px !important">
                                <i class="fa fa-print" aria-hidden="true"></i>
                            </a>
                            <a href="{{ URL::to('restaurants/'.$restaurant->id.'/edit') }}" class="btn btn-info" style="margin: 1px !important">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['restaurants.destroy', $restaurant->id] ]) !!}
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

         {{ $restaurants->links() }}

    </div>
</div>

@endsection
