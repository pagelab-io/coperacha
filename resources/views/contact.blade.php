@extends("layouts.content")

@section("page-content")

    <!-- Contact Layout -->
    <section class="contact-body contact-layout">
        <div class="holder">
            <div class="container-fluid">
                <div class="header">
                    <h2>Queremos saber qué opinas de Coperacha, mándamos un mensaje.</h2>
                </div>
                <div class="content">
                    <!-- Contact Info -->
                    <div class="contact-info">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="info-address">
                                    <div class="icon-address"></div>
                                    <div class="text">
                                        <div>Camino de los ibis #396 D22 Torre 2  Col. San Jemo;</div>
                                        <div>Monterrey, Nuevo León</div>
                                        <div>64630 México</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info-phone">
                                    <div class="icon-phone"></div>
                                    <div class="text">
                                        <a href="tel:8110668875">+52 811 066 88 75</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <form class="contact-form" action="/" method="post">
                        <div class="row">
                            <div class="col-sm-6">
                                <input name="name" placeholder="Nombre" type="text" required>
                            </div>
                            <div class="col-sm-6">
                                <input name="email" placeholder="Correo electrónico" type="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea rows="4" name="message" placeholder="Mensaje" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 clearfix">
                                <button class="pull-right">Enviar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection