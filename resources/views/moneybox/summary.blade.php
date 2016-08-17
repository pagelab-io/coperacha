@extends("layouts.master")

@section("content")

    @include('partials.header')

    <section class="block request-view">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="title">
                    </div>
                </div>

                <div class="content-block">
                    <form action="#" class="form">
                        <div class="form-group">
                            <p class="text-info">Verifica por favor que los datos sean correctos</p>
                        </div>

                        <div class="form-group">
                            <label for="moneybox">Nombre de la alcancía:</label><input id="moneybox" readonly type="text">
                        </div>
                        
                        <div class="form-group">
                            <label for="name">Tu Nombre:</label><input id="name" readonly type="text" value="Sanchez">
                        </div>
                                          
                        <div class="form-group">
                            <label for="email">Correo:</label><input id="email" readonly type="text" value="something@company.com">
                        </div>
                         
                        <div class="form-group">
                            <label for="mobile">Correo:</label><input id="mobile" readonly type="text" value="243877348">
                        </div>
                    
                        <div class="form-group">
                            <label for="amount">Correo:</label><input id="amount" readonly type="text" value="100">
                        </div>
                        
                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small">editar</button>
                            </div>
                        </div>
                        
                         <div class="form-group">
                            <label>Método de Pago:</label>
                            <div class="radio">
                                <label for="payment-oxxo"><input id="payment-o" name="payment" type="radio" value="O"> OXXO</label>
                            </div>
                            
                            <div class="radio">
                                <label for="payment-paypal"><input id="payment-p" name="payment" type="radio" value="O"> PAYPAL</label>
                            </div>
                            
                            <div class="radio">
                                <label for="payment-spei"><input id="payment-s" name="payment" type="radio" value="O"> SPEI</label>
                            </div>
                        
                        </div>
                        
                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small">REALIZAR PAGO</button>
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
