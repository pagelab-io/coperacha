@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>Usuarios</h2>
        <p>Información de usuarios registrados actualmente en el sistema.</p>
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
                            <th>Apellidos</th>
                            <th>Sexo</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th></th>
                        </tr>
                        @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->person->name}}</td>
                            <td>{{$user->person->lastname}}</td>
                            <td>{{\App\Utilities\PLUtils::getStringGender($user->person->gender)}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->person->phone}}</td>
                            <td><a href="{{url('/dashboard/users/'.$user->username.'')}}">Ver más</a></td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </section>
@stop