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
                                <div class="label-owner">Alcancía organizada por: <span>{{$person->name}} {{$person->lastname}}</span></div>
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
                                        <img src="/images/icon-profile-user.png">
                                        Participantes: {{$partiticipantsnumber}}
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
                                        <img src="/images/icon-profile-total.png" alt="">
                                        Total recaudado: ${{number_format($moneybox->collected_amount, 2)}}
                                    </label>
                                </div>
                                <div class="form-group" ng-controller="participantController">
                                    <input type="hidden" ng-init="moneyboxurl='{{$moneybox->url}}'"/>
                                    <button class="btn-primary small" ng-click="goToParticipation()">Participa</button>
                                </div>
                            </form> <!-- ./FormProfile -->
                        </div>
                        <div class="col-sm-7">
                            <div class="form share">
                                <div class="form-group">
                                    <label>Comparte tu alcancía en tus redes sociales</label>
                                </div>
                                <div class="form-group">
                                    <a class="btn-share-fb" href="javascript:void(0)" onclick="share()">
                                        <span>Compartir en</span>
                                        <img src="/images/facebook-logo.png" alt="">
                                    </a>
                                </div>
                                <!--<div class="form-group">
                                    <a class="btn-share-twitter" href="javascript:void(0)">
                                        <span>Compartir en</span>
                                        <img src="/images/twitter-logo.png" alt="">
                                    </a>
                                </div>-->
                                <!-- Your share button code -->
                            </div> <!-- ./FormShare -->
                            <form id="FormShare" class="form share"
                                  data-url="{{$moneybox->url}}"
                                  v-on:submit.prevent="onSubmit" role="form">
                                <div v-if="loading" class="loader"></div>
                                <div v-if="message.text!=''" class="alert alert-success" role="alert">@{{message.text}}</div>
                                <div class="form-group">
                                    <label>O envía correo a tus amigos para invitarlos a participar.</label>
                                </div>
                                <div class="form-group">
                                    <div class="text-info">Introduce los emails separando cada uno con punto y coma (;)</div>
                                    <textarea required
                                              class="form-control"
                                              rows="4"
                                              name="emails"
                                              v-model="emails"
                                              placeholder="Introduce las direcciones de correo"></textarea>
                                </div>
                                <div class="form-group clearfix">
                                    <div class="pull-right">
                                        <button id="btnSendInvitation" class="btn btn-primary small">Enviar invitaciones</button>
                                    </div>
                                </div>
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
@endsection