{{-- \resources\views\menus\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Menús')


@section('styles')
    <style type="text/css">
        .tdOptions {
            width: 100px !important;
        }        
    </style>
@endsection

@section('content')

<div class="col-lg-12">
    <h3><i class="fa fa-users"></i>Menús</h3>
    <hr>
     
    {!! Form::open(['route' => 'menus.index', 'method' => 'get']) !!}
    <div class="form-group row">
        <div class="col-md-2">
            <a href="{{ URL::to('menus/create') }}" class="btn btn-success">
                Agregar
            </a>
        </div>
        <div class="col-md-4">
            {{ Form::text('search', null, array('class' => 'form-control', 'placeholder' => 'Ingrese su busqueda')) }}
        </div>
        <div class="col-md-2">
            {{ Form::select('active', $arrayStatus, null, array('class' => 'form-control')) }}
        </div>
        <div class="col-md-2">
            {{ Form::select('restaurants_id', $restaurants, 0, array('class' => 'form-control')) }}
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
                    <th>Restaurante</th> 
                    <th>Titulo</th>
                    <th>Precio</th>
                    <th>Existencia</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($menus as $menu)
                <tr>
                    <td>{{ $restaurants[$menu->restaurants_id] }}</td>
                    <td>{{ $menu->title }}</td>
                    <td>$ {{ number_format($menu->price, 2, '.', ',') }}</td>
                    <td>{{ $arrayStatus[$menu->active] }}</td>

                    <td class="tdOptions">
                        <div style="display: inline-flex;">
                            <a href="{{ URL::to('menus/'.$menu->id.'/images') }}" class="btn btn-primary" style="margin: 1px !important">
                                <i class="fa fa-file-image-o" aria-hidden="true"></i>
                            </a>

                            <a href="{{ URL::to('menus/'.$menu->id.'/edit') }}" class="btn btn-info" style="margin: 1px !important">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['menus.destroy', $menu->id] ]) !!}
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

         {{ $menus->links() }}

    </div>
</div>

@endsection
