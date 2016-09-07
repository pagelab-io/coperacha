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
                <li><a href="{{route('pages.about')}}">¿Qué es Coperacha?</a></li>
                <li><a href="{{route('pages.faqs')}}">FAQS</a></li>
                <li><a href="{{route('pages.contact')}}">Contacto</a></li>
                <li><a class="button create-new" href="{{route('user.create')}}">Registro</a></li>
                <li><a href="#" ng-click="showModal()">Entrar</a></li>
            @else
                <li><a href="{{route('pages.contact')}}">Contacto</a></li>
                <li><a href="{{route('moneybox.dashboard')}}">Mis Alcancías</a></li>
                <li><a class="button create-new" href="{{route('moneybox.create')}}">Crear Nueva Alcancía</a></li>
                <li>
                    <div class="logged">
                        @if(Auth::user()->person->gender === 'H')
                            <a href="{{url('/user/profile/'.Auth::user()->id)}}" class="logged-user">
                                Bienvenido<br>{{Auth::user()->person->name}}
                            </a>
                        @else
                            <a href="{{url('/user/profile/'.Auth::user()->id)}}" class="logged-user">
                                Bienvenida<br>{{Auth::user()->person->name}}
                            </a>
                        @endif
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
