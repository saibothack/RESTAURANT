{{-- \resources\views\menus\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Menús')


@section('styles')
    <style type="text/css">
        .tdOptions {
            width: 100px !important;
        }        
    </style>
@endsection

@section('content')

<div class="col-lg-12">
    <h3><i class="fa fa-users"></i>Menús</h3>
    <hr>
    <div>
        <a href="{{ URL::to('menus') }}" class="btn btn-primary">
            Regresar
        </a>
    </div>


    @if($showAddFile)
        {{ Form::open(array('url' => 'menus/' . $id . '/images', 'files'=>'true', 'class' => 'row')) }}

                {{ Form::label(null, 'Imagen', array('class' => 'offset-md-2 col-md-1 col-form-label')) }}
                <div class="col-md-5">
                    {{ Form::file('image', array('class' => 'form-control')) }}
                </div>
                <div class="col-md-2 text-center">
                    {{ Form::submit('Agregar', array('class' => 'btn btn-success')) }}
                </div>
        {{ Form::close() }}
    @endif

    <br>
    <div class="row">
        @foreach ($images as $image)
            <div class="col-sm-4 card">
                <img src="{{ asset('images/menu/' . $image->path) }}" class="card-img-top" alt="Cinque Terre">
                <div class="card-body">
                    {!! Form::open(array('url' => 'menus/' . $id . '/images/'.$image->id)) !!}
                    <input name="_method" type="hidden" value="DELETE">
                    <button class="btn btn-danger" type="submit" style="margin-right: 1px !important">
                        <i class="fa fa-fw fa-trash"></i>
                    </button>
                    {!! Form::close() !!}
                </div>
            </div>
        @endforeach
    </div>
</div>

@endsection
