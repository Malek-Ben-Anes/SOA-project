<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Travel</title>

        <!-- Fonts -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel='stylesheet' type='text/css'>
        <link href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700" rel='stylesheet' type='text/css'>

        <!-- Styles -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        {{-- <link href="{{ elixir('css/app.css') }}" rel="stylesheet"> --}}

        <style>
            body {
                font-family: 'Lato';
            }

            .fa-btn {
                margin-right: 6px;
            }
        </style>
    </head>
    <body id="app-layout">
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
                        Travel
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/home') }}">Home</a></li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                        <li><a href="#" id="register">Login</a></li>
                        <li><a href="{{ route('freelancer.register') }}">Passenger</a></li>
                        <li><a href="{{ route('enterprise.register') }}">Travel Agency</a></li>
                        @else

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" onclick="messages()">
                                <p>{{  Auth::user()->message_list!= 0 ? Auth::user()->message_list : null }} Messages<b class="caret"></b></p>
                            </a>
                            <ul id="message-view-more"  class="dropdown-menu" style="width:360px" role="menu">
                            </ul> 
                        </li>

                        <li class="dropdown" >
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"  onclick="notifications()">
                                <p>{{  Auth::user()->notification_list!= 0 ? Auth::user()->notification_list : null }}  Notifications <b class="caret"></b></p>
                            </a>  

                            <ul id="notification-view-more"  class="dropdown-menu" style="width:360px"  role="menu" >
                            </ul> 
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    @if (  (   Auth::user()->type  )  == "freelancer"   )
                                    {{ link_to_route('freelancer.edit','Passenger Profile', [Auth::user()->user_id] ) }} 
                                    {{ link_to_route('freelancer.interested','interesting projects' ) }} 
                                    {{ link_to_route('freelancer.participated','Challenges Participation' ) }} 
                                    @else
                                    {{ link_to_route('enterprise.edit','Agency Profile', [Auth::user()->user_id] ) }} 
                                    {{ link_to_route('project.index','Projects', [Auth::user()->user_id] ) }} 
                                    {{ link_to_route('enterprise.deblocked','Customers', [Auth::user()->user_id] ) }} 
                                    @endif
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                               document.getElementById('logout-form').submit();"><i class="fa fa-btn fa-sign-out"></i>Logout</a>
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

        <div class="container">
            <div class="alert alert-success alert-dismissible hidden">
                You are now registered, you can login.
            </div>   
        </div> 

        @yield('content')

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" id="myModalLabel">Log in</h4>
                    </div>
                    <div class="modal-body">

                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>

                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>                   

                    </div>
                </div>
            </div>
        </div>

        <!-- JavaScripts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="{{ asset('js/script.js') }}" ></script>
        <script>

                                           $(function () {

                                               $('#register').click(function () {
                                                   $('#myModal').modal();
                                               });

                                               $(".register").click(function () {
                                                   $('#myModal').modal();
                                               });

                                               $(".sponsorise").click(function () {
                                                   $('#sponsorizeModal').modal();
                                               });



                                               $(document).on('submit', '#formRegister', function (e) {
                                                   e.preventDefault();

                                                   $('input+small').text('');
                                                   $('input').parent().removeClass('has-error');

                                                   $.ajax({
                                                       method: $(this).attr('method'),
                                                       url: $(this).attr('action'),
                                                       data: $(this).serialize(),
                                                       dataType: "json"
                                                   })
                                                           .done(function (data) {
                                                               $('.alert-success').removeClass('hidden');
                                                               $('#myModal').modal('toggle');
                                                           })
                                                           .fail(function (data) {
                                                               $.each(data.responseJSON, function (key, value) {
                                                                   var input = '#formRegister input[name=' + key + ']';
                                                                   $(input + '+small').text(value);
                                                                   $(input).parent().addClass('has-error');
                                                                   $('#myModal').modal('show');
                                                               });
                                                           });
                                               });

                                           });
        </script>
    </body>
</html>