<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" itemscope itemtype="http://schema.org/Thing"
      lang="en-US">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coperacha | Recauda Dinero Entre Amigos</title>

    <meta name="description" content="El servicio online para recaudar dinero entre amigos.">
    <meta name="keywords" content="page-keywords">
    <meta name="author" content="PageLab">
    <!--<meta name="robots" content="INDEX, FOLLOW, ARCHIVE">-->
    <meta name="robots" content="NOINDEX, NOFOLLOW, NOARCHIVE">

    <!-- Href lang -->
    <link rel="alternate" hreflang="en" href="{{url('/')}}"/>
    <!-- Favicons -->
    <link rel="shortcut icon" href="/images/favicon.png">
    <link rel="icon" href="/favicons/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicons/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicons/apple-touch-icon-114x114.png">

    <!-- Schema properties -->
    <meta itemprop="name" content="Coperacha">
    <meta itemprop="description" content="El servicio online para recaudar dinero entre amigos.">
    <meta itemprop="image" content="{{asset('/images/cover-laptop.png')}}">
    <meta itemprop="url" content="{{url('/')}}">

    <!-- Open Graph properties -->
    <!--<meta property="fb:app_id" content="1581295808831173">-->
    <meta property="og:site_name" content="Coperacha">
    <meta property="og:title" content="Coperacha">
    <meta property="og:description" content="El servicio online para recaudar dinero entre amigos.">
    <meta property="og:image" content="{{asset('/images/cover-laptop.png')}}">
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:type" content="website">

    <!-- Twitter integration -->
    <!--<meta name="twitter:title" content="Coperacha | Recauda Dinero Entre Amigos">
    <meta name="twitter:url" content="http://coperacha.com.mx">
    <meta name="twitter:image" content="image-url">
    <meta name="twitter:card" content="summary">-->
    <!-- Bootstrap Styles

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="{{asset('/css/bootstrap.css')}}" rel="stylesheet">

    <!-- Page Styles -->
    {{--<link href="{{ elixir('build/css/styles.min.css') }}" rel="stylesheet">--}}
    <link href="{{asset('/css/fonts.css')}}" rel="stylesheet">
    <link href="{{asset('/css/styles.css')}}" rel="stylesheet">
    <link href="{{asset('/css/styles-responsive.css')}}" rel="stylesheet">
    <link href="{{asset('/css/coperacha.css')}}" rel="stylesheet">
    <link href="{{asset('/css/slider.css')}}" rel="stylesheet">

    <!-- Custom Styles -->
    @yield('css')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>

    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>

    <![endif]-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
    <!-- Google Analytics -->
    <script>
        (function (i, s, o, g, r, a, m) {
            i['GoogleAnalyticsObject'] = r;
            i[r] = i[r] || function () {
                        (i[r].q = i[r].q || []).push(arguments)
                    }, i[r].l = 1 * new Date();
            a = s.createElement(o),
                    m = s.getElementsByTagName(o)[0];
            a.async = 1;
            a.src = g;
            m.parentNode.insertBefore(a, m)
        })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

        ga('create', 'UA-81635835-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>

<body ng-app="coperachaApp">

@include("partials.mobile-navigation")
@include("partials.navigation")

<!-- Outer wrapper -->
<div class="outer-wrapper">
    @yield("content")
    @include("partials.footer")

</div>

<!-- LoginDialogView -->
<coperacha-modal class="popup-wrapper" id="login-modal-coperacha"></coperacha-modal>

<!-- Alert Dialog -->
<div class="popup-wrapper" id="alert-modal-coperacha">
    <div class="alert-modal">
        <!-- header -->
        <div class="popup-header">
            <span id="alert-title"><!--title--></span>
        </div>

        <!-- ./header -->
        <div class="close" id="close-alert-1">x</div>

        <!-- body -->
        <div class="popup-body">
            <!-- email login -->
            <div class="email-login">
                <div id="alert-content">
                    <!--content-->
                </div>
                <button class="btn-email-login" id="close-alert-2">ACEPTAR</button>
            </div>
            <!-- email login -->
        </div>
    </div>
</div>

<!-- Alert Dialog -->

<!-- Small Alert Dialog -->
<div class="popup-wrapper" id="small-alert-modal-coperacha">
    <div class="alert-modal small">
        <!-- header -->
        <div class="popup-header">
            <span id="small-alert-title"><!--title--></span>
        </div>

        <!-- ./header -->
        <div class="close" id="close-alert-3">x</div>
        <!-- body -->

        <div class="popup-body">
            <!-- email login -->
            <div class="email-login">
                <div id="small-alert-content">
                    <!--content-->
                </div>
                <button class="btn-email-login" id="close-alert-4">ACEPTAR</button>
            </div>
            <!-- email login -->
        </div>
    </div>
</div>
<!-- Small Alert Dialog -->
<!-- Include jQuery-->
<script src="{{asset('/js/vendor/jquery/jquery-3.1.0.js')}}"></script>
<script src="{{asset('/js/vendor/jquery/jquery-ui.js')}}"></script>

<!-- Include Bootstrap Scripts -->
<!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
<!-- Page Scripts (production) -->
{{--<script src="{{ elixir('build/js/scripts.min.js') }}"></script>
<script src="{{asset('/build/js/scripts.min.js')}}"></script>--}}

<!-- Facebook SDK -->
<script src="{{asset('/js/facebook.js')}}"></script>

<!-- Angular JS -->
<script src="{{asset('/js/vendor/angular/angular.js')}}"></script>
<!-- General JS -->
<script src="{{asset('/js/general.js')}}"></script>
<script src="{{asset('/js/coperacha.js')}}"></script>
<script src="{{asset('/js/Utils.js')}}"></script>
<script src="{{asset('/js/controllers/ModalController.js')}}"></script>
<script src="{{asset('/js/controllers/RegisterController.js')}}"></script>
<script src="{{asset('/js/controllers/LoginController.js')}}"></script>
<script src="{{asset('/js/controllers/MoneyboxController.js')}}"></script>
<script src="{{asset('/js/controllers/ParticipantController.js')}}"></script>
<script src="{{asset('/js/services/RegisterService.js')}}"></script>
<script src="{{asset('/js/services/LoginService.js')}}"></script>
<script src="{{asset('/js/services/MoneyboxService.js')}}"></script>
<script src="{{asset('/js/services/ParticipantService.js')}}"></script>
<script src="{{asset('/js/directives/CoperachaModal.js')}}"></script>
<!-- Javascript Section -->
@yield('js')
</body>
</html>
