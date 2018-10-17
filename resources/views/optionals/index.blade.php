{{-- \resources\views\roles\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Roles')


@section('styles')
    <style type="text/css">
        .tdOptions {
            width: 100px !important;
        }        
    </style>
@endsection

@section('content')

<div class="col-lg-12">
    <h3><i class="fa fa-users"></i> Opcionales</h3>
    <hr>
    {!! Form::open(['route' => 'optionals.index', 'method' => 'get']) !!}
        @hasrole('Administrador')
            <div class="form-group row">
                <div class="col-md-2">
                    <a href="{{ URL::to('optionals/create') }}" class="btn btn-success">
                        Agregar
                    </a>
                </div>
                <div class="col-md-4">
                    {{ Form::text('search', null, array('class' => 'form-control', 'placeholder' => 'Ingrese su busqueda')) }}
                </div>
                <div class="col-md-2">
                    {{ Form::select('type', $arrayType, null, array('class' => 'form-control')) }}
                </div>
                <div class="col-md-2">
                    {{ Form::select('restaurants_id', $restaurants, 0, array('class' => 'form-control')) }}
                </div>
                <div class="col-md-2 text-right">
                    <input type="submit" value="Buscar" class="btn btn-primary">
                </div>
            </div>
        @else
            <div class="form-group row">
                <div class="col-md-2">
                    <a href="{{ URL::to('optionals/create') }}" class="btn btn-success">
                        Agregar
                    </a>
                </div>
                <div class="col-md-5">
                    {{ Form::text('search', null, array('class' => 'form-control', 'placeholder' => 'Ingrese su busqueda')) }}
                </div>
                <div class="col-md-3">
                    {{ Form::select('type', $arrayType, null, array('class' => 'form-control')) }}
                </div>
                <div class="col-md-2 text-right">
                    <input type="submit" value="Buscar" class="btn btn-primary">
                </div>
            </div>
        @endhasanyrole
    {!! Form::close() !!}

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Opcionales</th>
                    <th>Precio</th>
                    <th>Tipo</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($optionals as $optional)
                <tr>

                    <td>{{ $optional->name }}</td>
                    <td>$ {{ number_format($optional->price, 2, '.', ',') }}</td>
                    <td>{{ $arrayType[$optional->type] }}</td>

                    <td class="tdOptions">
                        <div style="display: inline-flex;">
                            <a href="{{ URL::to('optionals/'.$optional->id.'/edit') }}" class="btn btn-info" style="margin: 1px !important">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['optionals.destroy', $optional->id] ]) !!}
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

         {{ $optionals->links() }}

    </div>
</div>

@endsection
