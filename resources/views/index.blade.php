@extends("layouts.master")

@section("content")
    <!-- Cover -->
    <div class="block cover">
        <div class="holder">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 align-middle">
                        <div class="graphics">
                            <!-- Money -->
                            <div class="money graphic">
                                <img src="images/cover-money.png" alt="">
                            </div>

                            <!-- Laptop -->
                            <div class="laptop graphic">
                                <img src="images/cover-laptop.png" alt="">
                            </div>

                            <!-- Wallet -->
                            <div class="wallet graphic">
                                <img src="images/cover-wallet.png" alt="">
                            </div>

                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 align-middle">
                        <div class="header-block">
                            <div>El servicio online para recaudar dinero entre amigos</div>
                        </div>
                        <div class="content-block">
                            <div class="html">
                                <div>Coperacha es un servicio de gestión de dinero comunitario que sirve para hacer regalos o transferencias entre amigos.</div>
                            </div>
                            <a style="display: none" href="#" class="button">Crear mi Alcancía</a>
                            <a class="button" href="{{route('user.create')}}">Crear mi Alcancía</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                    <img class="img-responsive center-block" src="images/how-it-works-card-1.png" alt="">
                                </div>
                                <div class="name"><a class="button" href="{{route('user.create')}}">1. Crea tu Alcancía</a></div>
                                <div class="desc">Es gratis y te llevará un minuto crearla... </div>
                            </div>
                        </div>

                        <div class="col-sm-3 col-xs-6 align-top">
                            <div class="card">
                                <div class="image">
                                    <img class="img-responsive center-block" src="images/how-it-works-card-2.png" alt="">
                                </div>
                                <div class="name"><span>2. Invita a Usuarios</span></div>
                                <div class="desc">Cuéntale a tus amigos, por mail  o Facebook.</div>
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

    <!-- Section Intro -->
    <section class="block intro" id="intro">
        <div class="holder">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="header-block">
                            <h2 class="title">Arma tu Coperacha para fiestas, regalos o viajes</h2>
                        </div>
                        <div class="content-block">
                            <div class="clearfix moneyboxes">
                                <div class="moneybox-type">
                                    <img class="img-responsive" src="images/intro-moneybox-1.png" alt="">
                                </div>
                                <div class="moneybox-type">
                                    <img class="img-responsive" src="images/intro-moneybox-2.png" alt="">
                                </div>
                                <div class="moneybox-type">
                                    <img class="img-responsive" src="images/intro-moneybox-3.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="video">
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/142285041?title=0&byline=0&portrait=0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                            </div>

                            <a class="share-fb" href="javascript:void(0)">
                                <span>Compartir en</span>
                                <img src="images/facebook-logo.png" alt="">
                            </a>
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
                                    <div class="desc">Personaliza tu alcancía ponle fotos, escribe lo que quieras.</div>
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
                                    <div class="desc">Comparte en redes sociales o invita a tus amigos a participar con Facebook.</div>
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
                        <div class="method"><img src="images/master-card-logo.png" alt="Master Card"></div>
                        <div class="method"><img src="images/american-express-logo.png" alt="American Express"></div>
                        <div class="method"><img src="images/visa-logo.png" alt="Visa"></div>
                        <div class="method"><img src="images/paypal-logo.png" alt="PayPal"></div>
                        <div class="method"><img src="images/oxxo-logo.png" alt="Oxxo"></div>
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
                <div class="content-block">
                    <div class="row">
                        <div class="col-sm-6">
                            <form class="sign-in">
                                <input name="name" placeholder="Nombre" type="text">
                                <input name="lastname" placeholder="Apellido" type="text">
                                <input name="email" placeholder="Correo Electrónico" type="text">
                                <input name="password" placeholder="Contraseña" type="password">
                                <input type="submit" value="Crear mi Alcancía">
                            </form>
                        </div>

                        <div class="col-sm-6">
                            <div class="sign-in-wrap">
                                <a class="sign-in-fb" href="javascript:void(0)">
                                    <span>O regístrate con</span>
                                    <img src="images/facebook-logo.png" alt="">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection