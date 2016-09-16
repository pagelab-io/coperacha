@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <div class="clearfix">
            <div style="float: left">
                <img id="moneybox-image" class="icon-file"
                     style="height: 50px; width: auto"
                     src="{{$moneybox->lastimage ? url('/moneybox/image/' . $moneybox->lastimage) : '/images/icon-file.png'}}">
            </div>
            <div style="float: left; margin-left: 10px">
                <h2>Nombre: {{$moneybox->name}}</h2>
                <p>Descripción: {{$moneybox->description}}</p>
            </div>
        </div>
    </div>
    <hr>
    <section class="row">
        <div class="col-sm-12">
            <form class="form" role="form">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="first_name">Nombre</label>
                            <input id="first_name" type="text" class="form-control" placeholder="Nombre de la alcancía"
                                   value="{{$moneybox->name}}">
                        </div>

                        <div class="form-group">
                            <label for="person_name">Propietario</label>
                            <input id="person_name" name="person_name" type="text" class="form-control"
                                   placeholder="Nombre de quién la organiza"
                                   value='{{Auth::user()->person->name." ".Auth::user()->person->lastname}}'>
                        </div>

                        <div class="form-group">
                            <label for="description">Descripción</label>
                            <textarea id="description" name="description" class="materialize-textarea form-control" rows="3"
                                      placeholder="Descripción">{{$moneybox->description}}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="amount">Monto</label>
                            <input id="amount" type="text" class="form-control" placeholder="Cantidad que desea reunir"
                                   value='{{$moneybox->goal_amount}}'>
                        </div>

                        <div class="form-group">
                            <label for="datepicker">Fecha Límite</label>
                            <input id="datepicker" type="text" class="form-control"
                                   placeholder="Fecha límite para reunir los fondos" ng-model="end_date"
                                   value='{{$moneybox->end_date}}'>
                        </div>
                    </div>
                </div>
            </form>
            <a href="{{url('/dashboard/moneyboxes')}}" class="btn btn-primary">Regresar</a>
        </div>
    </section>
@stop