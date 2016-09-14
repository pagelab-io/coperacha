@extends("dashboard.layouts.app")

@section("content")
    <div class="container">
        <section class="dashboard">
            <h3 class="title-1">Dashboard</h3>
            <hr>
            <div class="items">

                <div class="dashboard row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="panel panel-primary">

                            <!-- header -->
                            <div class="panel-heading">
                                Usuarios del servicio
                                <br>
                                <span>Número total de usuarios (inscritos/activos) por genero, edad, ciudad</span>
                            </div>
                            <!-- body -->
                            <div class="panel-body">
                                <!-- Table -->
                                <table class="table table-striped table-responsive">
                                    <caption>
                                        <span class="small">Total de Usuarios: {{$users['total']}}</span>
                                    </caption>
                                    <thead>
                                        <tr>
                                            <th class="widget-th">#</th>
                                            <th class="widget-th">Genero</th>
                                            <th class="widget-th">Cantidad</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users['data'] as $i => $row)
                                            <tr>
                                                <td>{{++$i}}</td>
                                                <td>{{$row->gender}}</td>
                                                <td>{{$row->qty}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--footer-->
                            <div class="panel-footer">
                                <a href="{{url('dashboard/users')}}">Ver más ></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="panel panel-primary">

                            <!-- header -->
                            <div class="panel-heading">
                                alcancías
                                <br>
                                <span>Cuantas alcancías se crean diario, mensual, anual</span>
                            </div>
                            <!-- body -->
                            <div class="panel-body">
                                <!-- Table -->
                                <table class="table table-striped table-responsive">
                                    <caption>
                                        <div>Creación de alcancías promedio</div>
                                        <span class="small"></span>
                                    </caption>
                                    <thead>
                                    <tr>
                                        <th class="widget-th">#</th>
                                        <th class="widget-th">Alcancías</th>
                                        <th class="widget-th">Cantidad</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($moneyboxes as $type => $value)
                                        <tr>
                                            <td></td>
                                            <td>{{$type}}</td>
                                            <td>{{$value}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--footer-->
                            <div class="panel-footer">
                                <a href="#">Ver más ></a>
                            </div>
                        </div>
                    </div>
                </div> <!-- end row-->

                <div class="dashboard row">
                    <div class="col-xs-12 col-sm-6">
                        <div class="panel panel-primary">

                            <!-- header -->
                            <div class="panel-heading">
                                Durabilidad
                                <br>
                                <span>La durabilidad promedio, el monto promedio recaudado (diario, mensual, anual), la coperacha promedio por alcancía</span>
                            </div>
                            <!-- body -->
                            <div class="panel-body">
                                <!-- Table -->
                                <table class="table table-striped table-responsive">
                                    <caption>
                                    </caption>
                                    <thead>
                                    <tr>
                                        <th class="widget-th">#</th>
                                        <th class="widget-th">Tipo</th>
                                        <th class="widget-th">Promedio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($durability as $type => $value)
                                        <tr>
                                            <td></td>
                                            <td>{{$type}}</td>
                                            <td>{{$value}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--footer-->
                            <div class="panel-footer"></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                        <div class="panel panel-primary">

                            <!-- header -->
                            <div class="panel-heading">
                                métodos de pago
                                <br>
                                <span>Porcentaje de uso</span>
                            </div>
                            <!-- body -->
                            <div class="panel-body">
                                <!-- Table -->
                                <table class="table table-striped table-responsive">
                                    <caption>
                                    </caption>
                                    <thead>
                                    <tr>
                                        <th class="widget-th">#</th>
                                        <th class="widget-th">Método de Pago</th>
                                        <th class="widget-th">Valor Promedio</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payments as $index => $row)
                                        <tr>
                                            <td></td>
                                            <td>{{$row->method}}</td>
                                            <td>{{number_format($row->percent, 2)}} %</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!--footer-->
                            <div class="panel-footer"></div>
                        </div>
                    </div>
                </div> <!-- end row-->
            </div><!--end items-->
        </section>
    </div>
@stop