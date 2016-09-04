<!-- Mobile navigation dev: Modify nav bar for add option "My Moneyboxes" -->
<nav class="mobile-navigation visible-xs">
    <div class="inner">
        <!-- Navigation list -->
        <ul class="list">
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
                    <div>
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
    </div>
</nav>