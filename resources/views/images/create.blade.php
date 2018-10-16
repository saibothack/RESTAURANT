{{-- \resources\views\restaurants\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Agregar restaurant')

@section('content')

<div class='col-lg-12'>

    <h3><i class='fa fa-key'></i> Agregar platillo</h3>
    <hr>
    {{ Form::open(array('url' => 'menus')) }}

        <div class="form-group row">
            {{ Form::label(null, 'Restaurantes', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::file('image') }}
            </div>
        </div>

        {{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

@endsection
