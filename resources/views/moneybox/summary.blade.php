@extends("layouts.master")
@section("content")
    @include('partials.header')
    
    <section class="block summary-view">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <h2 class="title">Verifica por favor que los datos sean correctos</h2>
                </div>
                <div class="content-block">
                    <form action="#" class="form summary">
                        <div class="form-group">
                            <label for="moneybox">Nombre de la alcancía:</label>
                            <input id="moneybox" readonly type="text" value="Demo 18373">
                        </div>
                        <div class="form-group">
                            <label for="name">Tu Nombre: </label>
                            <input id="name" readonly type="text" value="Emmanuel Sanchez">
                        </div>
                        <div class="form-group">
                            <label for="mobile">Celular: </label>
                            <input id="mobile" readonly type="text" value="243877348">
                        </div>
                        <div class="form-group">
                            <label for="email">Correo: </label>
                            <input id="email" readonly type="text" value="loremips@gmail.com">
                        </div>
                        <div class="form-group">
                            <label for="amount">Tu participación: </label>
                            <input id="amount" readonly type="text" value="$50.00 (+ $2.50 por comisión) MXN">
                        </div>
                        
                        <div class="form-group">
                            <a class="btn-link btn-edit">
                                <span class="icon-edit"></span>
                                <div class="text">Modificar datos</div>
                            </a>
                        </div>
                    </form>

                    <form action="#" class="form">
                        <div class="form-group">
                            <label>Selecciona tu método de pago:</label>
                            <div class="radio">
                                <label for="payment-oxxo"><input id="payment-oxxo" name="payment" type="radio" value="O">
                                    <img src="/images/icon-oxxo.png">
                                </label>
                            </div>
                            <div class="radio">
                                <label for="payment-paypal"><input id="payment-paypal" name="payment" type="radio" value="P">
                                    <img src="/images/icon-paypal.png">
                                </label>
                            </div>
                            <div class="radio">
                                <label for="payment-spei"><input id="payment-spei" name="payment" type="radio" value="S">
                                    <img src="/images/icon-spei.png">
                                </label>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="clearfix">
                                <button class="pull-right btn btn-primary small">Realizar Pago</button>
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
                        <div class="method"><img src="/images/master-card-logo.png" alt="Master Card"></div>
                        <div class="method"><img src="/images/american-express-logo.png" alt="American Express"></div>
                        <div class="method"><img src="/images/visa-logo.png" alt="Visa"></div>
                        <div class="method"><img src="/images/paypal-logo.png" alt="PayPal"></div>
                        <div class="method"><img src="/images/oxxo-logo.png" alt="Oxxo"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
