<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Flanci') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Flanci') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('freelancer.register') }}">Freelancer</a></li>
                            <li><a href="{{ route('enterprise.register') }}">Enterprise</a></li>
                        @else
                            <li>
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <p>2 Messages</p>
                            </a>
                            </li>
                           <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <p>5 Notifications <b class="caret"></b></p>
                              </a>
                              <ul class="dropdown-menu">
                                <li><a href="#">Notification 1</a></li><hr>
                                <li><a href="#">Notification 2</a></li><hr>
                                <li><a href="#">Notification 3</a></li><hr>
                                <li><a href="#">Notification 4</a></li><hr>
                                <li><a href="#">Another notification</a></li>
                              </ul>
                              </li>



                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->username }} <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>

                                     @if (  (   Auth::user()->type  )  == "freelancer"   )
                                        {{ link_to_route('freelancer.edit','Freelancer Profile', [Auth::user()->user_id] ) }} 
                                        {{ link_to_route('freelancer.interested','interesting projects', [Auth::user()->user_id] ) }} 
                                        {{ link_to_route('freelancer.participated','Challenges Participation', [Auth::user()->user_id] ) }} 
                                    @else
                                    {{ link_to_route('enterprise.edit','Enterprise Profile', [Auth::user()->user_id] ) }} 
                                    {{ link_to_route('project.index','Projects', [Auth::user()->user_id] ) }} 
                                    {{ link_to_route('enterprise.deblocked','Freelancers Deblocked', [Auth::user()->user_id] ) }} 
                                    @endif
                                    </li>
                                    <li>
                                        <a >
                                            Stats
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                    
                                </ul>

                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
