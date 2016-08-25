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
                    <form class="form register moneybox" ng-controller="moneyboxController">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-sm-12">

                                    @foreach($settings as $setting)

                                        <div class="form-group">
                                            <label>{{utf8_decode($setting->name)}}</label>
                                        </div>

                                        @foreach($setting->options as $option)
                                        <div class="radio">
                                            @if($option->subtype=='text')
                                            <label for="{{$option->name}}" class="flex-element">
                                                <input type="radio" value="{{$setting->id}}|{{$option->id}}" ng-model="{{$setting->id==1 ? "participation" : "privacy"}}">
                                                <span>{{$option->name}}</span>
                                                <input class="form-control" type="number" value="0">
                                                <strong> .00 MXN</strong>
                                            </label>
                                            @else
                                            <label for="{{$option->name}}">
                                                <input type="radio" value="{{$setting->id}}|{{$option->id}}" ng-model="{{$setting->id==1 ? "participation" : "privacy"}}"> {{$option->name}}
                                            </label>
                                            @endif
                                        </div>
                                        @endforeach

                                    @endforeach

                                    <!-- settings section -->
                                    <!--<div class="form-group">
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
                                    </div>-->
                                    <!-- settings section -->

                                </div>
                            </div>
                        </div>
                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <a href="{{route('moneybox.create')}}" class="btn-link">< Volver </a>
                                <button class="btn btn-primary" ng-click="step2()">Siguiente ></button>
                            </div>
                        </div>
                        @if(Session::has('tmp_moneybox'))
                            <input type="hidden" ng-init="category_id='{{Session::get('tmp_moneybox')['category_id']}}'" ng-model="category_id"/>
                            <input type="hidden" ng-init="name='{{Session::get('tmp_moneybox')['name']}}'" ng-model="name"/>
                            <input type="hidden" ng-init="description='{{Session::get('tmp_moneybox')['description']}}'" ng-model="description"/>
                            <input type="hidden" ng-init="goal_amount='{{Session::get('tmp_moneybox')['goal_amount']}}'" ng-model="goal_amount"/>
                            <input type="hidden" ng-init="end_date='{{Session::get('tmp_moneybox')['end_date']}}'" ng-model="end_date"/>
                            <input type="hidden" ng-init="person_name='{{Session::get('tmp_moneybox')['person_name']}}'" ng-model="person_name"/>
                            <input type="hidden" ng-init="person_id='{{Session::get('tmp_moneybox')['person_id']}}'" ng-model="person_id"/>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

@endsection