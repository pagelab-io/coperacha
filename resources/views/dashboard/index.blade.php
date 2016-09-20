@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>Dashboard</h2>
        <p>Estadisticas y gráficas acerca de lo mas importante en Coperacha.</p>
    </div>

    <br>

    <!-- Content -->
    <section class="dashboard row">
        <!-- row -->
        <div class="dashboard-items">
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
                                <span class="small">Total de Usuarios: {{$statics['totalUsers']}}</span>
                            </caption>
                            <thead>
                                <tr>
                                    <th class="widget-th">#</th>
                                    <th class="widget-th">Género</th>
                                    <th class="widget-th">Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statics['genderAVG'] as $key => $value)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{\App\Utilities\PLUtils::getStringGender($key)}}</td>
                                        <td>{{number_format($value, 2)." %"}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th class="widget-th">#</th>
                                    <th class="widget-th">Ciudad</th>
                                    <th class="widget-th">Porcentaje</th>
                                </tr>
                                @foreach($statics['cityAVG'] as $key => $value)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$key}}</td>
                                        <td>{{number_format($value, 2)." %"}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th class="widget-th">#</th>
                                    <th class="widget-th">País</th>
                                    <th class="widget-th">Porcentaje</th>
                                </tr>
                                @foreach($statics['countryAVG'] as $key => $value)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$key}}</td>
                                        <td>{{number_format($value, 2)." %"}}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th class="widget-th">#</th>
                                    <th class="widget-th">Edad</th>
                                    <th class="widget-th">Porcentaje</th>
                                </tr>
                                @foreach($statics['ageAVG'] as $key => $value)
                                    <tr>
                                        <td>{{$i++}}</td>
                                        <td>{{$key != "No definido" ? $key." años ": $key}}</td>
                                        <td>{{number_format($value, 2)." %"}}</td>
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
        </div>

        <!-- row -->
        <div class="dashboard-items">
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
                                    <td>{{\App\Utilities\PLUtils::getPaymentMethodString($row->method)}}</td>
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
        </div>
    </section>
@stop