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
                        Creación de alcancias
                        <br>
                        <span>Cuantas alcancías se crean diario, mensual, anual</span>
                    </div>
                    <!-- body -->
                    <div class="panel-body">
                        <div class="dashboard-graph" id="moneyboxesChart"></div>
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
                            @foreach($moneyboxes['moneyboxes'] as $type => $value)
                                <tr>
                                    <td></td>
                                    <td>{{$type}}</td>
                                    <td>{{number_format($value, 3)}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--footer-->
                    <div class="panel-footer">
                        <a href="{{url('/dashboard/moneyboxes')}}">Ver más ></a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-primary">

                    <!-- header -->
                    <div class="panel-heading">
                        Alcancías - Estadisticas generales
                        <br>
                        <span>Durabilidad, monto recaudado y monto a alcanzar promedio</span>
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
                            @foreach($moneyboxes['durability'] as $type => $value)
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

        </div>
        <div class="dashboard-items">

            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-primary">

                    <!-- header -->
                    <div class="panel-heading">
                        Métodos de pago
                        <br>
                        <span>Porcentaje de uso</span>
                    </div>
                    <!-- body -->
                    <div class="panel-body">
                        <div class="dashboard-graph" id="paymentsChart"></div>
                        <!-- Table -->
                        <table class="table table-striped table-responsive">
                            <caption>
                                Total de pagos completados: {{$completedPayments}}
                            </caption>
                            <thead>
                            <tr>
                                <th class="widget-th">#</th>
                                <th class="widget-th">Método de Pago</th>
                                <th class="widget-th">Porcentaje</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($payments as $payment => $value)
                                <tr>
                                    <td></td>
                                    <td>{{\App\Utilities\PLUtils::getPaymentMethodString($payment)}}</td>
                                    <td>{{number_format($value, 2)}} %</td>
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
                        Usuarios por tipo de registro
                        <br>
                        <span>Número de usuarios registrados por Facebook y por correo electrónico</span>
                    </div>
                    <!-- body -->
                    <div class="panel-body">
                        <div class="dashboard-graph" id="registerChart"></div>
                        <!-- Table -->
                        <table class="table table-striped table-responsive">
                            <caption>
                                <span class="small">Total de Usuarios: {{$statics['totalUsers']}}</span>
                            </caption>
                            <thead>
                                <tr>
                                    <th class="widget-th">#</th>
                                    <th class="widget-th">Tipo registro</th>
                                    <th class="widget-th">Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($statics['registerAVG'] as $key => $value)
                                   <tr>
                                       <td></td>
                                       <td>{{$key}}</td>
                                       <td>{{number_format($value, 2)." %"}}</td>
                                   </tr>
                               @endforeach
                               <tr>
                                  <td></td>
                                  <td>Usuarios registrados en el día</td>
                                  <td>{{$statics['todayRegisters']}}</td>
                              </tr>
                            </tbody>
                        </table>
                    </div>
                    <!--footer-->
                    <div class="panel-footer">
                        <a href="{{url('dashboard/users')}}">Ver más ></a>
                    </div>
                </div>
            </div>

        </div>
        <div class="dashboard-items">

            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-primary">

                    <!-- header -->
                    <div class="panel-heading">
                        Usuarios por género
                        <br>
                        <span>Número total de usuarios (inscritos/activos) por genero</span>
                    </div>
                    <!-- body -->
                    <div class="panel-body">
                        <div class="dashboard-graph" id="genderChart"></div>
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
                                        <td></td>
                                        <td>{{\App\Utilities\PLUtils::getStringGender($key)}}</td>
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
                        Usuarios por ciudad
                        <br>
                        <span>Número total de usuarios (inscritos/activos) por Ciudad</span>
                    </div>
                    <!-- body -->
                    <div class="panel-body">
                        <div class="dashboard-graph" id="cityChart"></div>
                        <!-- Table -->
                        <table class="table table-striped table-responsive">
                            <caption>
                                <span class="small">Total de Usuarios: {{$statics['totalUsers']}}</span>
                            </caption>
                            <thead>
                                <tr>
                                    <th class="widget-th">#</th>
                                    <th class="widget-th">Ciudad</th>
                                    <th class="widget-th">Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($statics['cityAVG'] as $key => $value)
                                   <tr>
                                       <td></td>
                                       <td>{{$key}}</td>
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

        </div>
        <div class="dashboard-items">

            <div class="col-xs-12 col-sm-6">
                <div class="panel panel-primary">

                    <!-- header -->
                    <div class="panel-heading">
                        Usuarios por país
                        <br>
                        <span>Número total de usuarios (inscritos/activos) por País</span>
                    </div>
                    <!-- body -->
                    <div class="panel-body">
                        <div class="dashboard-graph" id="countryChart"></div>
                        <!-- Table -->
                        <table class="table table-striped table-responsive">
                            <caption>
                                <span class="small">Total de Usuarios: {{$statics['totalUsers']}}</span>
                            </caption>
                            <thead>
                                <tr>
                                    <th class="widget-th">#</th>
                                    <th class="widget-th">País</th>
                                    <th class="widget-th">Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                               @foreach($statics['countryAVG'] as $key => $value)
                                   <tr>
                                       <td></td>
                                       <td>{{$key}}</td>
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
                        Usuarios por edad
                        <br>
                        <span>Número total de usuarios (inscritos/activos) por Edad</span>
                    </div>
                    <!-- body -->
                    <div class="panel-body">
                        <div class="dashboard-graph" id="ageChart"></div>
                        <!-- Table -->
                        <table class="table table-striped table-responsive">
                            <caption>
                                <span class="small">Total de Usuarios: {{$statics['totalUsers']}}</span>
                            </caption>
                            <thead>
                                <tr>
                                    <th class="widget-th">#</th>
                                    <th class="widget-th">Edad</th>
                                    <th class="widget-th">Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($statics['ageAVG'] as $key => $value)
                                    <tr>
                                        <td></td>
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

        </div>
    </section>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {

        var genderData = google.visualization.arrayToDataTable([
          ['Género', 'Porcentaje'],
          @foreach($statics['genderAVG'] as $key => $value)
            ['{{$key}}', {{$value}}],
          @endforeach
        ]);

        var registerData = google.visualization.arrayToDataTable([
            ['Tipo registro', 'Porcentaje'],
            @foreach($statics['registerAVG'] as $key => $value)
                ['{{$key}}', {{$value}}],
            @endforeach
        ]);

        var cityData = google.visualization.arrayToDataTable([
            ['Ciudad', 'Porcentaje'],
            @foreach($statics['cityAVG'] as $key => $value)
                ['{{$key}}', {{$value}}],
            @endforeach
        ]);

        var countryData = google.visualization.arrayToDataTable([
            ['País', 'Porcentaje'],
            @foreach($statics['countryAVG'] as $key => $value)
                ['{{$key}}', {{$value}}],
            @endforeach
        ]);

        var ageData = google.visualization.arrayToDataTable([
          ['Edad', 'Porcentaje'],
          @foreach($statics['ageAVG'] as $key => $value)
              ['{{$key}}', {{$value}}],
          @endforeach
        ]);

        var moneyboxesData = google.visualization.arrayToDataTable([
            ['Alcancías', '2016'],
            @foreach($moneyboxes['moneyboxes'] as $key => $value)
                ['{{$key}}', {{$value}}],
            @endforeach
        ]);

        var paymentData = google.visualization.arrayToDataTable([
            ['Método de pago', '2016'],
            @foreach($payments as $payment => $value)
                ['{{$payment}}', {{$value}}],
            @endforeach
        ]);

          var optionsBar = {
            chartArea:{width:'50%',height:'50%'},
            hAxis: {
              title: 'Total alcancías',
              minValue: 0
            }
          };


        var options = {
          chartArea:{width:'100%',height:'100%', left:'25px'}
        };

        var genderChart = new google.visualization.PieChart(document.getElementById('genderChart'));
        var registerChart = new google.visualization.PieChart(document.getElementById('registerChart'));
        var cityChart = new google.visualization.PieChart(document.getElementById('cityChart'));
        var countryChart = new google.visualization.PieChart(document.getElementById('countryChart'));
        var ageChart = new google.visualization.PieChart(document.getElementById('ageChart'));
        var moneyboxesChart = new google.visualization.BarChart(document.getElementById('moneyboxesChart'));
        var paymentsChart = new google.visualization.PieChart(document.getElementById('paymentsChart'));

        genderChart.draw(genderData, options);
        registerChart.draw(registerData, options);
        cityChart.draw(cityData, options);
        countryChart.draw(countryData, options);
        ageChart.draw(ageData, options);
        moneyboxesChart.draw(moneyboxesData, optionsBar);
        paymentsChart.draw(paymentData, options);
      }
    </script>
@stop