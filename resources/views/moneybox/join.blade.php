@extends("layouts.master")

@section('css')
    <link rel="stylesheet" href="{{asset("/js/vendor/bootstrap-select-1.11.2/bootstrap-select.css")}}">
@endsection
@section("navigation")
    @include("partials.navigation")
@endsection
@section("content")
    @include('partials.header')
    <section class="block request-view">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <div class="title"></div>
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
                                        @if(Session::has('tmp_participant'))
                                            <input type="text" class="form-control" placeholder="Nombre" ng-model="name" ng-init="name='{{Session::get('tmp_participant')["name"]}}'">
                                        @else
                                            <input type="text" class="form-control" placeholder="Nombre" ng-model="name">
                                        @endif
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="name">Apellidos</label>
                                    @if(Auth::user())
                                        <input readonly type="text" class="form-control" placeholder="Apellidos" ng-init="lastname='{{Auth::user()->person->lastname}}'" ng-model="lastname">
                                    @else
                                        @if(Session::has('tmp_participant'))
                                            <input type="text" class="form-control" placeholder="Apellidos" ng-model="lastname" ng-init="lastname='{{Session::get('tmp_participant')["lastname"]}}'">
                                        @else
                                            <input type="text" class="form-control" placeholder="Apellidos" ng-model="lastname">
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="mobile">Celular</label>
                                    @if (Auth::user())
                                        <div class="input-group">
                                            <div class="input-group-addon" style="padding: 0;">
                                                <select class="selectpicker"
                                                        ng-model="areacode"
                                                        ng-init="areacode='{{Auth::user()->person->areacode}}'"
                                                        data-width="160px"
                                                        data-live-search="true">
                                                    <option value="">Código de area</option>
                                                    @foreach($codes as $code)
                                                        <option value="{{$code['code']}}">{!! $code['name'] .' - <strong>('. $code['code'] . ')</strong>' !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="text" class="form-control"
                                                   placeholder="Celular"
                                                   ng-model="phone" ng-init="phone='{{Auth::user()->person->phone}}'">
                                        </div>
                                    @else
                                        @if(Session::has('tmp_participant'))
                                            <div class="input-group">
                                                <div class="input-group-addon" style="padding: 0;">
                                                    <select class="selectpicker"
                                                            ng-model="areacode"
                                                            ng-init="areacode='{{Session::get('tmp_participant')["areacode"]}}'"
                                                            data-width="160px"
                                                            data-live-search="true">
                                                        <option value="">Código de area</option>
                                                        @foreach($codes as $code)
                                                            <option value="{{$code['code']}}">{!! $code['name'] .' - <strong>('. $code['code'] . ')</strong>' !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Celular" ng-model="phone" ng-init="phone='{{Session::get('tmp_participant')["phone"]}}'">
                                            </div>
                                        @else
                                            <div class="input-group">
                                                <div class="input-group-addon" style="padding: 0;">
                                                    <select class="selectpicker"
                                                            ng-model="areacode"
                                                            data-width="160px"
                                                            data-live-search="true">
                                                        <option value="">Código de area</option>
                                                        @foreach($codes as $code)
                                                            <option value="{{$code['code']}}">{!! $code['name'] .' - <strong>('. $code['code'] . ')</strong>' !!}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Celular" ng-model="phone">
                                            </div>
                                        @endif

                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    @if(Auth::user())
                                        <input readonly type="text" class="form-control" placeholder="Correo electrónico" ng-model="email" ng-init="email='{{Auth::user()->email}}'">
                                    @else
                                        @if(Session::has('tmp_participant'))
                                            <input type="text" class="form-control" placeholder="Correo electrónico" ng-model="email" ng-init="email='{{Session::get('tmp_participant')["email"]}}'">
                                        @else
                                            <input type="text" class="form-control" placeholder="Correo electrónico" ng-model="email">
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="amount">Monto con el que quiere participar</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">$</div>
                                        @if(Session::has('tmp_participant'))
                                            <input type="text" class="form-control" placeholder="Monto" ng-model="amount" ng-init="amount='{{Session::get('tmp_participant')["amount"]}}'">
                                        @else
                                            @foreach($moneyboxSettings as $setting)
                                                @if($setting->setting_id == 1)
                                                    @if($setting->option_id == 2 || $setting->option_id == 3)
                                                        <input type="text" class="form-control" placeholder="Monto" ng-model="amount" ng-init="amount='{{$setting->value}}'">
                                                    @else
                                                        <input type="text" class="form-control" placeholder="Monto" ng-model="amount">
                                                    @endif
                                                @endif
                                            @endforeach

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            @foreach($settings as $setting)
                            <label>{{utf8_decode($setting->name)}}</label>
                                @foreach($setting->options as $option)
                                    <div class="radio">
                                        <label for="hidden">
                                            @if(Session::has('tmp_participant'))
                                                @if(Session::get('tmp_participant')['option_id'] == $option->id)
                                                    <input type="radio" value="{{$setting->id}}|{{$option->id}}" ng-model="settings" ng-init="settings='{{$setting->id}}|{{Session::get("tmp_participant")["option_id"]}}'"> {{utf8_decode($option->name)}}
                                                @else
                                                    <input type="radio" value="{{$setting->id}}|{{$option->id}}" ng-model="settings"> {{utf8_decode($option->name)}}
                                                @endif
                                            @else
                                                <input type="radio" value="{{$setting->id}}|{{$option->id}}" ng-model="settings"> {{utf8_decode($option->name)}}
                                            @endif
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
    <script src="{{asset("/js/vendor/bootstrap-3.3.7/js/bootstrap.js")}}"></script>
    <script src="{{asset("/js/vendor/bootstrap-select-1.11.2/bootstrap-select.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker({ liveSearch: true });
        });
    </script>
@endsection