{{-- \resources\views\users\create.blade.php --}}
@extends('layouts.app')

@section('title', '| Agregar usuarios')

@section('content')

<div class='col-lg-12'>

    <h3><i class='fa fa-key'></i> Agregar usuarios</h3>
    <hr>

    {{ Form::open(array('url' => 'users')) }}

        <div class="form-group row">
            {{ Form::label('roles_id', 'Rol', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::select('roles_id', $roles, null, array('class' => 'form-control', 'required' => 'required', 'onchange' => 'changeRole();')) }}
            </div>
        </div>

        <div class="form-group row" id="divRestaurants" style="display: none">
            {{ Form::label('restaurants_id', 'Restaurant', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::select('restaurants_id', $restaurants, null, array('class' => 'form-control')) }}
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

        {{ Form::submit('Agregar', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}

</div>

@endsection

@section('scripts')
<script type="text/javascript">
    function changeRole() {
        if($("#roles_id").val() != 1) {
            $("#divRestaurants").show(1000);
        } else {
            $("#divRestaurants").hide(1000);
        }
    }
</script>
@endsection