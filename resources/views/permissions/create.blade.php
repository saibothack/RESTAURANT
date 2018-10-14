{{-- \resources\views\permissions\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Agregar Permisos')

@section('content')

<div class='col-lg-12'>

    <h3><i class='fa fa-key'></i> Agregar permisos</h3>
    <hr>

    {{ Form::open(array('url' => 'permissions')) }}

        <div class="form-group row">
            {{ Form::label('name', 'Nombre', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
        </div>

        {{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

@endsection