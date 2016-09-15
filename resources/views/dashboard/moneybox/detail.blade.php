@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>Nombre: {{$moneybox->name}}</h2>
        <p>Descripción: {{$moneybox->description}}</p>
    </div>
    <section class="dashboard row">
        <section class="block moneybox-view">
            <div class="holder" ng-controller="moneyboxController">

                <div class="container-fluid" id="moneybox-step1">

                    <div class="header-block">
                        <h4>Información</h4>
                    </div>

                    <div class="content-block">
                        <form class="form" role="form">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="hidden" ng-model="moneybox_id" ng-init="moneybox_id='{{$moneybox->id}}'">
                                        <input readonly type="text" class="form-control" placeholder="Nombre de la alcancía" value="{{$moneybox->name}}">
                                    </div>

                                    <div class="form-group">
                                        <input readonly id="person_name" name="person_name" type="text" class="form-control" placeholder="Nombre de quién la organiza" value='{{Auth::user()->person->name." ".Auth::user()->person->lastname}}'">
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-2">
                                                <picture style="margin-right: 15px">
                                                    <img  id="moneybox-image" class="icon-file"
                                                          style="height: 50px; width: auto"
                                                          src="{{$moneybox->lastimage ? url('/moneybox/image/' . $moneybox->lastimage) : '/images/icon-file.png'}}">
                                                </picture>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <textarea id="description" name="description"  class="form-control" rows="3" placeholder="Descripción">{{$moneybox->description}}</textarea>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">$</div>
                                            <input readonly type="text" class="form-control" placeholder="Cantidad que desea reunir" ng-model="goal_amount" value='{{$moneybox->goal_amount}}'>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xs-9">
                                                <input id="datepicker" type="text" class="form-control" placeholder="Fecha límite para reunir los fondos" ng-model="end_date" value='{{$moneybox->end_date}}'>
                                            </div>
                                            <div class="col-xs-3"><span class="icon-calendar"></span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="pull-right">
                                    @if($moneybox)
                                        <a class="btn btn-primary" ng-click="createMoneybox()">Modificar</a>
                                    @else
                                        <a class="btn btn-primary" ng-click="step1Click()">Siguiente ></a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </section>
@stop