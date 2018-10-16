{{-- \resources\views\permissions\edit.blade.php --}}
@extends('layouts.app')

@section('title', '| Modificar permissions')

@section('content')

<div class='col-lg-12'>
    <h3><i class='fa fa-key'></i> Modificar permiso: {{$permission->name}}</h3>
    <hr>

    {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}

        <div class="form-group row">
            {{ Form::label('name', 'Nombre', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
        </div>

        {{ Form::submit('Continuar', array('class' => 'btn btn-primary')) }}


    {{ Form::close() }}    
</div>

@endsection