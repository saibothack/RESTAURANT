{{-- \resources\views\roles\edit.blade.php --}}
@extends('layouts.app')

@section('title', '| Modificar rol')

@section('content')

<div class='col-lg-12'>
    <h3><i class='fa fa-key'></i> Modificar rol: {{$role->name}}</h3>
    <hr>

    {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}

        <div class="form-group row">
            {{ Form::label('name', 'Nombre', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
        </div>

        <h5><b>Asignar permisos</b></h5>


        <div class="form-group row">
            @foreach ($permissions as $permission)
                <div style="width: 33.33% !important; float: left;">
                    <div style="width: 30px; float: left;">
                        {{ Form::checkbox('permissions[]',  $permission->id ) }}
                    </div>
                    <div style="width: calc(100% - 30px); float: left;">
                        {{ Form::label($permission->name, ucfirst($permission->name)) }}
                    </div>
                </div>
            @endforeach
        </div>

        {{ Form::submit('Continuar', array('class' => 'btn btn-primary')) }}


    {{ Form::close() }}    
</div>

@endsection