@extends("dashboard.layouts.app")

@section("content")

    <!-- Header -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <h2>Alcancías</h2>
                    <p>Información de alcancías registradas actualmente en el sistema.</p>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3 col-xs-12"></div>
                <div class="col-sm-9 col-xs-12">
                    <form accept-charset="UTF-8" method="get" action="{{ route('dashboard.moneyboxes.index') }}"
                          class="search">
                        <div class="clearfix">
                            <div class="input-field col-sm-5">
                                <i class="material-icons prefix">search</i>
                                <input id="search_name" type="text" class="validate" name="name">
                                <label for="search_name">Nombre</label>
                            </div>
                            <div class="input-field col-sm-3">
                                <select id="search_status" name="status">
                                    <option value="">Status</option>
                                    <option value="1">Activa</option>
                                    <option value="2">Completada</option>
                                </select>
                            </div>
                            <div class="input-field col-sm-3">
                                <button class="btn waves-effect waves-light" type="submit">
                                    Filtrar
                                    <i class="material-icons right">send</i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/.Header -->

    <!-- Content -->
    <div class="dashboard-body">
        <div class="container-fluid">
            <table class="table bordered highlight stripped responsive-table">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Organizador</th>
                    <th>Monto recaudado</th>
                    <th>Comisión (5%)</th>
                    <th>Fecha vencimiento</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @foreach($moneyboxes as $moneybox)
                    <tr>
                        <td>{{$moneybox->id}}</td>
                        <td>{{$moneybox->name}}</td>
                        <td>{{$moneybox->person->name." ".$moneybox->person->lastname}}</td>
                        <td>{{'$ '.number_format($moneybox->collected_amount, 2)}}</td>
                        <td>{{'$ '.number_format($moneybox->commission_amount, 2)}}</td>
                        <td>{{$moneybox->end_date}}</td>
                        <td>{{\App\Utilities\PLUtils::getMoneyboxStatusString($moneybox->active)}}</td>
                        <td><a href="{{url('/dashboard/moneyboxes/'.$moneybox->url.'')}}">Ver más</a></td>
                    </tr>
                @endforeach
            </table>
            <ul class="pagination hidden">
                <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
                <li class="active"><a href="#!">1</a></li>
                <li class="waves-effect"><a href="#!">2</a></li>
                <li class="waves-effect"><a href="#!">3</a></li>
                <li class="waves-effect"><a href="#!">4</a></li>
                <li class="waves-effect"><a href="#!">5</a></li>
                <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
            </ul>
        </div>
    </div>
@stop