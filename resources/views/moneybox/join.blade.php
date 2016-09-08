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
                    <form class="form" ng-controller="participantController">
                        <input type="hidden" ng-init="moneybox='{{$moneybox}}'"/>
                        <input type="hidden" ng-init="moneyboxSettings='{{$moneyboxSettings}}'"/>
                        <div class="form-group">
                            <p class="text-info">Llena por favor tus datos para participar en esta alcancía</p>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nombre</label>
                                    @if(Auth::user())
                                        <input readonly type="text" class="form-control" placeholder="Nombre" ng-init="name='{{Auth::user()->person->name}}'" ng-model="name">
                                    @else
                                        <input type="text" class="form-control" placeholder="Nombre" ng-model="name">
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="name">Apellidos</label>
                                    @if(Auth::user())
                                        <input readonly type="text" class="form-control" placeholder="Apellidos" ng-init="lastname='{{Auth::user()->person->lastname}}'" ng-model="lastname">
                                    @else
                                        <input type="text" class="form-control" placeholder="Apellidos" ng-model="lastname">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mobile">Celular</label>
                                    @if(Auth::user())
                                        <input type="text" class="form-control" placeholder="Celular" ng-model="phone" ng-init="phone='{{Auth::user()->person->phone}}'">
                                    @else
                                        <input type="text" class="form-control" placeholder="Celular" ng-model="phone">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    @if(Auth::user())
                                        <input readonly type="text" class="form-control" placeholder="Correo Electrónico" ng-model="email" ng-init="email='{{Auth::user()->email}}'">
                                    @else
                                        <input type="text" class="form-control" placeholder="Correo Electrónico" ng-model="email">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="amount">Monto con el que quiere participar</label>
                                    <input type="number" class="form-control" placeholder="Monto" ng-model="amount">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            @foreach($settings as $setting)
                            <label>{{utf8_decode($setting->name)}}</label>
                                @foreach($setting->options as $option)
                                    <div class="radio">
                                        <label for="hidden">
                                            <input type="radio" value="{{$setting->id}}|{{$option->id}}" ng-model="settings"> {{utf8_decode($option->name)}}
                                        </label>
                                    </div>
                                @endforeach
                            @endforeach
                        </div>

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small" ng-click="createParticipant()">Siguiente > </button>
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