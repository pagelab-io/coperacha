@extends("layouts.content")

@section("page-content")
    <section class="block moneybox-view" id="register">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="stage-item">
                        <div class="stage-item-title">Información</div>
                        <div class="icon-step icon-step-1"></div>
                        <div class="label active">Información</div>
                        <div class="label">Participación</div>
                    </div>
                </div>

                <div class="content-block">
                    <form class="form" ng-controller="moneyboxController">
                        <div class="form-group">
                            <p class="text-info">Llena por favor los siguientes datos:</p>
                        </div>
                        <div class="form-group categories">
                            <label>Selecciona la categoría para la alcancía:</label>
                           <div class="category-items">
                                @foreach($categories as $category)
                                    <label for="chk-{{$category->id}}" class="category-item">
                                        <img src="{{$category->path}}" alt="{{$category->name}}">
                                        <div class="label"><input id="chk-{{$category->id}}" type="radio" name="category" ng-model="category_id" value="{{$category->id}}"> {{$category->name}}</div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input id="name" name="name" type="text" class="form-control" placeholder="Nombre de la alcancía" ng-model="name">
                                </div>

                                <div class="form-group">
                                    <input id="person_name" name="person_name" type="text" class="form-control" placeholder="Nombre de quién la organiza" ng-init="person_name='{{Auth::user()->person->name." ".Auth::user()->person->lastname}}'" ng-model="person_name">
                                    <input id="person_id" name="person_id" type="hidden" class="form-control" ng-init="person_id='{{Auth::user()->person->id}}'" ng-model="person_id">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-xs-2"><span class="icon-file"></span></div>
                                        <div class="col-xs-10"><input id="file" name="file" type="file"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <textarea id="description" name="description"  class="form-control" rows="3" placeholder="Descripción" ng-model="description"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input id="quantity" name="quantity" type="number" class="form-control" placeholder="Cantidad que desea reunir" ng-model="goal_amount">
                                </div>

                                <div class="form-group">
                                    <div class="row">
                                        <!-- maybe this control will be change to a datepicker from jQuery-->
                                        <div class="col-xs-10">
                                            <input id="datepicker" name="end_date" type="text" class="form-control" placeholder="Fecha límite para reunir los fondos" ng-model="end_date">
                                        </div>
                                        <div class="col-xs-2"><span class="icon-calendar"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <a class="btn btn-primary" href="#" ng-click="step1()">Siguiente ></a>
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