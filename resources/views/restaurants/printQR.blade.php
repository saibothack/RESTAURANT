{{-- \resources\views\restaurants\edit.blade.php --}}
@extends('layouts.app')

@section('title', '| Generar QR')

@section('content')

    @foreach ($urls as $url)
        <div class='col-md-12 text-center'>
            <h1>{{ $url['restaurant'] }}</h1>
        </div>
        <div class='col-md-12 text-center'>
            <h3>{{ $url['table'] }}</h3>
        </div>
        <div class='col-md-12 text-center'>
            <div class="visible-print text-center">
                <p>Escanea para realizar tu orden.</p>
                {!! QrCode::size(300)->generate(Request::url($url['url'])); !!}
                <p>Si tenes algun problema para escanear por favor dirigete a las siguiente url.</p>
                <a href="#">{{$url['url']}}</a>
            </div>
        </div>
        
        <hr style="border:1.5px dashed gray; width:100%" />

    @endforeach

@endsection
