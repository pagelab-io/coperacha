@extends("layouts.content")

@section("page-content")

    <!-- Contact Layout -->
    <section class="contact-body contact-layout">
        <div class="holder">
            <div class="container-fluid">
                <div class="header">
                    <div>Queremos saber qué opinas de Coperacha, mándamos un mensaje.</div>
                </div>
                <div class="content">
                    <!-- Contact Info -->
                    <div class="contact-info">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="info address">
                                    <div class="icon-wrapper"></div>
                                    <div class="text">
                                        <div>Camino de los ibis #396 D22 Torre 2  Col. San Jemo;</div>
                                        <div>Monterrey, Nuevo León</div>
                                        <div>64630 México</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="info phone">
                                    <div class="icon-wrapper"></div>
                                    <div class="text">
                                        <div><a href="tel:8110668875">+52 811 066 88 75</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <form class="contact-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <input name="Nombre" placeholder="Nombre" type="text">
                            </div>
                            <div class="col-sm-6">
                                <input name="Email" placeholder="Correo electrónico" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea name="Mensaje" placeholder="Mensaje"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <input type="submit" value="Enviar">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@stop