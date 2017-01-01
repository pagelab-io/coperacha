@extends("dashboard.layouts.app")

@section("content")
    <!-- Header -->
    <div class="dashboard-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12 col-sm-6">
                    <h2>Órdenes</h2>
                    <p>Muestra una lista de solicitudes de retiro.</p>
                </div>
            </div>
        </div>
    </div>
    <!--/.Header -->

    <!-- Content -->
    <div class="dashboard-body">
        <div class="container-fluid">
            <div class="table-responsive">
                <table class="table bordered highlight stripped responsive-table">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Alcancía</th>
                        <th>Total</th>
                        <th>Cambiar Status</th>
                    </tr>
                    @foreach($orders as $i => $order)
                        <tr>
                            <td>{{ (++$i) }}</td>
                            <td>
                                <div><strong>{{ '('. $order->id . ') ' . ucwords($order->name)}}</strong></div>
                                <div class="small">Email: {{$order->email}}</div>
                                <div class="small">Solicitado: {{$order->created_at}}</div>
                            </td>
                            <td>
                                <div>{{$order->moneybox->name}}</div>
                                <div class="small">Status: {{$order->moneybox->getStatusAsString()}}</div>
                            </td>
                            <td>
                                <div>{{$order->moneybox->collected_amount}}</div>
                            </td>
                            <td>
                                @if($order->moneybox->active == 2)
                                    <a title="Cambiar a Activa" href="{{url('/dashboard/orders/toggle', [
                                        'id' => $order->moneybox->id, 'status' => 1])}}" class="btn btn-sm btn-success">
                                        Activa
                                        <i class="material-icons right">send</i>
                                    </a>
                                @else
                                    <a title="Cambiar a Completada" href="{{url('/dashboard/orders/toggle', [
                                    'id' => $order->moneybox->id, 'status' => 2])}} " class="btn btn-sm btn-default">
                                        Completada
                                        <i class="material-icons right">send</i>
                                    </a>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <!-- /.Content -->
@stop