@extends("layouts.content")

@section("page-content")

    <!-- Contact Layout -->
    <section class="contact-body" xmlns:v-bind="http://www.w3.org/1999/xhtml">
        <div class="holder">
            <div class="container-fluid">
                <div class="header">
                    <h2>Queremos saber qué opinas de Coperacha, mándanos un mensaje por favor.</h2>
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
                    <form id="contact-form" v-on:submit.prevent="onSubmit" class="contact-form" method="post">
                        <div v-if="loading" class="loader"></div>
                        <div v-if="message.text != ''" class="alert alert-success" role="alert">@{{message.text}}</div>

                        <div class="row">
                            <div class="col-sm-6">
                                <input name="name"
                                       v-model="contact.name"
                                       placeholder="Nombre" type="text">
                            </div>
                            <div class="col-sm-6">
                                <input name="email"
                                       v-model="contact.email"
                                       placeholder="Correo electrónico" type="text">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea rows="4"
                                          v-model="contact.content"
                                          name="message"
                                          placeholder="Mensaje"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 clearfix">
                                <button v-bind:disabled="!isValid" class="btn btn-primary small pull-right">
                                    <span v-show="sending" class="icon"></span>
                                    <span class="text">Enviar</span>
                                </button>
                            </div>
                        </div>
                    </form><!-- ./contact-form -->
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{asset('/js/vendor/vuejs/vue.js')}}"></script>
    <script src="{{asset('/js/vendor/vuejs/vue-resource.js')}}"></script>
    <script src="{{asset('/js/contact.js')}}"></script>
@endsection