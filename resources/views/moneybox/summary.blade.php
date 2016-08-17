@extends("layouts.master")
@section("content")
    @include('partials.header')
    
    <section class="block request-view">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <div class="title"></div>
                </div>
                <div class="content-block">
                    <form action="#" class="form">
                        <div class="form-group">
                            <p class="text-info">Verifica por favor que los datos sean correctos</p>
                        </div>

                        <div class="form-group">
                            <label for="moneybox">Nombre de la alcancía:</label><input id="moneybox" readonly type="text" value="Demo 18373">
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Tu Nombre:</label><input id="name" readonly type="text" value="Sanchez Gonzalez">
                        </div>
                                          
                        <div class="form-group">
                            <label for="email">Correo:</label><input id="email" readonly type="text" value="something@company.com">
                        </div>
                         
                        <div class="form-group">
                            <label for="mobile">Celular:</label><input id="mobile" readonly type="text" value="243877348">
                        </div>
                    
                        <div class="form-group">
                            <label for="amount">Tu participacón:</label><input id="amount" readonly type="text" value="100">
                        </div>
                        
                        <div class="form-group">
                            <a class="btn-link">editar</button>
                        </div>
                        
                         <div class="form-group">
                            <label>Selecciona tu método de pago:</label>
                            <div class="radio">
                                <label for="payment-oxxo"><input id="payment-oxxo" name="payment" type="radio" value="O"> OXXO</label>
                            </div>
                            <div class="radio">
                                <label for="payment-paypal"><input id="payment-paypal" name="payment" type="radio" value="P"> PAYPAL</label>
                            </div>
                            <div class="radio">
                                <label for="payment-spei"><input id="payment-spei" name="payment" type="radio" value="S"> SPEI</label>
                            </div>
                        </div>
                        
                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small">Realizar Pago</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
@endsection
