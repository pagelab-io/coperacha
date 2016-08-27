@extends("layouts.content")

@section("page-content")
    <div id="ProfileView" class="block profile-view" data-userid="{{$user->id}}">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <div class="stage-element">
                        <a class="stage-item profile" v-on:click="onClickProfile($event)" v-bind:class="{'selected':isProfile}">
                            <div class="stage-item-icon"></div>
                            <div class="stage-item-label">Mi perfil</div>
                            <div class="stage-bar"></div>
                        </a>
                        <a class="stage-item password" v-on:click="onClickPassword($event)" v-bind:class="{'selected':isPassword}">
                            <div class="stage-item-icon"></div>
                            <div class="stage-item-label">Contraseña</div>
                            <div class="stage-bar"></div>
                        </a>
                        <a class="stage-item share" v-on:click="onClickShare($event)" v-bind:class="{'selected':isShare}">
                            <div class="stage-item-icon"></div>
                            <div class="stage-item-label">Contacto</div>
                        </a>
                    </div>
                </div>

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
                                                   v-model="person.name">
                                        </div>
                                        <div class="col-sm-7">
                                            <input id="lastname" class="form-control"
                                                   name="lastname"
                                                   placeholder="Apellido"
                                                   type="text"
                                                   v-model="person.lastname">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="email">Teléfono</label>
                                    <input id="email"
                                           class="form-control"
                                           name="phone"
                                           placeholder="Teléfono"
                                           type="phone"
                                           v-model="person.phone">
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
                                           v-model="user.username">
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico</label>
                                    <input id="email"
                                           class="form-control"
                                           name="email"
                                           placeholder="Correo Electrónico"
                                           type="email" v-model="user.email">
                                </div>

                                <div class="form-group">
                                    <label for="country">País</label>
                                    <input id="country" class="form-control" name="country" placeholder="País"
                                           type="text"
                                           v-model="person.country">
                                </div>

                                <div class="form-group">
                                    <label for="city">Ciudad</label>
                                    <input id="city" class="form-control" name="city" placeholder="Ciudad" type="text"
                                           v-model="person.city">
                                </div>
                                <div class="form-group">
                                    <label for="month">Fecha de Nacimiento</label>
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <select class="form-control" name="month" id="month" v-model="birthdayMonth">
                                                <option value="-1">Mes</option>

                                                @foreach($months as $mont => $name)
                                                    <option value="{{$mont}}">{{$name}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <select class="form-control" name="day" id="day" v-model="birthdayDay">
                                                <option value="-1">Día</option>
                                                @for($i = 1; $i <= 31; $i++)
                                                    <option value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="year" id="year" v-model="birthdayYear">
                                                <option value="-1">Año</option>
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="current">Contraseña Actual</label>
                                <input id="current" class="form-control"
                                       autocomplete="off"
                                       name="current"
                                       placeholder="Contraseña actual"
                                       type="password"
                                       v-model="passwordData.current" required>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="password">Nueva Contraseña</label>
                                <input id="password" class="form-control"
                                       autocomplete="off"
                                       name="password"
                                       placeholder="Nueva Contraseña"
                                       type="password"
                                       v-model="passwordData.new" required>
                            </div>

                            <div class="form-group">
                                <label for="confirm">Confirmar Contraseña</label>
                                <input id="confirm" class="form-control"
                                       autocomplete="off"
                                       name="confirm"
                                       placeholder="Confirmar Contraseña"
                                       type="password"
                                       v-model="passwordData.confirm" required>
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
                                <img src="/images/twitter-logo.png" alt="twiiter">
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
                </section>
            </div> <!-- ./container -->
        </div> <!-- ./holder -->
    </div> <!-- ./profile-view -->

@endsection

@section('js')
    <script src="{{asset('/js/vendor/vuejs/vue.js')}}"></script>
    <script src="{{asset('/js/vendor/vuejs/vue-resource.js')}}"></script>
    <script src="{{asset('/js/profile/app.js')}}"></script>
@endsection