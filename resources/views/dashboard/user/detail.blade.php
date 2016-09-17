@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>{{$user->person->name}} {{$user->person->lastname}}</h2>
        <p>Miembro desde {{\App\Utilities\PLUtils::getStringDate($user->person->created_at, 'mm-YY')}}</p>
    </div>

    <section class="dashboard row">

        <!--general info data-->
        <div class="dashboard general-info col-xs-12">
            <div class="panel panel-primary">
                <!-- header -->
                <div class="panel-heading">
                    Información general
                    <br>
                    <span>Información proporcionada por el usuario desde el momento de su registro.</span>
                </div>
                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table bordered stripped responsive-table">
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
                                <td>{{\App\Utilities\PLUtils::getAge($user->person->birthday)}}</td>
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

        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-primary">
                <!-- header -->
                <div class="panel-heading">
                    Alcancías creadas
                    <br>
                    <span>Información de las alcancías creadas por el usuario.</span>
                </div>

                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table bordered stripped responsive-table">
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

        <div class="col-xs-12 col-sm-6">
            <div class="panel panel-primary">
                <!-- header -->
                <div class="panel-heading">
                    Alcancías en las que participa
                    <br>
                    <span>Información de las alcancías en las que el usuario a participado.</span>
                </div>

                <!-- body -->
                <div class="panel-body">
                    <!-- Table -->
                    <table class="table bordered stripped responsive-table">
                        <thead>
                            <tr>
                                <th class="widget-th">#</th>
                                <th class="widget-th">Nombre alcancía</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($moneyboxes_participation as $moneybox)
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