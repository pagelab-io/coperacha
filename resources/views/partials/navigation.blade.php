<!-- Main navigation -->
<nav class="navigation">
    <div class="container-fluid">
        <!-- Logo -->
        <a class="logo" href="/">
            <img class="img-responsive" src="/images/logo.png" alt="Coperacha | Recauda Dinero Entre Amigos">
        </a>

        <!-- List -->
        <ul class="clearfix list hidden-xs">
            <li><a href="{{route('pages.about')}}">¿Qué es Coperacha?</a></li>
            <li><a href="{{route('pages.faqs')}}">FAQS</a></li>
            <li><a href="{{route('pages.contact')}}">Contacto</a></li>
            <li><a class="button" href="{{route('user.create')}}">Crear mi Alcancía</a></li>
            <li><a href="{{route('auth')}}">Entrar</a></li>
        </ul>

        <!-- Navigation toggle -->
        <button class="navigation-toggle visible-xs">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </button>
    </div>
</nav>
