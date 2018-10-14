<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/ico_logo.png') }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    @yield('styles')
</head>
<body>
    <div id="app">

        <div class="nav-side-menu">
            <div class="brand">
                <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Laravel') }}" class="brand-logo">
                <br>
                 @if (!Auth::guest())
                    <label> {{ Auth::user()->name }}</label>
                @endif
                <div class="brand-social">
                    <div>
                        <a href="#">
                            <i class="fa fa-facebook-square fa-lg" style="margin: 5px; margin-top: 0px;"></i> 
                            Facebook
                        </a>
                    </div>
                    <div>
                        <a href="#">
                            <i class="fa fa-twitter-square fa-lg" style="margin: 5px; margin-top: 0px; "></i> Twitter
                        </a>
                    </div>
                </div>
            </div>
            <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
                <div class="menu-list">
                    <ul id="menu-content" class="menu-content collapse out">
                        @if (Auth::guest())
                            <a href="{{ route('login') }}">
                                <li>
                                    <i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp;&nbsp;Ingresar
                                </li>
                            </a>
                         @else
                            
                            <a href="{{ route('roles.index') }}">
                                <li>
                                    <i class="fa fa-unlock-alt fa-lg"></i>&nbsp;&nbsp;&nbsp;Roles
                                </li>
                            </a>
                            <a href="{{ route('permissions.index') }}">
                                <li>
                                    <i class="fa fa-key fa-lg"></i>&nbsp;&nbsp;&nbsp;Permisos
                                </li>
                            </a>
                            <a href="{{ route('restaurants.index') }}">
                                <li>
                                    <i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp;&nbsp;Restaurantes 
                                </li>
                            </a>
                            <a href="{{ route('users.index') }}">
                                <li>
                                    <i class="fa fa-user fa-lg"></i>&nbsp;&nbsp;&nbsp;Usuarios
                                </li>
                            </a>
                            <a href="{{ route('menus.index') }}">
                                <li>
                                    <i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp;&nbsp;Menu
                                </li>
                            </a>
                            <a href="#">
                                <li>
                                    <i class="fa fa-globe fa-lg"></i>&nbsp;&nbsp;&nbsp;Clientes
                                </li>
                            </a>

                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <li>
                                    <i class="fa fa-times fa-lg"></i>&nbsp;&nbsp;&nbsp;Cerrar sesión

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form> 
                                </li>
                            </a>
                            
                        @endif
                    </ul>
             </div>
        </div>
        <main class="py-4" style="left: 300px; position: absolute; width: calc(100% - 300px)">
            <div class="container">

                @if(Session::has('flash_message'))
                    <div class="container">      
                        <div class="alert alert-success"><em> {!! session('flash_message') !!}</em>
                        </div>
                    </div>
                @endif 

                @include ('errors.list')

                @yield('content')
            </div>
        </main>
    </div>
    @yield('scripts')
</body>
</html>
