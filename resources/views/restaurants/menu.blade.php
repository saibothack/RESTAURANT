{{-- \resources\views\restaurants\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Agregar restaurant')

@section('content')

<div class='col-lg-12'>

    <h3><i class='fa fa-key'></i> Agregar restaurant</h3>
    <hr>

    {{ Form::open(array('url' => 'restaurants')) }}

        <div class="form-group row">
            {{ Form::label('domain', 'Dominio', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::text('domain', null, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('name', 'Nombre', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::text('name', null, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('email', 'Email', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::email('email', null, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('payment_day', 'Día de cobro', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::number('payment_day', null, array('class' => 'form-control', 'required' => 'required', 'min' => '1', 'max' => '28')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('days_grace', 'Días de gracia', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::number('days_grace', null, array('class' => 'form-control', 'required' => 'required', 'min' => '1', 'max' => '30')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('tables', 'Mesas', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::number('tables', null, array('class' => 'form-control', 'required' => 'required', 'min' => '1')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('price', 'Cobro', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::number('price', null, array('class' => 'form-control', 'required' => 'required', 'step' => '0.01')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('images', 'Imagenes por platillo', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::number('images', null, array('class' => 'form-control', 'required' => 'required', 'min' => '1')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('active', 'Estatus', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::select('active', $arrayStatus, '1', array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        {{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

@endsection
