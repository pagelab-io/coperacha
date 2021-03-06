@extends("layouts.content")

@section('css')
    <link rel="stylesheet" href="{{asset("/js/vendor/bootstrap-select-1.11.2/bootstrap-select.css")}}">
@endsection
@section("page-content")
    <div id="ProfileView" class="block profile-view" data-userid="{{$user->id}}"
         xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <div class="stage-element">
                        <a class="stage-item profile selected" v-on:click.prevent="onClickProfile($event)">
                            <div class="stage-item-icon"></div>
                            <div class="stage-item-label">Mi perfil</div>
                            <div class="stage-bar"></div>
                        </a>

                        <a class="stage-item password" v-on:click.prevent="onClickPassword($event)">
                            <div class="stage-item-icon"></div>
                            <div class="stage-item-label">Contraseña</div>
                            <!--<div class="stage-bar"></div>-->
                        </a>
                        <!--<a class="stage-item share" v-on:click.prevent="onClickShare($event)">
                            <div class="stage-item-icon"></div>
                            <div class="stage-item-label">Contacto</div>
                        </a>-->
                    </div>
                </div>
                <div class="header-block">
                    <div class="message-ui">
                        <div id="message-element" class="alert alert-@{{message.status}}"
                             transition="expand"
                             role="alert"
                             v-show="message.text.length">@{{message.text}}</div>
                    </div>
                    <section id="user-profile"
                             transition="expand"
                             class="content-block"
                             v-show="isProfile"
                             v-bind:class="{'selected':isProfile}">
                        <div v-if="loading" class="loader"></div>
                        <form class="form update-data" v-on:submit.prevent="onUpdateData">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">Nombre(s)</label>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input id="name" class="form-control"
                                                       name="name"
                                                       placeholder="Nombre(s)"
                                                       type="text"
                                                       autocomplete="off"
                                                       v-model="person.name">
                                            </div>
                                            <div class="col-sm-7">
                                                <input id="lastname" class="form-control"
                                                       name="lastname"
                                                       placeholder="Apellido"
                                                       type="text"
                                                       autocomplete="off"
                                                       v-model="person.lastname">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Teléfono</label>
                                        <div class="input-group">
                                            <div class="input-group-addon" style="padding: 0;">
                                                <select id="areacode" name="areacode"
                                                        class="selectpicker"
                                                        v-model="person.areacode"
                                                        data-width="160px"
                                                        data-live-search="true">
                                                    <option value="">Código de área</option>
                                                    @foreach($codes as $code)
                                                        <option value="{{$code['code']}}">{!! $code['name'] .' - <strong>('. $code['code'] . ')</strong>' !!}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input id="phone"
                                                   class="form-control"
                                                   name="phone"
                                                   placeholder="Teléfono"
                                                   type="text"
                                                   autocomplete="off"
                                                   v-model="person.phone">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Sexo</label>
                                        <select name="gender" id="gender" class="form-control"
                                                v-model="person.gender">
                                            <option value="M">Femenino</option>
                                            <option value="H">Masculino</option>
                                        </select>

                                    </div>
                                    <div class="form-group">
                                        <label for="usuario">Usuario</label>
                                        <input id="usuario" class="form-control" name="usuario" placeholder="Usuario"
                                               type="text"
                                               autocomplete="off"
                                               v-model="user.username">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">Correo electrónico</label>
                                        <input id="email"
                                               class="form-control"
                                               name="email"
                                               placeholder="Correo electrónico"
                                               autocomplete="off"
                                               type="text" v-model="user.email">
                                    </div>

                                    <div class="form-group">
                                        <label for="country">País</label>
                                        <input id="country" class="form-control" name="country" placeholder="País"
                                                autocomplete="off"
                                               type="text"
                                               v-model="person.country">
                                    </div>
                                    <div class="form-group">
                                        <label for="city">Ciudad</label>
                                        <input id="city" class="form-control" name="city" placeholder="Ciudad" type="text"
                                            autocomplete="off"
                                            v-model="person.city">
                                    </div>
                                    <div class="form-group">
                                        <label for="month">Fecha de nacimiento</label>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <select class="form-control" name="day" id="day" v-model="birthdayDay">
                                                    <option value="">Día</option>
                                                    @for($i = 1; $i <= 31; $i++)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                <select class="form-control" name="month" id="month" v-model="birthdayMonth">
                                                    <option value="">Mes</option>
                                                    @foreach($months as $mont => $name)
                                                        <option value="{{$mont}}">{{$name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-sm-4">
                                                <select class="form-control" name="year" id="year" v-model="birthdayYear">
                                                    <option value="">Año</option>
                                                    @for($i = 2016 - 18;  $i >= 1950; $i--)
                                                        <option value="{{$i}}">{{$i}}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- ./row -->

                            <div class="form-group clearfix">
                                <div class="pull-right">
                                    <button class="btn btn-primary small">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <section id="user-password"
                             class="content-block"
                             v-show="isPassword"
                             transition="expand"
                             v-bind:class="{'selected':isPassword}">

                        <form autocomplete="off" class="form change-password" v-on:submit.prevent="onChangePassword">
                            <div class="row">
                                <div class="col-sm-6" v-if="user.has_password">
                                    <div class="form-group">
                                        <label for="current">Contraseña actual</label>
                                        <input id="current" class="form-control"
                                               autocomplete="off"
                                               name="current"
                                               placeholder="Contraseña actual"
                                               type="password"
                                               v-model="passwordData.current">
                                    </div>
                                </div>
                                <div v-bind:class="{'col-sm-12':!user.has_password, 'col-sm-6':user.has_password}">
                                    <div class="form-group">
                                        <label for="password">Nueva contraseña</label>
                                        <input id="password" class="form-control"
                                               autocomplete="off"
                                               name="password"
                                               placeholder="Nueva contraseña"
                                               type="password"
                                               v-model="passwordData.new">
                                    </div>

                                    <div class="form-group">
                                        <label for="confirm">Confirmar contraseña</label>
                                        <input id="confirm" class="form-control"
                                               autocomplete="off"
                                               name="confirm"
                                               placeholder="Confirmar contraseña"
                                               type="password"
                                               v-model="passwordData.confirm">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="pull-right">
                                    <a class="btn-link" v-on:click="onClickProfile">< Regresar a mi perfil</a>
                                    <button class="btn btn-primary small">Guardar</button>
                                </div>
                            </div>
                        </form>
                    </section>
                    <section id="user-share"
                             class="content-block"
                             transition="expand"
                             v-show="isShare"
                             v-bind:class="{'selected':isShare}">

                        <div class="form register">
                            <div class="form-group">
                                <label class="text-info">Comparte tu alcancía en tus redes sociales</label>
                            </div>
                            <div class="form-group">
                                <a class="btn-share-fb" href="javascript:void(0)">
                                    <span>Compartir en</span>
                                    <img src="/images/facebook-logo.png" alt="facebook">
                                </a>
                            </div>

                            <div class="form-group">
                                <a class="btn-share-twitter" href="javascript:void(0)">
                                    <span>Compartir en</span>
                                    <img src="/images/twitter-logo.png" alt="twitter">
                                </a>
                            </div>

                        </div>

                        <form class="form register" action="" method="post">
                            <div class="form-group">
                                <label class="text-info">o envía un correo a tus amigos para invitarlos a participar.</label>
                                <div class="small">Introduce los correos separando cada uno con punto y coma (;)</div>
                                <textarea required name="email" id="email" class="form-control" rows="3" placeholder="Introduce las direcciones de correo"></textarea>
                            </div>
                            <div class="form-group clearfix">
                                <div class="pull-right">
                                    <button class="btn btn-primary small">Enviar invitaciones</button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div> <!-- ./container -->
            <div class="container-fluid">
                <hr>
                <div class="form-group text-center">
                    <a href="{{route('moneybox.create')}}" class="btn btn-primary small">Crear mi Alcancía</a>
                </div>
            </div> <!-- ./container -->
        </div> <!-- ./holder -->
    </div> <!-- ./profile-view -->
@endsection

@section('js')
    <script src="{{asset("/js/vendor/bootstrap-3.3.7/js/bootstrap.js")}}"></script>
    <script src="{{asset("/js/vendor/bootstrap-select-1.11.2/bootstrap-select.js")}}"></script>

    <script src="{{asset('/js/vendor/vuejs/vue.js')}}"></script>
    <script src="{{asset('/js/vendor/vuejs/vue-resource.js')}}"></script>

    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker({liveSearch: true });
        });
    </script>

    <script src="{{asset('/js/profile.js')}}"></script>
@endsection