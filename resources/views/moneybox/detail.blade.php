@extends("layouts.master")

@section("content")

    @include('partials.header')

    <section class="block moneybox-profile">
        <div class="holder">
            <div class="container-fluid">
                <div class="content-block">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div class="label-owner">Alcancía organizada por: <span>Emmanuel Sánchez L</span></div>
                            </div>
                       </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-5">
                            <form class="form profile">
                                <div class="form-group">
                                    <picture>
                                        <img src="/images/moneybox-demo.png" alt="moneybox-demo">
                                    </picture>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <img src="/images/icon-profile-user.png" alt="">
                                        Participantes: 7
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <img src="/images/icon-profile-calendar.png" alt="">
                                        21 días 6 horas
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
                                        <img src="/images/icon-profile-total.png" alt="">
                                        Total recaudado: $350
                                    </label>
                                </div>
                                <div class="form-group">
                                    <button class="btn-primary small">Participa</button>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-7">

                            <div class="form share">
                                <div class="form-group">
                                    <label>Comparte tu alcancía en tus redes sociales</label>
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

                                <div class="form-group">
                                    <br>
                                    <label>O envía correo a tus amigos para invitarlos a participar.</label>
                                </div>

                                <div class="form-group">
                                    <div class="text-info">Introduce los emails separando cada uno con punto y coma (;)</div>
                                    <textarea class="form-control" rows="4" placeholder="Introduce las direcciones de correo"></textarea>
                                </div>

                                <div class="form-group clearfix">
                                    <div class="pull-right">
                                        <button class="btn btn-primary small">Enviar invitaciones</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

@endsection