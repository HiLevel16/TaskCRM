<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="app">
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light justify-content-between">
                <a class="navbar-brand" href="{{ url('/') }}">
                    MightyCRM
                </a>

                <div class="navbar-nav navbar-right">
                    @guest
                        <li class="nav-item"><a href="{{ route('login') }}">Login</a></li>
                    @endguest

                    @auth
                        @foreach(\App\Menu::getMenu() as $menu_item)
                            <li class="nav-item {{isset($menu_item['sub']) ? 'dropdown' : ''}}">
                                <a class="nav-link {{isset($menu_item['sub']) ? 'dropdown-toggle' : ''}}" {{isset($menu_item['sub']) ? 'id=navbarDropdown data-toggle=dropdown role=button aria-expanded=false' : ''}} href="{{route($menu_item['route'])}}">
                                    {{$menu_item['label']}}
                                </a>
                                @if(isset($menu_item['sub']))
                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        @foreach($menu_item['sub'] as $subMenuItem)
                                            <a class="dropdown-item" href="{{ route($subMenuItem['route']) }}">
                                                {{ $subMenuItem['label'] }}
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </li>
                        @endforeach
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" id="navbarDropdown2" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                    Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    @endauth
                </div>
            </nav>
        </header>

        <main>
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="container mt-1">
                        <div class="row">
                            <div class="col-md-12 col-md-offset-1">
                                <div class="alert alert-danger" role="alert">
                                    {{ $error }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
            @if(Session::has('success'))
                <div class="container mt-1">
                    <div class="row">
                        <div class="col-md-12 col-md-offset-1">
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="container">
                @yield('content')
            </div>
        </main>
    </div>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
