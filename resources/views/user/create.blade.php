@extends("layouts.content")

@section("page-content")
    <section class="block register" id="register" ng-controller="registerController">
        <div class="holder">
            <div class="container-fluid">
                <div class="content-block">
                    <div class="row">
                        <div class="col-sm-6">
                            <form class="form register">
                                <div class="form-group">
                                    <label for="name">Nombre(s)</label>
                                    <div class="row">
                                        <div class="col-sm-5"><input id="name" class="form-control" name="name" placeholder="Nombre(s)" type="text" ng-model="name"></div>
                                        <div class="col-sm-7"><input id="lastname" class="form-control" name="lastname" placeholder="Apellido" type="text" ng-model="lastname"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input id="email" class="form-control" name="email" placeholder="Correo Electrónico" type="email" ng-model="email">
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
                                    <input id="usuario" class="form-control" name="usuario" placeholder="Usuario" type="text" ng-model="username">
                                </div>

                                <div class="form-group">
                                    <label for="country">País</label>
                                    <input id="country" class="form-control" name="country" placeholder="País" type="text" ng-model="country">
                                </div>

                                <div class="form-group">
                                    <label for="city">Ciudad</label>
                                    <input id="city" class="form-control" name="city" placeholder="City" type="text" ng-model="city">
                                </div>

                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input id="password" class="form-control" name="password" placeholder="Contraseña" type="password" ng-model="password">
                                </div>

                                <div class="form-group">
                                    <label for="confirm">Confirmar Contraseña</label>
                                    <input id="confirm" class="form-control" name="confirm" placeholder="Contraseña" type="password" ng-model="confirmPassword">
                                </div>

                                <div class="form-group">
                                    <label for="month">Fecha de Nacimiento</label>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <select class="form-control" name="month" id="month" ng-model="birthdayMonth">
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

                                <div class="form-group clearfix">
                                    <div class="pull-right">
                                        <button class="btn btn-primary" ng-click="emailRegister()">Crear cuenta</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-sm-6">
                            <div class="sign-in-wrap">
                                <a class="sign-in-fb" href="javascript:void(0)">
                                    <span>O regístrate con</span>
                                    <img src="/images/facebook-logo.png" alt="register with facebook">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="block reasons" id="reasons">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <h2 class="title">5 BUENAS RAZONES PARA CREAR TU CUENTA</h2>
                </div>
                <div class="content-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <ul class="reasons">
                                <li>Accede al mejor servicio online para organizar y financiar tus eventos</li>
                                <li>Comúnica a tus amigos o familia para garantizar el éxito de tu evento</li>
                                <li>Colecta dinero de manera segura, rápida y fácil de usar</li>
                                <li>El servicio es sin compromiso y el almacenamiento de tus datos es confidencial</li>
                                <li>Tendrás un seguimiento claro y completo de tus eventos</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<!-- AngularJS -->
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
    <!-- Facebook SDK -->
    <script src='/js/facebook.js'></script>

    <script src="/js/coperacha.js"></script>
    <script src="/js/Utils.js"></script>
    <script src="/js/controllers/ModalController.js"></script>
    <script src="/js/controllers/RegisterController.js"></script>
    <script src="/js/services/RegisterService.js"></script>
    <script src="/js/directives/CoperachaModal.js"></script>
@endsection