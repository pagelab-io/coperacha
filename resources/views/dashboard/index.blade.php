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
                        <div class="item-desc">Número total de usuarios (inscritos/activos) por genero, edad, cuidad</div>
                    </header>
                    <main>
                        <table class="table table-striped table-responsive">
                            <caption>
                                <div>Usuarios por sexo</div>
                                <span class="small">Total de Usuarios: 500</span>
                            </caption>
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Genero</th>
                                    <th>Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $i => $row)
                                    <tr>
                                        <td>{{++$i}}</td>
                                        <td>{{$row->gender}}</td>
                                        <td>{{$row->total}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </main>
                </div>
                <div class="item">
                    <header>
                        <div class="item-title">Alcancias</div>
                        <div class="item-desc">Cuantas alcancias se crean diario, mensual, anual</div>
                    </header>
                    <main>
                        <table class="table table-striped table-responsive">
                            <caption>
                                <div>Creación de alcancias en promedio</div>
                                <span class="small"></span>
                            </caption>
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Alcancias</th>
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
                        <div class="item-title">La durabilidad promedio</div>
                        <div class="item-desc">El monto promedio recaudado (diario, mensual, anual), la coperacha promedia por alcancia</div>
                    </header>
                    <main>
                        <div class="amount">200</div>
                    </main>
                </div>
                <div class="item">
                    <header>
                        <div class="item-title">Coperacha Promedio</div>
                        <div class="item-desc">Coperacha por medio de pagos (cual es el mas usado)</div>
                    </header>
                    <main>
                        <div class="amount">$ 150 <span>.00</span></div>
                    </main>
                </div>
            </div>
        </section>
    </div>
@stop