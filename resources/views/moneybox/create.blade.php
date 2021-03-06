@extends("layouts.content")
@section("page-content")
    <section class="block moneybox-view">
        <div class="holder" ng-controller="moneyboxController">

            <div class="container-fluid" id="moneybox-step1">
                <div class="header-block">
                    <div class="stage-item">
                        <div class="stage-item-title">Información</div>
                        <div class="icon-step icon-step-1"></div>
                        <div class="label active">Información</div>
                        <div class="label">Participación</div>
                    </div>
                </div>

                <div class="content-block">
                    <form class="form" role="form">
                        <div class="form-group">
                            <p class="text-info">Llena por favor los siguientes datos:</p>
                        </div>
                        <div class="form-group categories">
                           <label>Selecciona la categoría para la alcancía:</label>
                           <div class="category-items">
                               @foreach($categories1 as $i => $category)
                                   <label for="chk-{{$category->id}}" class="category-item">
                                       <img src="{{$category->path}}" alt="{{$category->name}}">
                                       @if ($moneybox && $moneybox->category_id == $category->id)
                                           <div class="label"><input disabled id="chk-{{$category->id}}" type="radio" name="category" ng-model="category_id" ng-init="category_id={{$category->id}}" value="{{$category->id}}"> {{$category->name}}</div>
                                       @else
                                           @if($moneybox)
                                               <div class="label"><input disabled id="chk-{{$category->id}}" type="radio" name="category" ng-model="category_id" value="{{$category->id}}"> {{$category->name}}</div>
                                           @else
                                               @if($categorySelected != '' && $categorySelected == $category->id)
                                                    <div class="label"><input id="chk-{{$category->id}}"type="radio" name="category" ng-model="category_id" ng-init="category_id={{$category->id}}" value="{{$category->id}}"> {{$category->name}}</div>
                                               @else
                                                    <div class="label"><input id="chk-{{$category->id}}"type="radio" name="category" ng-model="category_id" value="{{$category->id}}"> {{$category->name}}</div>
                                               @endif
                                           @endif
                                       @endif
                                   </label>
                               @endforeach
                           </div>
                           <div class="category-items">
                                @foreach($categories2 as $i => $category)
                                   <label for="chk-{{$category->id}}" class="category-item">
                                       <img src="{{$category->path}}" alt="{{$category->name}}">
                                       @if ($moneybox && $moneybox->category_id == $category->id)
                                           <div class="label"><input disabled id="chk-{{$category->id}}" type="radio" name="category" ng-model="category_id" ng-init="category_id={{$category->id}}" value="{{$category->id}}"> {{$category->name}}</div>
                                       @else
                                           @if($moneybox)
                                               <div class="label"><input disabled id="chk-{{$category->id}}" type="radio" name="category" ng-model="category_id" value="{{$category->id}}"> {{$category->name}}</div>
                                           @else
                                               @if($categorySelected != '' && $categorySelected == $category->id)
                                                    <div class="label"><input id="chk-{{$category->id}}"type="radio" name="category" ng-model="category_id" ng-init="category_id={{$category->id}}" value="{{$category->id}}"> {{$category->name}}</div>
                                               @else
                                                    <div class="label"><input id="chk-{{$category->id}}"type="radio" name="category" ng-model="category_id" value="{{$category->id}}"> {{$category->name}}</div>
                                               @endif
                                           @endif
                                       @endif
                                   </label>
                               @endforeach
                           </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                @if ($moneybox)
                                    <input type="hidden" ng-model="amount_id" ng-init="amount_id='{{$amountoption->id}}'">
                                    <input type="hidden" ng-model="privacy_id" ng-init="privacy_id='{{$privacyoption->id}}'">
                                    <input type="hidden" ng-model="moneybox_id" ng-init="moneybox_id='{{$moneybox->id}}'">
                                    <input readonly type="text" class="form-control" placeholder="Nombre de la alcancía" ng-model="name" ng-init="name='{{$moneybox->name}}'" autocomplete="off">
                                @else
                                    @if($name != "")
                                        <input type="text" class="form-control" placeholder="Nombre de la alcancía" ng-model="name" autocomplete="off" ng-init="name='{{$name}}'">
                                    @else
                                        <input type="text" class="form-control" placeholder="Nombre de la alcancía" ng-model="name" autocomplete="off">
                                    @endif
                                @endif
                                </div>

                                <div class="form-group">
                                    <input readonly id="person_name" name="person_name" type="text" class="form-control" placeholder="Nombre de quién la organiza" ng-init="person_name='{{Auth::user()->person->name." ".Auth::user()->person->lastname}}'" ng-model="person_name" autocomplete="off">
                                    <input id="person_id" name="person_id" type="hidden" class="form-control" ng-init="person_id='{{Auth::user()->person->id}}'" ng-model="person_id">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <picture style="margin-right: 15px">
                                                @if ($moneybox)
                                                    <img  id="moneybox-image" class="icon-file"
                                                        style="height: 50px; width: auto"
                                                        src="{{$moneybox->image ? url('/moneybox/image/' . $moneybox->image) : '/images/icon-file.png'}}">
                                                @else
                                                    <img  id="moneybox-image" class="icon-file"
                                                        style="height: 50px; width: auto"
                                                        src="/images/icon-file.png">
                                                @endif
                                            </picture>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <input id="file"
                                               onchange="angular.element(this).scope().fileChanged(this)"
                                               ng-model="file"
                                               name="file"
                                               type="file"
                                               accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                @if ($moneybox)
                                    <textarea id="description" name="description"  class="form-control" rows="3" placeholder="Descripción" ng-model="description" ng-init="description='{{$moneybox->description}}'"></textarea>
                                @else
                                    <textarea id="description" name="description"  class="form-control" rows="3" placeholder="Descripción" ng-model="description"></textarea>
                                @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                @if ($moneybox)
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input readonly type="text" class="form-control" placeholder="Cantidad que desea reunir" ng-model="goal_amount" ng-init="goal_amount='{{$moneybox->goal_amount}}'" autocomplete="off">
                                </div>
                                @else
                                <div class="input-group">
                                    <div class="input-group-addon">$</div>
                                    <input type="text" class="form-control" placeholder="Cantidad que desea reunir" ng-model="goal_amount" autocomplete="off">
                                </div>
                                @endif
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-9">
                                        @if ($moneybox)
                                            <input id="datepicker" type="text" class="form-control" placeholder="Fecha límite para reunir los fondos" ng-model="end_date" ng-init="end_date='{{ \App\Utilities\PLUtils::invertirFecha($moneybox->end_date) }}'" autocomplete="off">
                                        @else
                                           <input id="datepicker" type="text" class="form-control" placeholder="Fecha límite para reunir los fondos" ng-model="end_date" autocomplete="off">
                                        @endif
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

            <div class="container-fluid step-2" id="moneybox-step2">
                <div class="header-block">
                    <div class="stage-item">
                        <div class="stage-item-title">Participación</div>
                        <div class="icon-step icon-step-2"></div>
                        <div class="label">Información</div>
                        <div class="label active">Participación</div>
                    </div>
                </div>
                <div class="content-block">
                    <form class="form-horizontal form register moneybox">
                        @foreach($settings as $setting)
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <label>{{utf8_decode($setting->name)}}</label>
                                    @foreach($setting->options as $i => $option)
                                        <div class="radio">
                                            @if ($option->subtype=='text')
                                                <label for="{{$option->name}}" class="flex-element">
                                                    <input id="{{$option->name}}" style="margin-top: -2px;" class="radio-option" type="radio" value="{{$setting->id}}|{{$option->id}}|Y" ng-model="participation" ng-change="changeParticipation()">
                                                    <span style="margin-right: 15px;">{{$option->name}}</span>
                                                    <div class="input-group" style="max-width: 250px; width: 100%;">
                                                        <div class="input-group-addon">$</div>
                                                        <input class="form-control" type="number" value="50" id="txt-option-{{$option->id}}">
                                                        <strong style="margin-left:7px; margin-top: 7px; display: inline-block"> MXN</strong>
                                                    </div>
                                                </label>
                                            @else
                                                <label for="{{$option->name}}">
                                                    @if ($setting->id == 1)
                                                        <input id="{{$option->name}}" type="radio" class="radio-option" value="{{$setting->id}}|{{$option->id}}|N" ng-model="participation" ng-change="changeParticipation()"> {{$option->name}}
                                                    @else
                                                        <input id="{{$option->name}}" type="checkbox" ng-false-value="'0|0|N'" ng-true-value="'{{$setting->id}}|{{$option->id}}|N'" ng-model="privacy{{$i+1}}" ng-change="changePrivacy()"> {{$option->name}}
                                                    @endif
                                                </label>
                                            @endif
                                        </div> <!-- ./radio -->
                                    @endforeach
                                </div>
                            </div> <!-- ./form-group -->
                        @endforeach
                        <div class="form-group">
                            <div class="col-sm-12">
                                <button class="btn btn-primary pull-right" ng-click="createMoneybox()">Siguiente ></button>
                                <a href="#" class="btn-link pull-right" ng-click="step2Click()">< Volver </a>
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