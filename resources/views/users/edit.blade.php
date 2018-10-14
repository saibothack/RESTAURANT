{{-- \resources\views\users\edit.blade.php --}}
@extends('layouts.app')

@section('title', '| Modificar Usuario')

@section('content')

<div class='col-lg-12'>
    <h3><i class='fa fa-key'></i> Modificar usuario: {{$user->name}}</h3>
    <hr>

    {{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}

        <div class="form-group row">
            {{ Form::label('roles_id', 'Rol', array('class' => 'col-md-2 col-form-label')) }}
            <div class="col-md-10">
                {{ Form::select('roles_id', $roles, null, array('class' => 'form-control', 'required' => 'required', 'onchange' => 'changeRole();')) }}
            </div>
        </div>

        @if ($user->roles_id == 1)
            <div class="form-group row" id="divRestaurants" style="display: none">
                {{ Form::label('restaurants_id', 'Restaurant', array('class' => 'col-md-2 col-form-label')) }}
                <div class="col-md-10">
                    {{ Form::select('restaurants_id', $restaurants, null, array('class' => 'form-control')) }}
                </div>
            </div>
        @else
            <div class="form-group row" id="divRestaurants" >
                {{ Form::label('restaurants_id', 'Restaurant', array('class' => 'col-md-2 col-form-label')) }}
                <div class="col-md-10">
                    {{ Form::select('restaurants_id', $restaurants, null, array('class' => 'form-control')) }}
                </div>
            </div>
        @endif

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

        {{ Form::submit('Continuar', array('class' => 'btn btn-primary')) }}


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