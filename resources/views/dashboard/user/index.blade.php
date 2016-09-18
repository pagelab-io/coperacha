@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>Usuarios</h2>
        <p>Información de usuarios registrados actualmente en el sistema.</p>
    </div>
    <div class="dashboard-filters clearfix">
        <div class="row pull-right">
            <form accept-charset="UTF-8" method="get" action="{{ route('dashboard.users.index') }}" class="search col s12">
                <div class="row">
                    <div class="input-field col s4">
                        <i class="material-icons prefix">search</i>
                        <input id="search_name" type="text" class="validate" name="name">
                        <label for="search_name">Nombre(s)</label>
                    </div>
                    <div class="input-field col s3">
                        <select id="search_gender" name="gender">
                            <option value="">Sexo</option>
                            <option value="H">Hombre</option>
                            <option value="M">Mujer</option>
                        </select>
                    </div>
                    <div class="input-field col s3">
                        <button class="btn waves-effect waves-light" type="submit">
                            Filtrar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <hr/>
    <section class="dashboard row">
        <div class="main-view rw">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table bordered highlight stripped responsive-table">
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