@extends("layouts.content")

@section("page-content")
    <section class="block profile-view">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="stage-item">
                        <div class="icon-step icon-step-1"></div>
                        <div class="label active">Mi perfil</div>
                        <div class="label">Contraseña</div>
                        <div class="label">Contacto</div>
                    </div>
                </div>
                <div class="content-block">
                    <form class="form register">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nombre(s)</label>
                                    <div class="row">
                                        <div class="col-sm-5"><input id="name" class="form-control" name="name"
                                                                     placeholder="Nombre(s)" type="text"
                                                                     ng-model="name"></div>
                                        <div class="col-sm-7"><input id="lastname" class="form-control" name="lastname"
                                                                     placeholder="Apellido" type="text"
                                                                     ng-model="lastname">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input id="email" class="form-control" name="email" placeholder="Correo Electrónico"
                                           type="email" ng-model="email">
                                </div>

                                <div class="form-group">
                                    <label for="gender">Sexo</label>
                                    <select name="gender" id="gender" class="form-control" ng-model="gender">
                                        <option value="M">Femenino</option>
                                        <option value="H">Masculino</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="usuario">Usuario</label>
                                    <input id="usuario" class="form-control" name="usuario" placeholder="Usuario"
                                           type="text"
                                           ng-model="username">
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="country">País</label>
                                    <input id="country" class="form-control" name="country" placeholder="País"
                                           type="text"
                                           ng-model="country">
                                </div>

                                <div class="form-group">
                                    <label for="city">Ciudad</label>
                                    <input id="city" class="form-control" name="city" placeholder="Ciudad" type="text"
                                           ng-model="city">
                                </div>
                                <div class="form-group">
                                    <label for="month">Fecha de Nacimiento</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select class="form-control" name="month" id="month"
                                                    ng-model="birthdayMonth">
                                                <option value="-1">Mes</option>

                                                @foreach($months as $mont)
                                                    <option value="{{$mont}}">{{$mont}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="day" id="day" ng-model="birthdayDay">
                                                <option value="-1">Día</option>
                                                @for($i = 1;  $i <= 31; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="year" id="year" ng-model="birthdayYear">
                                                <option value="-1">Año</option>
                                                @for($i = 2016 - 18;  $i >= 1950; $i--)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- ./row -->


                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small" ng-click="emailRegister()">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('js')

@endsection