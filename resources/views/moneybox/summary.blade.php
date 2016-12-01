@extends("layouts.master")
@section("navigation")
    @include("partials.navigation")
@endsection
@section("content")
    @include('partials.header')

    <section class="block summary-view" ng-controller="participantController">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <h2 class="title">Verifica por favor que los datos sean correctos</h2>
                </div>
                <div class="content-block">
                    <input type="hidden" ng-init="person_id='{{$participant->person->id}}'"/>
                    <input type="hidden" ng-init="moneybox='{{$moneybox}}'"/>
                    <form class="form summary">
                        <div class="row">
                            <div class="col-xs-12 col-sm-4"> <label for="moneybox">Nombre de la alcancía:</label> </div>
                            <div class="col-xs-12 col-sm-8"> <input id="moneybox" readonly type="text" value="{{$moneybox->name}}"> </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4"><label for="name">Tu Nombre: </label></div>
                            <div class="col-xs-12 col-sm-8"><input id="name" readonly type="text" value="{{$participant->person->name." ".$participant->person->lastname}}"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4"><label for="mobile">Celular: </label></div>
                            <div class="col-xs-12 col-sm-8"><input id="mobile" readonly type="text" value="{{$participant->person->phone}}"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4"><label for="email">Correo: </label></div>
                            <div class="col-xs-12 col-sm-8"><input id="email" readonly type="text" value="{{$participant->email}}"></div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4"><label for="amount">Tu participación: </label></div>
                            <div class="col-xs-12 col-sm-8"><input id="amount"  readonly type="text" value="${{number_format($amount, 2)}} MXN"></div>
                            <input type="hidden" ng-init="amount='{{$amount}}'" ng-model="amount">
                        </div>

                        <div class="form-group">
                            <a class="btn-link btn-edit" href="{{url('moneybox/join/'.$moneybox->url)}}">
                                <span class="icon-edit"></span>
                                <div class="text">Modificar datos</div>
                            </a>
                        </div>
                    </form>

                    <form class="form">
                        <div class="form-group">
                            <label>Selecciona tu método de pago:</label>
                            <div class="radio">
                                <label for="payment-oxxo"><input id="payment-oxxo" ng-model="paymentMethod" type="radio" value="O">
                                    <img src="/images/icon-oxxo.png">
                                </label>
                            </div>
                            <div class="radio">
                                <label for="payment-paypal"><input id="payment-paypal" ng-model="paymentMethod" type="radio" value="P">
                                    <img src="/images/icon-paypal.png">
                                </label>
                            </div>
                            <div class="radio">
                                <label for="payment-spei"><input id="payment-spei" ng-model="paymentMethod" type="radio" value="S">
                                    <img src="/images/icon-spei.png">
                                </label>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="clearfix">
                                <button class="pull-right btn btn-primary small" ng-click="doPayment()">Realizar Pago</button>
                            </div>
                            <div class="small-text">*Al proceder al pago aceptas nuestros términos y condiciones de uso</div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="block payment-methods inverse">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <div class="title">Formas de Pago</div>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div class="slider methods slider-summary">
                            <img class="item" src="/images/master-card-logo.png" alt="Master Card">
                            <img class="item" src="/images/american-express-logo.png" alt="American Express">
                            <img class="item" src="/images/visa-logo.png" alt="Visa">
                            <img class="item" src="/images/paypal-logo.png" alt="PayPal">
                            <img class="item" src="/images/oxxo-logo.png" alt="Oxxo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{asset('/js/slider.js')}}"></script>
    <script>
        $('.slider').slider({
            slideSpeed: 500,
            play: 5000,
            preload: true,
            withPagination: false,
            withNavigation: false
        });
    </script>
@endsection
