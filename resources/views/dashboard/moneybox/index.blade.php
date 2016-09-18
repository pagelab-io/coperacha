@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>Alcancías</h2>
        <p>Información de alcancías registradas actualmente en el sistema.</p>
    </div>
    <div class="dashboard-filters clearfix">
            <div class="row pull-right">
                <form accept-charset="UTF-8" method="get" action="{{ route('dashboard.moneyboxes.index') }}" class="search col s12">
                    <div class="row">
                        <div class="input-field col s4">
                            <i class="material-icons prefix">search</i>
                            <input id="search_name" type="text" class="validate" name="name">
                            <label for="search_name">Nombre</label>
                        </div>
                        <div class="input-field col s3">
                            <select id="search_status" name="gender">
                                <option value="">Status</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="input-field col s3">
                            <button class="btn waves-effect waves-light" type="submit">
                                Filtrar
                                <i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    <section class="dashboard">
        <table class="table bordered highlight stripped responsive-table">
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Propietario</th>
                <th>Total</th>
                <th>Comisión</th>
                <th>Status</th>
                <th></th>
            </tr>
            @foreach($moneyboxes as $moneybox)
                <tr>
                    <td>{{$moneybox->id}}</td>
                    <td>{{$moneybox->name}}</td>
                    <td>{{$moneybox->person->name}}</td>
                    <td>{{$moneybox->collected_amount}}</td>
                    <td>{{$moneybox->commission_amount}}</td>
                    <td>{{\App\Utilities\PLUtils::getMoneyboxStatusString($moneybox->active)}}</td>
                    <td><a href="{{url('/dashboard/moneyboxes/'.$moneybox->url.'')}}">Ver más</a></td>
                </tr>
            @endforeach
        </table>
        <!--<ul class="pagination">
            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
            <li class="active"><a href="#!">1</a></li>
            <li class="waves-effect"><a href="#!">2</a></li>
            <li class="waves-effect"><a href="#!">3</a></li>
            <li class="waves-effect"><a href="#!">4</a></li>
            <li class="waves-effect"><a href="#!">5</a></li>
            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>-->
    </section>
@stop