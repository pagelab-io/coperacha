@extends("layouts.content")

@section("page-content")
    <section class="block moneybox-view step-2" id="register">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="stage-item">
                        <div class="stage-item-title">Participación</div>
                        <div class="icon-step icon-step-2"></div>
                        <div class="label">Información</div>
                        <div class="label active">Participación</div>
                    </div>
                </div>

                <div class="content-block">

                    <form action="{{route('moneybox.dashboard')}}" class="form register moneybox">
                        <div class="form-group">
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
                                            <label for="sugerido" class="flex-element">
                                                <input id="sugerido" name="way" type="radio">
                                                <span>Sugerido</span>
                                                <input class="form-control" id="txtSugerido" name="txtSugerido" type="number" value="0">
                                                <strong> .00 MXN</strong>
                                            </label>
                                        </div>
                                        <div class="radio">
                                            <label for="fijo" class="flex-element">
                                                <input id="filo" name="fijo" type="radio">
                                                <span>Fijo</span>
                                                <input class="form-control" id="txtWay" name="txtWay" type="number" value="200">
                                                <strong>.00 MXN</strong>
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
                        </div>
                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <a href="{{route('moneybox.create')}}" class="btn-link">< Volver </a>
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