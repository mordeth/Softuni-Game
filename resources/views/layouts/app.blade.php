<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lobster:100,300,400,700">

    <link rel="stylesheet" type="text/css" href="/css/tipped/tipped.css"/>

    <!-- Add fancyBox main JS and CSS files -->
    <link rel="stylesheet" type="text/css" href="/css/jquery.fancybox.css?v=2.1.5" media="screen" />

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="/css/app.css">

    <style>
        body {
            font-family: 'Lobster';
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
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/home') }}">Home</a></li>
                    @php if( isset($properties) ) { @endphp
                    <li class="gold">{{$properties['resources']->gold}}</li>
                    <li class="food">{{$properties['resources']->food}}</li>
                    <li class="stone">{{$properties['resources']->stone}}</li>
                    <li class="wood">{{$properties['resources']->wood}}</li>
                    @php } @endphp
                    </ul>

<!-- Right Side Of Navbar -->
<ul class="nav navbar-nav navbar-right">
<!-- Authentication Links -->
@if (Auth::guest())
    <li><a href="{{ url('/login') }}">Login</a></li>
    <li><a href="{{ url('/register') }}">Register</a></li>
@else
    <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
            {{ Auth::user()->name }} <span class="caret"></span>
        </a>

        <ul class="dropdown-menu" role="menu">
            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
        </ul>
    </li>
@endif
</ul>
</div>
</div>
</nav>

@yield('content')

<!-- JavaScripts -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/js/excanvas/excanvas.js"></script>
    <![endif]-->
    <script type="text/javascript" src="/js/spinners/spinners.min.js"></script>
    <script type="text/javascript" src="/js/tipped/tipped.js"></script>
    <script type="text/javascript" src="/js/jquery.countdown.min.js"></script>
    <script type="text/javascript" src="/js/jquery.fancybox.js?v=2.1.5"></script>

    <script type="text/javascript" src="/js/scripts.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
{{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
</body>
</html>
