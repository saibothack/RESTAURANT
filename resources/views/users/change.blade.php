{{-- \resources\views\users\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Agregar usuarios')

@section('content')

<div class='col-lg-12'>

    <h3><i class='fa fa-key'></i> Cambiar contraseña</h3>
    <hr>

    {{ Form::open(array('url' => 'users/' . $id . '/password')) }}

        <div class="form-group row">
            {{ Form::label('password', 'Contraseña', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::password('password', null, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('password_confirmation', 'Confirmar contraseña', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::password('password_confirmation', null, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        {{ Form::submit('Confirmar', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

@endsection


