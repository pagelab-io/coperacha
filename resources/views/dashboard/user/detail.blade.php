@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>{{$user->person->name}} {{$user->person->lastname}}</h2>
        <p>Miembro desde 17/09/2016</p>
    </div>

    <section class="dashboard row">

        <!--general info data-->
        <div class="dashboard general-info">

            <div class="panel panel-primary">

                <!-- header -->
                <div class="panel-heading">
                    Información general
                </div>

                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table table-striped table-responsive">
                        <tbody>
                            <tr>
                                <td>Correo electrónico</td>
                                <td>{{$user->email}}</td>
                            </tr>
                            <tr>
                                <td>Teléfono</td>
                                <td>{{$user->person->phone}}</td>
                            </tr>
                            <tr>
                                <td>Sexo</td>
                                <td>{{\App\Utilities\PLUtils::getStringGender($user->person->gender)}}</td>
                            </tr>
                            <tr>
                                <td>Edad</td>
                                <td>{{$user->person->birthday}}</td>
                            </tr>
                            <tr>
                                <td>Ciudad</td>
                                <td>{{$user->person->city}}</td>
                            </tr>
                            <tr>
                                <td>País</td>
                                <td>{{$user->person->country}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!--more relevant info-->
        <div class="dashboard more-info">

            <div class="panel panel-primary">

                <!-- header -->
                <div class="panel-heading">
                    Alcancías creadas
                </div>

                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table table-striped table-responsive">
                        <thead>
                            <tr>
                                <th class="widget-th">#</th>
                                <th class="widget-th">Nombre alcancía</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($my_moneyboxes as $moneybox)
                            <tr>
                                <td>{{$moneybox->id}}</td>
                                <td>{{$moneybox->name}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </section>
@stop