<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <link rel="apple-touch-icon" sizes="180x180" href="/images/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/images/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/images/favicons/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>

        body {
            padding-top: 4.5rem;
        }

    </style>

    <script>

        $(document).ready(function(){
            setTimeout(function() {
                $('#successMessage').fadeOut();
            }, 3000); // <-- time in milliseconds
        });

    </script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>

    @if (Session::has('success'))

    <div class="container position-fixed" id="#successMessage">

        <div class="row">

            <div class="col-lg-12">

                <div class="alert alert-success" role="alert">

                    Success: {{ Session::get('success') }}

                </div><!--  end alert -->

            </div><!--  Col  -->

        </div><!--  Row  -->

    </div><!--  container  -->

    @endif
    <div id="app">
        <nav class="navbar fixed-top navbar-fixed-to navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Fall Sports <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="nav-link" href="{{ route('cross-country.index') }}">{{ __('Cross Country') }}</a>
                                <a class="nav-link" href="{{ route('football.index') }}">{{ __('Football') }}</a>
                                <a class="nav-link" href="{{ route('boysgolf.index') }}">{{ __('Boys Golf') }}</a>
                                <a class="nav-link" href="{{ route('girlsgolf.index') }}">{{ __('Girls Golf') }}</a>
                                <a class="nav-link" href="{{ route('boyssoccer.index') }}">{{ __('Boys Soccer') }}</a>
                                <a class="nav-link" href="{{ route('girlssoccer.index') }}">{{ __('Girls Soccer') }}</a>
                                <a class="nav-link" href="{{ route('volleyball.index') }}">{{ __('Volleyball') }}</a>
                            </div>
                        </li>
                        <!-- Authentication Links -->
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Winter Sports <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="nav-link" href="{{ route('boys-bowling.index') }}">{{ __('Boys Bowling') }}</a>
                                <a class="nav-link" href="{{ route('girls-bowling.index') }}">{{ __('Girls Bowling') }}</a>
                                <a class="nav-link" href="{{ route('basketball-boys.index') }}">{{ __('Boys Basketball') }}</a>
                                <a class="nav-link" href="{{ route('basketball-girls.index') }}">{{ __('Girls Basketball') }}</a>
                                <a class="nav-link" href="{{ route('swimming.index') }}">{{ __('Swimming') }}</a>
                                <a class="nav-link" href="{{ route('wrestling.index') }}">{{ __('Wrestling') }}</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Spring Sports <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="nav-link" href="{{ route('baseball.index') }}">{{ __('Baseball') }}</a>
                                <a class="nav-link" href="{{ route('boys-tennis.index') }}">{{ __('Boys Tennis') }}</a>
                                <a class="nav-link" href="{{ route('girls-tennis.index') }}">{{ __('Girls Tennis') }}</a>
                                <a class="nav-link" href="{{ route('softball.index') }}">{{ __('Softball') }}</a>
                                <a class="nav-link" href="{{ route('track.index') }}">{{ __('Track') }}</a>
                            </div>
                        </li>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @else
                            @role(['superadministrator'])
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Settings <span class="caret"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="nav-link" href="{{ route('teams.index') }}">{{ __('Teams') }}</a>
                                    <a class="nav-link" href="{{ route('years.index') }}">{{ __('Years') }}</a>
                                    <a class="nav-link" href="{{ route('users.index') }}">{{ __('Users') }}</a>
                                </div>
                            </li>
                            @endrole
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('profile.index') }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    @yield('javascript')

    <script>
        $( function() {

            $( "#datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });

            $('input').attr('autocomplete','off');
        } );

    </script>

</body>
</html>
