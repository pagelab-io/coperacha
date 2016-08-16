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
                            <p class="text-info">Llena por favor tus datos para participar en esta alcancía</p>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    <input id="name" name="name" type="text"
                                           required
                                           class="form-control"
                                           placeholder="Nombre ">
                                </div>

                                <div class="form-group">
                                    <label for="mobile">Celular</label>
                                    <input id="mobile" name="mobile" type="text"
                                           required
                                           class="form-control"
                                           placeholder="Celular ">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input id="email" name="email" type="number" class="form-control" placeholder="Correo Electrónico">
                                </div>

                                <div class="form-group">
                                    <label for="amount">Monto con el que quiere participar</label>
                                    <input id="amount" name="amount" type="number" class="form-control" placeholder="Monto">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Hacer mi participación:</label>
                            <div class="radio">
                                <label for="hidden">
                                    <input id="hidden" name="privacy" type="radio"> Visible: enseñar mi nombre y el monto con el que participo
                                </label>
                            </div>
                            <div class="radio">
                                <label for="hidden">
                                    <input id="hidden" name="privacy" type="radio"> Mostrar mi nombre y esconder el monto con el que participo
                                </label>
                            </div>
                            <div class="radio">
                                <label for="hidden">
                                    <input id="hidden" name="privacy" type="radio"> Anónimamente
                                </label>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small">Siguiente > </button>
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