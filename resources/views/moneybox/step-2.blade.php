@extends("layouts.content")

@section("page-content")
    <section class="block register step-2" id="register">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="title"><h2>Información</h2></div>
                    <div class="stages-control"></div>
                </div>

                <div class="content-block">
                    <form action="#" class="form register moneybox">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label>¿Cómo quiéres que sea el monto de participación?</label>
                                    <div class="radio">
                                        <label for="libre">
                                            <input id="libre" name="way" type="radio"> Libre
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="sugerido">
                                            <input id="sugerido" name="way" type="radio"> Sugerido
                                            <input id="txtSugerido" name="txtSugerido" type="text" value="$ 000"> <strong> .00 MXN</strong>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="fijo">
                                            <input id="filo" name="fijo" type="radio"> Fijo
                                            <input id="txtFijo" name="way" type="text" value="$ 000"> <strong> .00 MXN</strong>
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Opciones de privacidad</label>
                                    <div class="radio">
                                        <label for="hidden">
                                            <input id="hidden" name="privacy" type="radio"> Ocultar la identidad de los participantes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="hidden">
                                            <input id="hidden" name="privacy" type="radio"> Ocultar el importe con el que colaboran los participantes
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label for="hidden">
                                            <input id="hidden" name="privacy" type="radio"> Ocultar el importe del bote
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <a href="" class="btn-link">< Volver </a>
                                <button class="btn btn-primary">Siguiente ></button>
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