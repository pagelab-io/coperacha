<!-- Main navigation -->
<nav class="navigation">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="logo" href="{{ route('pages.index') }}">
            <img class="img-responsive" src="/images/logo.png" alt="Coperacha | Recauda Dinero Entre Amigos">
        </a>

        <!-- List -->
        <ul class="clearfix list hidden-xs" ng-controller="modalController">
            @if (Auth::guest())
                <li><a class="{{Route::current()->getName() == 'pages.about' ? 'active' : ''}}" href="{{route('pages.about')}}">¿Qué es Coperacha?</a></li>
                <li><a class="{{Route::current()->getName() == 'pages.faqs' ? 'active' : ''}}" href="{{route('pages.faqs')}}">FAQS</a></li>
                <li><a class="{{Route::current()->getName() == 'pages.contact' ? 'active' : ''}}" href="{{route('pages.contact')}}">Contacto</a></li>
                <li><a class="button create-new {{Route::current()->getName() == 'user.create' ? 'active' : ''}}" href="{{route('user.create')}}">Registro</a></li>
                <li><a href="#" ng-click="showModal()">Entrar</a></li>
            @else
                <li>
                    <a class="{{Route::current()->getName() == 'pages.contact' ? 'active' : ''}}"
                       href="{{route('pages.contact')}}">Contacto</a>
                </li>
                <li>
                    <a class="{{Route::current()->getName() == 'moneybox.dashboard' ? 'active' : ''}}"
                       href="{{route('moneybox.dashboard')}}">Mis Alcancías</a>
                </li>
                <li><a class="{{Route::current()->getName() == 'user.profile' ? 'active' : ''}}"
                       href="{{url('/user/profile/'.Auth::user()->id)}}">Mi cuenta</a>
                </li>
                <li><a class="button create-new" href="{{route('moneybox.create')}}">Crear Nueva Alcancía</a></li>
                <li>
                    <div class="logged">
                        <a href="{{url('/user/profile/'.Auth::user()->id)}}" class="logged-user">
                            Bienvenido/a<br>{{Auth::user()->person->name}}
                        </a>
                        <a href="{{url('/api/v1/auth/logout')}}" class="logout" >Cerrar sesión</a>
                    </div>
                </li>
            @endif
        </ul>
        <!-- Navigation toggle -->
        <button class="navigation-toggle visible-xs">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>
</nav>