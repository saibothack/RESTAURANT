{{-- \resources\views\restaurants\edit.blade.php --}}
@extends('layouts.app')

@section('title', '| Generar QR')

@section('content')

<div class='col-lg-12'>
    <h3><i class='fa fa-key'></i> QR Restaurante</h3>
    <hr>

    {{ Form::open(array('url' => 'restaurants/QR/'.$id)) }}

        <h3>Por favor seleccione las mesas para generar su Código QR</h3>

        <div class="form-group row">
            @for ($i = 1; $i < $numTables; $i++)
                <div class="col-md-3">
                    <div class="row">
                        <div class="col-md-2">
                            <input type="checkbox" name="tables[]" value="{{ $i }}">
                        </div>
                        <div class="col-md-2">
                            <label for="tables">Mesa </label>
                        </div>
                        <div class="col-md-2">
                            <label for="tables">{{ $i }}</label>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        {{ Form::submit('Continuar', array('class' => 'btn btn-primary')) }}


    {{ Form::close() }}    
</div>

@endsection
