@extends("layouts.master")

@section("content")
    @include('partials.header')
    <section id="RequestMoneyView" class="block request-view"
             data-moneybox_id="{{$moneybox->id}}"
             data-user_id="{{$moneybox->person->user->id}}">
        <div class="holder">
            <div class="container-fluid">
                <div class="header-block">
                    <div class="title">
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="/images/moneybox-request.png" alt="moneybox-request">
                            </div>
                            <div class="col-sm-9">
                                <h2>
                                    <div>¡Felicidades!</div>
                                    <div>Ya se recaudó el dinero para tu alcancía <strong>"{{$moneybox->name}}"</strong></div>
                                    <div>por un monto de $ {{$moneybox->collected_amount}}</div>
                                </h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="content-block">
                    <form id="RequestForm"
                          v-on:submit.prevent="onSubmit"
                          method="post"
                          enctype="multipart/form-data"
                          class="form request-form">

                        <div v-if="loading" class="loader"></div>
                        <div v-if="message.text!==''" class="alert alert-success" role="alert">@{{message.text}}</div>

                        <div class="form-group">
                            <p class="text-info">Llena por favor los siguientes datos:</p>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="name">Nombre del titular de la cuenta</label>
                                    <input id="name"
                                           v-model="order.name"
                                           name="name" type="text"
                                           required
                                           class="form-control"
                                           autocomplete="off"
                                           placeholder="Nombre del titular de la cuenta">
                                </div>

                                <div class="form-group">
                                    <label for="name">Selecciona tu banco</label>
                                    <select id="bank"
                                            name="bank"
                                            required
                                            v-model="order.bank_name"
                                            class="form-control">
                                        <option value="banorte">Banorte</option>
                                        <option value="bancomer">Bancomer</option>
                                        <option value="hsbs">HSBC</option>
                                        <option value="banamex">Banamex</option>
                                        <option value="santander">Santander</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="address">Dirección del banco</label>
                                    <textarea id="address"
                                              name="address"
                                              v-model="order.bank_address"
                                              required
                                              class="form-control" rows="3" placeholder="Dirección del banco"></textarea>
                                </div>

                                <div class="form-group">
                                    <span for="file">Adjuntar copia de su información bancaria para confirmar los datos</span>
                                    <input id="file"
                                           name="file[]"
                                           type="file"
                                           v-on:change="onFileChange">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="clabe">Clabe Interbancaria</label>
                                    <input id="clabe"
                                           name="clabe"
                                           v-model="order.clabe"
                                           autocomplete="off"
                                           type="text" class="form-control" placeholder="Clabe Interbancaria">
                                </div>

                                <div class="form-group">
                                    <label for="account">Número de cuenta</label>
                                    <input id="account"
                                           name="account"
                                           v-model="order.account"
                                           type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           placeholder="Número de cuenta">
                                </div>

                                <div class="form-group">
                                    <label for="comments">Comentarios</label>
                                    <textarea id="comments"
                                              name="comments"
                                              v-model="order.comments"
                                              class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small">Aceptar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="{{asset('/js/vendor/vuejs/vue.js')}}"></script>
    <script src="{{asset('/js/vendor/vuejs/vue-resource.js')}}"></script>
    <script src="{{asset('/js/request.js')}}"></script>
@endsection