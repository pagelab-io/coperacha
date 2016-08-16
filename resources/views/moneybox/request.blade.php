@extends("layouts.master")

@section("content")

    @include('partials.header')

    <section class="block request-view">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="title">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="/images/moneybox-request.png" alt="moneybox-request">
                            </div>
                            <div class="col-sm-9">
                                <h2>
                                    <div>¡Felicidades!</div>
                                    <div>Ya se recaudó el dinero para tu alcancía “Prueba 2”</div>
                                    <div>por un monto de $350.00</div>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content-block">
                    <form action="#" class="form">
                        <div class="form-group">
                            <p class="text-info">Llena por favor los siguientes datos:</p>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nombre del titular de la cuenta</label>
                                    <input id="name" name="name" type="text"
                                           required
                                           class="form-control"
                                           placeholder="Nombre del titular de la cuenta">
                                </div>

                                <div class="form-group">
                                    <label for="name">Selecciona tu banco</label>
                                    <select name="bank" id="bank" class="form-control">
                                        <option value="santander">Santander</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="address">Dirección del banco</label>
                                    <textarea id="address" name="address"  class="form-control" rows="3" placeholder="Dirección del banco"></textarea>
                                </div>

                                <div class="form-group">
                                    <span for="file">Adjuntar copia de su información bancaria para
                                            confirmar los datos</span>
                                    <input id="file" name="file" type="file">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="clabe">Clabe Interbancaria</label>
                                    <input id="clabe" name="clabe" type="number" class="form-control" placeholder="Clabe Interbancaria">
                                </div>

                                <div class="form-group">
                                    <label for="account">Número de cuenta</label>
                                    <input id="account" name="account" type="number" class="form-control" placeholder="Número de cuenta">
                                </div>

                                <div class="form-group">
                                    <label for="comments">Comentarios</label>
                                    <textarea id="comments" name="comments"  class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small">Aceptar</button>
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