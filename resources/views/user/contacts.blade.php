@extends("layouts.content")

@section("page-content")
    <section class="block profile-view contacts">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="stage-item">
                        <div class="icon-step icon-step-3"></div>
                        <div class="label">Mi perfil</div>
                        <div class="label">Contraseña</div>
                        <div class="label active">Contacto</div>
                    </div>
                </div>
                <div class="content-block">
                    <div class="form register">
                        <div class="form-group">
                            <label class="text-info">Comparte tu alcancía en tus redes sociales</label>
                        </div>

                        <div class="form-group">
                            <a class="btn-share-fb" href="javascript:void(0)">
                                <span>Compartir en</span>
                                <img src="/images/facebook-logo.png" alt="">
                            </a>
                        </div>

                        <div class="form-group">
                            <a class="btn-share-twitter" href="javascript:void(0)">
                                <span>Compartir en</span>
                                <img src="/images/twitter-logo.png" alt="">
                            </a>
                        </div>
                    </div>

                    <form class="form register" action="" method="post">
                        <div class="form-group">
                            <label class="text-info">O envía correo a tus amigos para invitarlos a participar.</label>
                            <div class="small">Introduce los emails separando cada uno con punto y coma (;)</div>
                            <textarea required name="email" id="email" class="form-control" rows="3" placeholder="Introduce las direcciones de correo"></textarea>
                        </div>

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small">Enviar invitaciones</button>
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