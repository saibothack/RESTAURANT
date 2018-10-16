{{-- \resources\views\restaurants\edit.blade.php --}}
@extends('layouts.app')

@section('title', '| Modificar menú')

@section('content')

<div class='col-lg-12'>
    <h3><i class='fa fa-key'></i> Modificar permiso: {{$menu->name}}</h3>
    <hr>

    {{ Form::model($menu, array('route' => array('menus.update', $menu->id), 'method' => 'PUT')) }}

        <div class="form-group row">
            {{ Form::label('restaurants_id', 'Restaurantes', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::select('restaurants_id', $restaurants, null, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('title', 'Platillo', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::text('title', null, array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('description', 'Descripción', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {!! Form::textarea('description', null, array('class' => 'form-control')) !!}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('price', 'Costo', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::number('price', null, array('class' => 'form-control', 'required' => 'required', 'step' => '0.01')) }}
            </div>
        </div>

        <div class="form-group row">
            {{ Form::label('active', 'Estatus', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::select('active', $arrayStatus, '1', array('class' => 'form-control', 'required' => 'required')) }}
            </div>
        </div>

        <fieldset>
            <legend>Extras</legend>
            <div class="row">
                <div class="offset-md-1 col-md-10">
                    <div class="form-group row">
                        @foreach ($optionals as $optional)
                            <div style="width: 33.33% !important; float: left;">
                                <div style="width: 30px; float: left;">
                                    {{ Form::checkbox('optionals[]',  $optional->id, in_array($optional->id, $optionalsSelect)) }}
                                </div>
                                <div style="width: calc(100% - 30px); float: left;">
                                    {{ Form::label($optional->name, ucfirst($optional->name)) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Opcionales</legend>
            <div class="row">
                <div class="offset-md-1 col-md-10">
                    <div class="form-group row">
                        @foreach ($extras as $extra)
                            <div style="width: 33.33% !important; float: left;">
                                <div style="width: 30px; float: left;">
                                    {{ Form::checkbox('extras[]',  $extra->id, in_array($extra->id, $optionalsSelect)) }}
                                </div>
                                <div style="width: calc(100% - 30px); float: left;">
                                    {{ Form::label($extra->name, ucfirst($extra->name)) }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </fieldset>

        {{ Form::submit('Continuar', array('class' => 'btn btn-primary')) }}


    {{ Form::close() }}    
</div>

@endsection
