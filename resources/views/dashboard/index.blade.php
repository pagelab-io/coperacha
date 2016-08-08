@extends("dashboard.layouts.app")

@section("content")
    <div class="container">
        <section class="dashboard">
            <h3 class="title-1">Dashboard</h3>
            <hr>
            <div class="items">
                <div class="item">
                    <header>
                        <div class="item-title">Usuarios del servicio</div>
                        <div class="item-desc">Número total de usuarios (inscritos/activos) por genero, edad, ciudad</div>
                    </header>
                    <main>
                        <table class="table table-striped table-responsive">
                            <caption>
                                <span class="small">Total de Usuarios: {{$users['total']}}</span>
                            </caption>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Genero</th>
                                    <th>Cantidad</th>
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
                    </main>
                </div>
                <div class="item">
                    <header>
                        <div class="item-title">alcancías</div>
                        <div class="item-desc">Cuantas alcancías se crean diario, mensual, anual</div>
                    </header>
                    <main>
                        <table class="table table-striped table-responsive">
                            <caption>
                                <div>Creación de alcancías promedio</div>
                                <span class="small"></span>
                            </caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Alcancías</th>
                                <th>Cantidad</th>
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
                    </main>
                </div>
                <div class="item">
                    <header>
                        <div class="item-title">Durabiliad</div>
                        <div class="item-desc">La durabilidad promedio, el monto promedio recaudado (diario, mensual, anual), la coperacha promedio por alcancía</div>
                    </header>
                    <main>
                        <table class="table table-striped table-responsive">
                            <caption>
                            </caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tipo</th>
                                <th>Promedio</th>
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
                    </main>
                </div>
                <div class="item">
                    <header>
                        <div class="item-title">Métodos de Pago</div>
                        <div class="item-desc">Porcentaje de uso</div>
                    </header>
                    <main>
                        <table class="table table-striped table-responsive">
                            <caption>
                            </caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Método de Pago</th>
                                <th>Valor Promedio</th>
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
                    </main>
                </div>
            </div>
        </section>
    </div>
@stop