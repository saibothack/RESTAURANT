{{-- \resources\views\users\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Usuarios')


@section('styles')
    <style type="text/css">
        .tdOptions {
            width: 100px !important;
        }        
    </style>
@endsection

@section('content')

<div class="col-lg-12">
    <h3><i class="fa fa-users"></i>Usuarios</h3>
    <hr>

    {!! Form::open(['route' => 'users.index', 'method' => 'get']) !!}
    <div class="form-group row">
        <div class="col-md-2">
            <a href="{{ URL::to('users/create') }}" class="btn btn-success">
                Agregar
            </a>
        </div>
        <div class="col-md-3">

        </div>
        <div class="col-md-5">
            {{ Form::text('search', null, array('class' => 'form-control', 'placeholder' => 'Ingrese su busqueda')) }}
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
                    <th>Email</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>

                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>

                    <td class="tdOptions">
                        <div style="display: inline-flex;">
                            <a href="{{ URL::to('users/'.$user->id.'/edit') }}" class="btn btn-info" style="margin: 1px !important">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id] ]) !!}
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

         {{ $users->links() }}

    </div>
</div>

@endsection