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
                    <form id="contact-form" v-on:submit.prevent="onSubmit" class="contact-form" action="/" method="post">
                        <div v-if="sended" class="alert alert-success" role="alert">@{{message}}</div>
                        <div class="row">
                            <div class="col-sm-6">
                                <input name="name" v-model="contact.name" placeholder="Nombre" type="text" required>
                            </div>
                            <div class="col-sm-6">
                                <input name="email" v-model="contact.email" placeholder="Correo electrónico" type="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <textarea rows="4" v-model="contact.content" name="message" placeholder="Mensaje" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 clearfix">
                                <button v-bind:disabled="!isValid" class="pull-right">
                                    <span v-if="sending" class="icon"></span>
                                    <span class="text">@{{sendText}}</span>
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')
    <script src="js/vendor/vuejs/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.9.3/vue-resource.js"></script>
    <script src="js/contact.js"></script>
@endsection