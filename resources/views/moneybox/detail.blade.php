@extends("layouts.master")
@section("content")
    @include('partials.header')
    <section class="block moneybox-profile" xmlns:v-on="http://www.w3.org/1999/xhtml">
        <div class="holder">
            <div class="container-fluid">
                <div class="content-block">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <div id="moneybox-caption" class="label-owner">
                                    Alcancía organizada por: <span>{{$person->name}} {{$person->lastname}}</span>
                                </div>
                            </div>
                       </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-5">
                            <form class="form profile" ng-controller="participantController">
                                <input id="moneybox-id" type="hidden" value="{{$moneybox->id}}">
                                <input id="moneybox-name" type="hidden" value="{{$moneybox->name}}">
                                <input id="moneybox-desc" type="hidden" value="{{$moneybox->description}}">
                                <input type="hidden" ng-model="moneybox_id" ng-init="moneybox_id='{{$moneybox->id}}'">
                                <div class="form-group">
                                    <picture style="margin-right: 15px">
                                        <img id="moneybox-image"
                                             class="img-responsive"
                                             src="{{$moneybox->lastfile ? asset('/uploads/' . $moneybox->lastfile->name) : asset($moneybox->category->path)}}">
                                    </picture>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <img src="/images/icon-profile-user.png">
                                        <a href="javascript:void(0)" ng-click="participantsByMoneybox()">Participantes: {{$partiticipantsnumber}}</a>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <label>
                                        <img src="/images/icon-profile-calendar.png" alt="">
                                        Faltan:
                                        <?php
                                            $end_date = \App\Utilities\PLDateTime::toCarbon($moneybox->end_date);
                                            $current_date = \Carbon\Carbon::now();
                                        ?>

                                        @if($current_date->diffInDays($end_date) > 1 || $current_date->diffInDays($end_date) == 0)
                                            {{$current_date->diffInDays($end_date)}} días
                                        @else
                                            {{$current_date->diffInDays($end_date)}} día
                                        @endif
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label>
					                    @foreach($settings as $setting)
                                            @if($setting->setting_id == 2 && $setting->option_id == 6 && $setting->value == 0)
                                                <img src="/images/icon-profile-total.png" alt="">
                                                Total recaudado: ${{number_format($moneybox->collected_amount, 2)}}
                                            @endif
                                        @endforeach
                                    </label>
                                </div>

                                <div class="form-group">
                                    <input type="hidden" ng-init="moneyboxurl='{{$moneybox->url}}'"/>
                                    <button class="btn-primary small" ng-click="goToParticipation()">Participa</button>
                                </div>
                            </form> <!-- /.FormProfile -->
                        </div>

                        <div class="col-sm-7">
                            <div class="form share">
                                <div class="form-group">
                                    <label>Comparte tu alcancía en tus redes sociales</label>
                                </div>

                                <div class="form-group">
                                    <a id="btnShareFb" class="btn-share-fb">
                                        <span style="color: white;">Compartir en</span>
                                        <img src="/images/facebook-logo.png" alt="facebook.com">
                                    </a>
                                </div>
                                <!-- Your share button code -->
                            </div> <!-- ./FormShare -->

                            <div class="form share">
                                <div class="form-group">
                                    <label>Comparte este enlace con tus amigos</label>
                                    <br>
                                    <a href="#" target="_blank" id="moneybox-location">http://coperacha.com.mx/moneybox/detail/{{$moneybox->url}}</a>
                                </div>
                            </div>

                            <form id="FormShare" class="form share"
                                  data-url="{{$moneybox->url}}"
                                  v-on:submit.prevent="onSubmit" role="form">
                                <div v-if="loading" class="loader"></div>
                                <div v-if="message.text!=''" class="alert alert-success" role="alert">@{{message.text}}</div>
                                <div class="form-group">
                                    <label>o envía un correo electrónico a tus amigos para invitarlos a participar.</label>
                                </div>

                                <div class="form-group">
                                    <div class="text-info">Introduce los correos electrónicos separando cada uno con punto y coma (;)</div>
                                    <textarea class="form-control"
                                              rows="4"
                                              name="emails"
                                              v-model="emails"
                                              placeholder="Ej: participante1@coperacha.com.mx;participante2@coperacha.com.mx"></textarea>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="pull-right">
                                        <button id="btnSendInvitation" class="btn btn-primary small">Enviar invitaciones</button>
                                    </div>
                                </div>
                                <input id="created" type="hidden" value="{{$created}}"/>
                            </form> <!-- ./FormShare -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{asset('/js/vendor/vuejs/vue.js')}}"></script>
    <script src="{{asset('/js/vendor/vuejs/vue-resource.js')}}"></script>
    <script src="{{asset('/js/invitation.js')}}"></script>
    <script src="{{asset('/js/share.js')}}"></script>
    <script>
        (function($){
            var Application = {
                init: function () {
                    var utils = new Utils();
                    var btnShareFb = $('#btnShareFb');
                    var id = $("#moneybox-id").val();
                    var title = $("#moneybox-name").val();
                    var caption = $("#moneybox-caption").text();
                    var desc = $("#moneybox-desc").val();
                    var image = $("#moneybox-image").attr('src');
                    var created = $("#created").val();
                    var moneyboxLocation = $("#moneybox-location");
                    moneyboxLocation.attr("href", utils.getLocation());

                    if (created == 1) {
                        document.getElementById('small-alert-content').innerHTML = "" +
                        "<p>¡Gracias por crear tu alcancía!<p>"+
                        "<p>Te invitamos a ser el primero en participar ya que esto ayudará a motivar a tus amigos.<p>";
                        utils.showAlert(true);
                    }


                    if (id > 0 && image.length > 0) {
                        var share = new Share();
                        share.setup({
                            networks: {
                                facebook: {
                                    load_sdk: true,
                                    app_id: "1581295808831173",
                                    title: title,
                                    image: image,
                                    description: desc,
                                    url: location.toString().split('/1')[0],
                                    caption: caption
                                }
                            }
                        });

                        btnShareFb.on("click", function (evt) {
                            evt.preventDefault();
                            share.network_facebook();
                        });
                    }
                }
            };
            Application.init();
        })(jQuery);
    </script>
@endsection

