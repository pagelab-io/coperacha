@extends("layouts.master")

@section('css')
    <link rel="stylesheet" href="{{asset("/js/vendor/bootstrap-select-1.11.2/bootstrap-select.css")}}">
@endsection
@section("navigation")
    @include("partials.navigation")
@endsection
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
                                    <label for="accountType">Tipo de cuenta</label>
                                    <select
                                           name="name"
                                           v-model="order.accountType"
                                           v-on:change="onAccountTypeChange"
                                           class="form-control">
                                           <option value="">--Selecciona una opción--</option>
                                           <option value="1">Tarjeta destino</option>
                                           <option value="2">Clabe interbancaria</option>
                                           <option value="3">Celular</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="name">Selecciona tu banco</label>
                                    <select id="bank"
                                            name="bank"
                                            v-model="order.bank_name"
                                            class="form-control">
                                        <option value="">--Selecciona una opción--</option>
                                        <option value="ABC CAPITAL">ABC CAPITAL</option>
                                        <option value="ACCIVAL CB">ACCIVAL CB</option>
                                        <option value="ACTINVER">ACTINVER</option>
                                        <option value="ACTINVER CB">ACTINVER CB</option>
                                        <option value="ACTINVER SOCIED">ACTINVER SOCIED</option>
                                        <option value="AKALA, S.A.">AKALA, S.A.</option>
                                        <option value="AMERICAN EXPRES">AMERICAN EXPRES</option>
                                        <option value="ASEA">ASEA</option>
                                        <option value="ASP INTEGRA OPC">ASP INTEGRA OPC</option>
                                        <option value="AXXA">AXXA</option>
                                        <option value="AZTECA">AZTECA</option>
                                        <option value="B&B">B&B</option>
                                        <option value="BAJIO">BAJIO</option>
                                        <option value="BAMSA">BAMSA</option>
                                        <option value="BANAMEX">BANAMEX</option>
                                        <option value="BANCEN">BANCEN</option>
                                        <option value="BANCO AUTOFIN">BANCO AUTOFIN</option>
                                        <option value="BANCO COMPARTAM">BANCO COMPARTAM</option>
                                        <option value="BANCO FACIL">BANCO FACIL</option>
                                        <option value="BANCO FAMSA">BANCO FAMSA</option>
                                        <option value="BANCO FINTERRA">BANCO FINTERRA</option>
                                        <option value="BANCO MONEX">BANCO MONEX</option>
                                        <option value="BANCOMEXT">BANCOMEXT</option>
                                        <option value="BANCOPPEL">BANCOPPEL</option>
                                        <option value="BANCREA">BANCREA</option>
                                        <option value="BANJERCITO">BANJERCITO</option>
                                        <option value="BANKAOOL">BANKAOOL</option>
                                        <option value="BANOBRAS">BANOBRAS</option>
                                        <option value="BANORTE/IXE">BANORTE/IXE</option>
                                        <option value="BANREGIO">BANREGIO</option>
                                        <option value="BANSEFI">BANSEFI</option>
                                        <option value="BANSI">BANSI</option>
                                        <option value="BANXICO">BANXICO</option>
                                        <option value="BARCLAYS">BARCLAYS</option>
                                        <option value="BASE">BASE</option>
                                        <option value="BBVA BANCOMER">BBVA BANCOMER</option>
                                        <option value="BTG PACTUAL">BTG PACTUAL</option>
                                        <option value="C. BOLSA BANORT">C. BOLSA BANORT</option>
                                        <option value="CAJA POP MEXICA">CAJA POP MEXICA</option>
                                        <option value="CAJA TELEFONIST">CAJA TELEFONIST</option>
                                        <option value="CB BULLTICK">CB BULLTICK</option>
                                        <option value="CHICAGO">CHICAGO</option>
                                        <option value="CIBANCO">CIBANCO</option>
                                        <option value="CLS BANK">CLS BANK</option>
                                        <option value="CONSUBANCO">CONSUBANCO</option>
                                        <option value="CONSULTORIA INT">CONSULTORIA INT</option>
                                        <option value="CREDIT SUISSE">CREDIT SUISSE</option>
                                        <option value="CRISTOBAL COLON">CRISTOBAL COLON</option>
                                        <option value="DEUSTCHE">DEUSTCHE</option>
                                        <option value="DEUSTCHE SECURI">DEUSTCHE SECURI</option>
                                        <option value="DONDE">DONDÉ</option>
                                        <option value="ESTRUCTURADORES">ESTRUCTURADORES</option>
                                        <option value="EUROFIMEX CASA">EUROFIMEX CASA</option>
                                        <option value="EVERCORE">EVERCORE</option>
                                        <option value="FINAMEX">FINAMEX</option>
                                        <option value="FINCOMUN">FINCOMUN</option>
                                        <option value="FIND">FIND</option>
                                        <option value="FOMPED">FOMPED</option>
                                        <option value="FONDO (FIRA)">FONDO (FIRA)</option>
                                        <option value="FORJADORES">FORJADORES</option>
                                        <option value="GBM">GBM</option>
                                        <option value="GE MONEY BANK">GE MONEY BANK</option>
                                        <option value="GNP">GNP</option>
                                        <option value="HDI SEGUROS">HDI SEGUROS</option>
                                        <option value="HSBC">HSBC</option>
                                        <option value="HUASTECAS">HUASTECAS</option>
                                        <option value="ICBC">ICBC</option>
                                        <option value="INBURSA">INBURSA</option>
                                        <option value="INDEVAL">INDEVAL</option>
                                        <option value="INFONAVIT">INFONAVIT</option>
                                        <option value="ING BANK">ING BANK</option>
                                        <option value="INMOBILIARIO">INMOBILIARIO</option>
                                        <option value="INTERACCIONES">INTERACCIONES</option>
                                        <option value="INTERCAM">INTERCAM</option>
                                        <option value="INTERCAM BANCO">INTERCAM BANCO</option>
                                        <option value="INVERCAP">INVERCAP</option>
                                        <option value="INVESTA BANK">INVESTA BANK</option>
                                        <option value="INVEX">INVEX</option>
                                        <option value="JP MORGAN CASA">JP MORGAN CASA</option>
                                        <option value="JPMORGAN">JPMORGAN</option>
                                        <option value="KUSPIT">KUSPIT</option>
                                        <option value="LIBERTAD">LIBERTAD</option>
                                        <option value="MAPFRE TEPEYAC">MAPFRE TEPEYAC</option>
                                        <option value="MASARI">MASARI</option>
                                        <option value="MERRIL LYNCH CB">MERRIL LYNCH CB</option>
                                        <option value="MIFEL">MIFEL</option>
                                        <option value="MONEXCB">MONEXCB</option>
                                        <option value="MULTIVA BANCO">MULTIVA BANCO</option>
                                        <option value="MULTIVA CBOLSA">MULTIVA CBOLSA</option>
                                        <option value="NAFIN">NAFIN</option>
                                        <option value="ORDER">ORDER</option>
                                        <option value="OSKNDIA">OSKNDIA</option>
                                        <option value="PAGATODO">PAGATODO</option>
                                        <option value="PERSEVERANCIA">PERSEVERANCIA</option>
                                        <option value="PRINCIPAL">PRINCIPAL</option>
                                        <option value="PROFUTURO GNP">PROFUTURO GNP</option>
                                        <option value="RECURSOS REFORM">RECURSOS REFORM</option>
                                        <option value="REPUBLICNY">REPUBLICNY</option>
                                        <option value="SABADELL">SABADELL</option>
                                        <option value="SANTANDER">SANTANDER</option>
                                        <option value="SCOTIABANK">SCOTIABANK</option>
                                        <option value="SEGUROS MTY.">SEGUROS MTY.</option>
                                        <option value="SKANDIA VIDA">SKANDIA VIDA</option>
                                        <option value="SOC HIPOTECARIA">SOC HIPOTECARIA</option>
                                        <option value="SOFIEXPRESS">SOFIEXPRESS</option>
                                        <option value="STP">STP</option>
                                        <option value="SURA">SURA</option>
                                        <option value="TAMIBE">TAMIBE</option>
                                        <option value="TOKIO">TOKIO</option>
                                        <option value="USB BANK MEXICO">USB BANK MEXICO</option>
                                        <option value="UNAGRA">UNAGRA</option>
                                        <option value="VALORES MEXICAN">VALORES MEXICAN</option>
                                        <option value="VALUE">VALUE</option>
                                        <option value="VANGUARDIA">VANGUARDIA</option>
                                        <option value="VE POR MAS">VE POR MAS</option>
                                        <option value="VECTOR CB">VECTOR CB</option>
                                        <option value="VOLKSWAGEN BANK">VOLKSWAGEN BANK</option>
                                        <option value="ZURICH">ZURICH</option>
                                        <option value="ZURICH VIDA">ZURICH VIDA</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="email">Correo electrónico</label>
                                    <input id="email"
                                           name="email"
                                           v-model="order.email"
                                           type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           placeholder="Correo electrónico">
                                </div>
                            </div>
                            <div class="col-sm-6">

                                <div class="form-group">
                                    <label for="name">Nombre del beneficiario</label>
                                    <input id="name"
                                           v-model="order.name"
                                           name="name" type="text"
                                           class="form-control"
                                           autocomplete="off"
                                           placeholder="Nombre del beneficiario">
                                </div>

                                <div class="form-group request-account-type" id="type1">
                                    <label for="cardNumber">Número de tarjeta destino</label>
                                    <input id="account"
                                           name="account"
                                           v-model="order.account"
                                           autocomplete="off"
                                           type="text" class="form-control" placeholder="Número de tarjeta destino">
                                </div>

                                <div class="form-group request-account-type" id="type2">
                                    <label for="clabe">Número de clabe</label>
                                    <input id="clabe"
                                           name="clabe"
                                           v-model="order.clabe"
                                           autocomplete="off"
                                           type="text" class="form-control" placeholder="Número de clabe">
                                </div>

                                <div class="form-group request-account-type" id="type3">
                                    <label for="mobile">Número celular</label>
                                    <div class="input-group">
                                        <div class="input-group-addon" style="padding: 0;">
                                            <select class="selectpicker"
                                                    data-width="160px"
                                                    v-model="order.areacode"
                                                    data-live-search="true">
                                                <option value="">Código de area</option>
                                                @foreach($codes as $code)
                                                    <option value="{{$code['code']}}">{!! $code['name'] .' - <strong>('. $code['code'] . ')</strong>' !!}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <input type="text" class="form-control" v-model="order.cellphone" placeholder="Número celular">
                                    </div>
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
    <script src="{{asset("/js/vendor/bootstrap-3.3.7/js/bootstrap.js")}}"></script>
    <script src="{{asset("/js/vendor/bootstrap-select-1.11.2/bootstrap-select.js")}}"></script>
    <script>
        $(document).ready(function () {
            $('.selectpicker').selectpicker({ liveSearch: true });
        });
    </script>
@endsection