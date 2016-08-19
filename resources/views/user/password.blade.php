@extends("layouts.content")

@section("page-content")
    <section class="block profile-view">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="stage-item">
                        <div class="icon-step icon-step-2"></div>
                        <div class="label">Mi perfil</div>
                        <div class="label active">Contraseña</div>
                        <div class="label">Contacto</div>
                    </div>
                </div>
                <div class="content-block">
                    <form class="form register">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="current">Contraseña Actual</label>
                                <input id="current" class="form-control" name="current" placeholder="Contraseña actual" type="password" ng-model="password">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input id="password" class="form-control" name="password" placeholder="Contraseña" type="password" ng-model="password">
                            </div>

                            <div class="form-group">
                                <label for="confirm">Confirmar Contraseña</label>
                                <input id="confirm" class="form-control" name="confirm" placeholder="Contraseña" type="password" ng-model="confirmPassword">
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <a href="{{route('user.profile')}}" class="btn-link">< Regresar a mi perfil</a>
                                <button class="btn btn-primary small">Guardar</button>
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