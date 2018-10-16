{{-- \resources\views\roles\edit.blade.php --}}
@extends('layouts.app')

@section('title', '| Modificar opcionales')

@section('content')

<div class='col-lg-12'>
    <h3><i class='fa fa-key'></i> Modificar rol: {{$optional->name}}</h3>
    <hr>

    {{ Form::model($optional, array('route' => array('optionals.update', $optional->id), 'method' => 'PUT')) }}

        <div class="form-group row">
            {{ Form::label('type', 'Tipo de opción', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::select('type', $arrayType, null, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('name', 'Nombre', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::text('name', null, array('class' => 'form-control')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('price', 'Costo', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::number('price', null, array('class' => 'form-control', 'required' => 'required', 'step' => '0.01')) }}
            </div>
        </div>

        {{ Form::submit('Continuar', array('class' => 'btn btn-primary')) }}


    {{ Form::close() }}    
</div>

@endsection
