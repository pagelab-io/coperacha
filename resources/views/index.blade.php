@extends("layouts.master")

@section('css')
    <link rel="stylesheet" href="{{asset("/js/vendor/bootstrap-select-1.11.2/bootstrap-select.css")}}">
@endsection

@section("navigation")
    @include("partials.navigation2")
@endsection

@section("content")
    <!-- Cover -->
    <div class="block cover img-category">
        <div class="holder row">
            <div class="container-fluid">
                <div class="row">
                    <div class="hidden-xs col-sm-6 col-md-6 align-middle">
                        <div class="header-block">
                            <div>LA SOLUCIÓN MÁS SENCILLA PARA ORGANIZAR TU FIESTA</div>
                        </div>
                        <div class="content-block">
                            <div class="html">
                                <div>Coperacha es un servicio de gestión de dinero que sirve para hacer regalos o transferencias entre amigos.</div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden-xs col-sm-6 col-md-6 align-middle">
                        <div class="moneybox-form">
                            <div class="moneybox-form-title">
                                MOTIVO DE LA ALCANCÍA
                            </div>
                            <form class="form-create-moneybox" data-mode="{{Auth::guest() ? 'guest' : 'logged'}}">
                                <div class="form-group clearfix">
                                    <select name="categories"
                                            id="moneybox-categories"
                                            data-width="301px"
                                            class="element-moneybox">
                                    <option data-icon="g-icon-party" value="2" selected>
                                        Fiesta
                                    </option>
                                    <option data-icon="g-icon-birthday" value="1">Cumpleaños</option>
                                    <option data-icon="g-icon-wedding" value="4">Boda</option>
                                    <option data-icon="g-icon-party" value="8">Despedida de solter@</option>
                                    <option data-icon="g-icon-travels" value="3">Viaje</option>
                                    <option data-icon="g-icon-proyecto" value="9">Proyecto</option>
                                    <option data-icon="g-icon-emergencies" value="6">Solidaridad</option>
                                    <option data-icon="g-icon-baby" value="5">Baby Shower</option>
                                    <option data-icon="g-icon-party" value="12">Roomates</option>
                                    <option data-icon="g-icon-cafe" value="13">Grandes ideas</option>
                                    <option data-icon="g-icon-others" value="7">Otro</option>
                                </select>
                                </div>
                                <div class="form-group">
                                    <label for="beneficiario" class="element-moneybox">Nombre del creador</label>
                                    <input id="nombre_creador"
                                           name="beneficiario"
                                           class="element-moneybox"
                                           type="text"
                                           data-clue="Requerido"
                                           placeholder="Ejemplo: Martín"/>
                                </div>
                                <div class="form-group">
                                    <label for="alcancia" class="element-moneybox">Nombre de la alcancía</label>
                                    <input id="nombre_alcancia"
                                           name="alcancia"
                                           class="element-moneybox"
                                           data-clue="Requerido"
                                           type="text"
                                           placeholder="Ejemplo: Fiesta despedida Martín"/>
                                </div>
                                <button id="btn-moneybox-form"
                                        class="button btn btn-primary button-moneybox-create">
                                    Crear mi alcancía
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="col-xs-12 hidden-sm hidden-md hidden-lg align-middle moneybox-mobile">
                        <div class="header-block">
                            <div>EL SERVICIO ONLINE PARA RECAUDAR DINERO ENTRE AMIGOS</div>
                        </div>
                        <a class="button btn btn-primary button-moneybox-create" ng-click="showModal('/moneybox/create')">Crear mi Alcancía</a>
                    </div>
                </div>
            </div>
            <!--<img src={{asset("/images/google_play.png")}} class="google-play-button"/>-->
        </div>
    </div>
    <!-- Section Payment Methods -->
    <section class="block steps">
        <div class="holder">
            <div class="container-fluid">
                <div class="content-block">
                    <div class="row">
                        <div class="col-xs-4 steps-text">
                            CREA
                            </div>
                        <div class="col-xs-4 steps-text">
                        <span class="glyphicon glyphicon-play"></span>
                        RECAUDA
                        </div>
                        <div class="col-xs-4 steps-text">
                        <span class="glyphicon glyphicon-play"></span>
                            UTILIZA
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Intro -->
    <section class="block intro" id="intro">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <h2 class="title white">Alcancías para cualquier ocasión</h2>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="">
                            <div class="moneyboxes">
                                @foreach ($categories as $category)
                                    <div class="moneybox-type">
                                        <div class="title">{{$category->name}}</div>
                                        <img class="img-responsive" src="{{$category->path}}" alt="{{$category->name}}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="video">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/142285041?title=0&byline=0&portrait=0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                            </div>
                            <a id="btnShareFb" class="btn-share-fb">
                                <span>Compartir en</span>
                                <img src="images/facebook-logo.png" alt="">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section How it Works -->
        <section class="block how-it-works" id="como-funciona">
            <div class="holder">
                <div class="container-fluid">
                    <div class="header-block">
                        <h2 class="title">¿Cómo funciona?</h2>
                    </div>
                    <div class="content-block">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6 align-top">
                                <div class="card">
                                    <div class="image">
                                        <img class="img-responsive center-block" src="/images/how-it-works-card-1.png" alt="">
                                    </div>
                                    <div class="name">
                                        <a class="button" ng-click="showModal('/moneybox/create')">1. Crea tu Alcancía</a>
                                    </div>
                                    <div class="desc">Es gratis y te llevará un minuto crearla.</div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6 align-top">
                                <div class="card">
                                    <div class="image">
                                        <img class="img-responsive center-block" src="images/how-it-works-card-2.png" alt="">
                                    </div>
                                    <div class="name"><span>2. Invita a participar</span></div>
                                    <div class="desc">Cuéntale a tus amigos por mail  o Facebook.</div>
                                </div>
                            </div>
                            <div class="col-sm-3 col-xs-6 align-top">
                                <div class="card">
                                    <div class="image">
                                        <img class="img-responsive center-block" src="images/how-it-works-card-3.png" alt="">
                                    </div>
                                    <div class="name"><span>3. Participa</span></div>
                                    <div class="desc">Paga de forma segura y reúne  el dinero de tus amigos.</div>
                                </div>
                            </div>

                            <div class="col-sm-3 col-xs-6 align-top">
                                <div class="card">
                                    <div class="image">
                                        <img class="img-responsive center-block" src="images/how-it-works-card-4.png" alt="">
                                    </div>

                                    <div class="name"><span>4. Gasta</span></div>
                                    <div class="desc">Compra en nuestras tiendas asociadas o ingresa el dinero a tu cuenta. </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- Section Testimonials -->
    <section class="block testimonials" id="testimonials">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <h2 class="title">Testimonios</h2>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div id="SliderTestimonials" class="slider">
                            @foreach ($testimonials as $item)
                                <article class="testimonial item">
                                    <div class="testimonial-inner">
                                        <div class="body">{!!$item->post_content!!}</div>
                                        <div class="title">-{{$item->post_title}}</div>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Advantages -->
        <section class="block advantages" id="ventajas">
            <div class="holder">
                <div class="container-fluid">
                    <div class="header-block">
                        <h2 class="title">Ventajas de Coperacha</h2>
                    </div>
                    <div class="content-block">
                        <div class="row">
                            <div class="col-sm-4 col-xs-6 align-top">
                                <div class="advantage">
                                    <div class="image">
                                        <img src="images/advantage-1.png" alt="Fácil de Usar">
                                    </div>
                                    <div class="info">
                                        <h4 class="name">Fácil de Usar</h4>
                                        <div class="desc">Te permite recaudar el dinero entre varias personas en una sola alcancía.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 align-top">
                                <div class="advantage">
                                    <div class="image">
                                        <img src="images/advantage-2.png" alt="Gratuito">
                                    </div>
                                    <div class="info">
                                        <h4 class="name">Gratuito</h4>
                                        <div class="desc">Utiliza la alcancía de manera gratuita en cualquier tienda de nuestros socios comerciales.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 align-top">
                                <div class="advantage">
                                    <div class="image">
                                        <img src="images/advantage-3.png" alt="Seguro">
                                    </div>
                                    <div class="info">
                                        <h4 class="name">Seguro</h4>
                                        <div class="desc">Nuestro sistema de pago es seguro para la aportación y transferencia de dinero. </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 align-top">
                                <div class="advantage">
                                    <div class="image">
                                        <img src="images/advantage-4.png" alt="Personal">
                                    </div>
                                    <div class="info">
                                        <h4 class="name">Personal</h4>
                                        <div class="desc">Crea una descripción del objetivo de la alcancía y personalizala con una foto.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 align-top">
                                <div class="advantage">
                                    <div class="image">
                                        <img src="images/advantage-5.png" alt="Social">
                                    </div>
                                    <div class="info">
                                        <h4 class="name">Social</h4>
                                        <div class="desc">Comparte en redes sociales o invita a tus amigos a participar por medio de su correo.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 col-xs-6 align-top">
                                <div class="advantage">
                                    <div class="image">
                                        <img src="images/advantage-6.png" alt="Flexible">
                                    </div>
                                    <div class="info">
                                        <h4 class="name">Flexible</h4>
                                        <div class="desc">Recupera el dinero como quieras: transferencia bancaria, compra un regalo o entrega el dinero al beneficiario.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- Section Payment Methods -->
    <section class="block payment-methods" id="metodos-de-pago">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <h2 class="title">Formas de Pago</h2>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div id="SliderMethods" class="slider methods">
                            <img class="item" src="images/master-card-logo.png" alt="Master Card">
                            <img class="item" src="images/american-express-logo.png" alt="American Express">
                            <img class="item" src="images/visa-logo.png" alt="Visa">
                            <img class="item" src="images/paypal-logo.png" alt="PayPal">
                            <img class="item" src="images/oxxo-logo.png" alt="Oxxo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Section Create Moneybox -->
    <section class="block create-moneybox" id="crea-tu-alcancia">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <h2 class="title">Crea tu Alcancía</h2>
                    <div>Es rápido, fácil y seguro</div>
                </div>
                <div class="content-block" ng-controller="registerController">
                    <div class="row">
                        <div class="col-sm-6">
                            <form class="sign-in">
                                <input name="name" placeholder="Nombre" type="text" ng-model="name" autocomplete="off">
                                <input name="lastname" placeholder="Apellido" type="text" ng-model="lastname" autocomplete="off">
                                <input name="email" placeholder="Correo electrónico" type="text" ng-model="email" autocomplete="off">
                                <input name="password" placeholder="Contraseña" type="password" ng-model="password">
                                <input class="btn btn-primary small" type="button" value="Crear mi alcancía" ng-click="emailRegister()">
                            </form>
                        </div>
                        <div class="col-sm-6">
                            <div class="sign-in-wrap">
                                <a class="sign-in-fb" href="#" ng-click="facebookRegister()">
                                    <span>o regístrate con</span>
                                    <img src="/images/facebook-logo.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{asset('/js/share.js')}}"></script>
    <script src="{{asset('/js/slider.js')}}"></script>
    <script src="{{asset('/js/index.js')}}"></script>
    <script src="{{asset('/js/validate.js')}}"></script>
    <script src="{{asset("/js/vendor/bootstrap-3.3.7/js/bootstrap.js")}}"></script>
    <script src="{{asset("/js/vendor/bootstrap-select-1.11.2/bootstrap-select.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('#moneybox-categories').selectpicker();
        });
    </script>
@endsection
