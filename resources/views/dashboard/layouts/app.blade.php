<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Coperacha | Dashboard</title>
    <meta name="description" content="Servicio online para recaudar dinero entre amigos.">
    <meta name="keywords" content="page-keywords">
    <meta name="author" content="PageLab">
    <!--<meta name="robots" content="INDEX, FOLLOW, ARCHIVE">-->
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOARCHIVE">

    <!-- Href lang -->
    <link rel="alternate" hreflang="en" href="http://coperacha.com.mx/" />

    <!-- Favicons -->
    <link rel="shortcut icon" href="/images/favicon.png">
    <link rel="icon" href="/favicons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-touch-icon-114x114.png">

    <!-- Bootstrap -->
    <link href="{{asset('/css/bootstrap.css')}}" rel="stylesheet">

    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="{{asset('/css/materialize.css')}}"  media="screen,projection"/>

    <!-- Styles -->
    <link href="{{asset('css/dashboard-100.css')}}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Google Analytics -->
</head>
<body id="app-layout">
    <aside>
        <div id="slide-out" class="side-nav fixed">
            <div class="userView">
                <a href="#!user"><img src="/images/logo.png"></a>
                <a href="#!name"><span class="white-text name">{{Auth::user()->person->name}}</span></a>
                <a href="#!email"><span class="white-text email">{{Auth::user()->username}}</span></a>
                <a href="{{ url('/dashboard/logout') }}"><span class="white-text email small">Cerrar Sesión</span></a>
            </div>
            <ul class="menu">
                <li>
                    <a class="waves-effect waves-light btn-flat {{ Request::is('dashboard') ? 'selected' : ''}}"
                    href="{{url('/dashboard')}}">Dashboard</a>
                </li>
                <li><a class="waves-effect waves-light btn-flat {{ Request::is('dashboard/users') ? 'selected' : ''}}"
                       href="{{url('/dashboard/users')}}">Usuarios</a>
                </li>
                <li><a class="waves-effect waves-light btn-flat {{ Request::is('dashboard/moneyboxes') ? 'selected' : ''}}"
                       href="{{url('/dashboard/moneyboxes')}}">Alcancías</a>
                </li>
                <li><a class="waves-effect waves-light btn-flat" href="#!">Órdenes</a></li>
            </ul>
        </div>
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
    </aside>
    <main id="main">
        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <!-- JavaScripts -->
    <script src="{{asset('/js/vendor/jquery/jquery-3.1.0.js')}}"></script>
    <script src="{{asset('/js/materialize.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.button-collapse').sideNav({
                menuWidth: 300, // Default is 240
                edge: 'left', // Choose the horizontal origin
                closeOnClick: false // Closes side-nav on <a> clicks, useful for Angular/Meteor
            });
        });

    </script>
    @yield('scripts')
</body>
</html>
