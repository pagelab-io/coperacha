@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>Alcancías</h2>
        <p>Información de alcancías registrados actualmente en el sistema.</p>
    </div>
    <div class="dashboard-filters clearfix">
        <div class="pull-right">
            <form action="" class="search">
                <div class="input-field">
                    <i class="material-icons prefix">search</i>
                    <input id="icon_prefix" type="text" class="validate">
                    <label for="icon_prefix">Buscar</label>
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
                    <td>{{$moneybox->active == 1 ? 'Active' : 'Completado'}}</td>
                    <td><a href="{{url('/dashboard/moneyboxes/'.$moneybox->url.'')}}">Ver más</a></td>
                </tr>
            @endforeach
        </table>
        <ul class="pagination">
            <li class="disabled"><a href="#!"><i class="material-icons">chevron_left</i></a></li>
            <li class="active"><a href="#!">1</a></li>
            <li class="waves-effect"><a href="#!">2</a></li>
            <li class="waves-effect"><a href="#!">3</a></li>
            <li class="waves-effect"><a href="#!">4</a></li>
            <li class="waves-effect"><a href="#!">5</a></li>
            <li class="waves-effect"><a href="#!"><i class="material-icons">chevron_right</i></a></li>
        </ul>
    </section>
@stop