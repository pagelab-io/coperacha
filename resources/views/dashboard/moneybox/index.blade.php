@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>Alcancías</h2>
        <p>Información de alcancías registrados actualmente en el sistema.</p>
    </div>
    <div class="dashboard-filters">
        <input type="text" placeholder="Buscar ..."/>
    </div>
    <hr/>
    <section class="dashboard row">
        <div class="main-view rw">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Propietario</th>
                            <th>Total</th>
                            <th>Comisión</th>
                            <th>Status</th>
                            <th>Ver más</th>
                        </tr>
                        @foreach($moneyboxes as $moneybox)
                        <tr>
                            <td>{{$moneybox->id}}</td>
                            <td>{{$moneybox->name}}</td>
                            <td>{{$moneybox->person->name}}</td>
                            <td>{{$moneybox->collected_amount}}</td>
                            <td>{{$moneybox->commision_amount}}</td>
                            <td>{{$moneybox->status}}</td>
                            <td><a href="{{url('/dashboard/moneyboxes/'.$moneybox->url.'')}}">[ícono]</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop