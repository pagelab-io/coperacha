@extends("dashboard.layouts.app")

@section("content")

    <!-- Title and description-->
    <div class="dashboard-titles">
        <div class="clearfix">
            <div style="float: left">
                <img id="moneybox-image" class="icon-file"
                     style="height: 50px; width: auto"
                     src="{{$moneybox->lastimage ? url('/moneybox/image/' . $moneybox->lastimage) : url($moneybox->category->path)}}">
            </div>
            <div style="float: left; margin-left: 10px">
                <h2>{{$moneybox->name}}</h2>
                <p>Alcancia creada desde {{\App\Utilities\PLUtils::getStringDate($moneybox->created_at)}}</p>
            </div>
        </div>
    </div>
    <hr>
    <section class="dashboard row">

        <!--general info data-->
        <div class="dashboard general-info col-xs-12">
            <div class="panel panel-primary">
                <!-- header -->
                <div class="panel-heading">
                    Información general
                    <br>
                    <span>Datos de creación de la alcancía.</span>
                </div>
                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table bordered stripped responsive-table">
                        <tbody>
                            <tr>
                                <td>Nombre</td>
                                <td>{{$moneybox->name}}</td>
                            </tr>
                            <tr>
                                <td>Descripción</td>
                                <td>{{$moneybox->description}}</td>
                            </tr>
                            <tr>
                                <td>Categoría</td>
                                <td>{{$moneybox->category->name}}</td>
                            </tr>
                            <tr>
                                <td>Organizador</td>
                                <td>{{$moneybox->person->name." ".$moneybox->person->lastname}}</td>
                            </tr>
                            <tr>
                                <td>Meta deseada</td>
                                <td>${{number_format($moneybox->goal_amount, 2)}}</td>
                            </tr>
                            <tr>
                                <td>Monto recaudado</td>
                                <td>${{number_format($moneybox->collected_amount, 2)}}</td>
                            </tr>
                            <tr>
                                <td>Fecha limite</td>
                                <td>{{\App\Utilities\PLUtils::getStringDate($moneybox->end_date)}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-12">
            <div class="panel panel-primary">
                <!-- header -->
                <div class="panel-heading">
                    Información de pagos
                    <br>
                    <span>Pagos realizados para esta alcancía.</span>
                </div>

                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table bordered stripped responsive-table">
                        <thead>
                            <tr>
                                <th class="widget-th">#</th>
                                <th class="widget-th">Participante</th>
                                <th class="widget-th">Monto</th>
                                <th class="widget-th">Fecha del pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments['paymentsGeneral'] as $payment)
                            <tr>
                                <td>{{$payment->id}}</td>
                                <td>{{$payment->person->name." ".$payment->person->lastname}}</td>
                                <td>{{'$ '.number_format($payment->amount, 2)}}</td>
                                <td>{{$payment->created_at->format('Y-m-d')}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-primary">
                <!-- header -->
                <div class="panel-heading">
                    Participación
                    <br>
                    <span>Información de los participantes en esta alcancía.</span>
                </div>

                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table bordered stripped responsive-table">
                        <thead>
                            <tr>
                                <th class="widget-th">#</th>
                                <th class="widget-th">Nombre participante</th>
                                <th class="widget-th"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($moneybox->participants as $participant)
                            <tr>
                                <td>{{$participant->id}}</td>
                                <td>{{$participant->person->name." ".$participant->person->lastname}}</td>
                                <td><a href="{{url('/dashboard/users/'.$participant->person->user->username.'')}}">Ver más</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-primary">
                <!-- header -->
                <div class="panel-heading">
                    Métodos pago
                    <br>
                    <span>Métodos de pago usados para participar en esta alcancía.</span>
                </div>

                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table bordered stripped responsive-table">
                        <thead>
                            <tr>
                                <th class="widget-th">Método de pago</th>
                                <th class="widget-th">% de uso</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments['paymentsAVG'] as $payment => $value)
                            <tr>
                                <td>{{\App\Utilities\PLUtils::getPaymentMethodString($payment)}}</td>
                                <td>{{number_format($value, 2)."%"}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
@stop