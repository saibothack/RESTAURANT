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
    <h3><i class="fa fa-users"></i> Roles</h3>
    <hr>
     <div style="width: 100%; display: inline-flex; margin-bottom: 10px;">
        <div style="width: 50% !important;">
            <!-- agregar -->
            <a href="{{ URL::to('roles/create') }}" class="btn btn-success">
                Agregar
            </a>
        </div>

        {!! Form::open(['route' => 'roles.index', 'method' => 'get', 'style' => 'width: 50% !important;']) !!}
        <div style="width: 100% !important; display: inline-flex;">
            <div style="width: calc(100% - 105px) !important; margin-right: 5px; text-align: right !important;" >
                {{ Form::text('search', null, array('class' => 'form-control', 'placeholder' => 'Ingrese su busqueda')) }}
            </div>
            <div style="width: 95px !important; text-align: right !important;" >
                <input type="submit" value="Buscar" class="btn btn-primary">
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Rol</th>
                    <th>Permisos</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($roles as $role)
                <tr>

                    <td>{{ $role->name }}</td>

                    <td>{{ str_replace(array('[',']','"'),' ', $role->permissions()->pluck('name')) }}</td>
                    <td class="tdOptions">
                        <div style="display: inline-flex;">
                            <a href="{{ URL::to('roles/'.$role->id.'/edit') }}" class="btn btn-info" style="margin: 1px !important">
                                <i class="fa fa-fw fa-edit"></i>
                            </a>

                            {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $role->id] ]) !!}
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

         {{ $roles->links() }}

    </div>
</div>

@endsection