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
                                           class="form-control"
                                           autocomplete="off"
                                           placeholder="Nombre del titular de la cuenta">
                                </div>

                                <div class="form-group">
                                    <label for="name">Selecciona tu banco</label>
                                    <select id="bank"
                                            name="bank"
                                            v-model="order.bank_name"
                                            class="form-control">
                                        <option value="">--Selecciona una opción--</option>
                                        <option value="abc_capital">ABC CAPITAL</option>
                                        <option value="accival_cb">ACCIVAL CB</option>
                                        <option value="actinver">ACTINVER</option>
                                        <option value="actinver_cb">ACTINVER CB</option>
                                        <option value="actinver_socied">ACTINVER SOCIED</option>
                                        <option value="akala_sa">AKALA, S.A.</option>
                                        <option value="american_expres">AMERICAN EXPRES</option>
                                        <option value="asea">ASEA</option>
                                        <option value="asp_integra_opc">ASP INTEGRA OPC</option>
                                        <option value="axxa">AXXA</option>
                                        <option value="azteca">AZTECA</option>
                                        <option value="b_b">B&B</option>
                                        <option value="bajio">BAJIO</option>
                                        <option value="bamsa">BAMSA</option>
                                        <option value="banamex">BANAMEX</option>
                                        <option value="bancen">BANCEN</option>
                                        <option value="banco_autofin">BANCO AUTOFIN</option>
                                        <option value="banco_compartam">BANCO COMPARTAM</option>
                                        <option value="banco_facil">BANCO FACIL</option>
                                        <option value="banco_famsa">BANCO FAMSA</option>
                                        <option value="banco_finterra">BANCO FINTERRA</option>
                                        <option value="banco_monex">BANCO MONEX</option>
                                        <option value="banco_bancomext">BANCOMEXT</option>
                                        <option value="bancoppel">BANCOPPEL</option>
                                        <option value="bancrea">BANCREA</option>
                                        <option value="banjercito">BANJERCITO</option>
                                        <option value="bankaool">BANKAOOL</option>
                                        <option value="banobras">BANOBRAS</option>
                                        <option value="banorte_ixe">BANORTE/IXE</option>
                                        <option value="banregio">BANREGIO</option>
                                        <option value="bansefi">BANSEFI</option>
                                        <option value="bansi">BANSI</option>
                                        <option value="banxico">BANXICO</option>
                                        <option value="barclays">BARCLAYS</option>
                                        <option value="base">BASE</option>
                                        <option value="bbva_bancomer">BBVA BANCOMER</option>
                                        <option value="btg_pactual">BTG PACTUAL</option>
                                        <option value="c_bolsa_banort">C. BOLSA BANORT</option>
                                        <option value="baja_pop_mexica">CAJA POP MEXICA</option>
                                        <option value="caja_telefonist">CAJA TELEFONIST</option>
                                        <option value="cb_bulltick">CB BULLTICK</option>
                                        <option value="chicago">CHICAGO</option>
                                        <option value="cibano">CIBANCO</option>
                                        <option value="cls_bank">CLS BANK</option>
                                        <option value="consubanco">CONSUBANCO</option>
                                        <option value="consultoria_int">CONSULTORIA INT</option>
                                        <option value="credit_suisse">CREDIT SUISSE</option>
                                        <option value="cristobal_colon">CRISTOBAL COLON</option>
                                        <option value="deustche">DEUSTCHE</option>
                                        <option value="deustche_securi">DEUSTCHE SECURI</option>
                                        <option value="donde">DONDÉ</option>
                                        <option value="estructuradores">ESTRUCTURADORES</option>
                                        <option value="eurofimex_casa">EUROFIMEX CASA</option>
                                        <option value="evercore">EVERCORE</option>
                                        <option value="finamex">FINAMEX</option>
                                        <option value="fincomun">FINCOMUN</option>
                                        <option value="find">FIND</option>
                                        <option value="fomped">FOMPED</option>
                                        <option value="fondo_fira">FONDO (FIRA)</option>
                                        <option value="forjadores">FORJADORES</option>
                                        <option value="gbm">GBM</option>
                                        <option value="ge_money_bank">GE MONEY BANK</option>
                                        <option value="gnp">GNP</option>
                                        <option value="hdi_seguros">HDI SEGUROS</option>
                                        <option value="hsbc">HSBC</option>
                                        <option value="huastecas">HUASTECAS</option>
                                        <option value="icbc">ICBC</option>
                                        <option value="inbursa">INBURSA</option>
                                        <option value="indeval">INDEVAL</option>
                                        <option value="infonavit">INFONAVIT</option>
                                        <option value="ing_bank">ING BANK</option>
                                        <option value="inmobiliario">INMOBILIARIO</option>
                                        <option value="interacciones">INTERACCIONES</option>
                                        <option value="intercam">INTERCAM</option>
                                        <option value="intercam_banco">INTERCAM BANCO</option>
                                        <option value="invercap">INVERCAP</option>
                                        <option value="investa_bank">INVESTA BANK</option>
                                        <option value="invex">INVEX</option>
                                        <option value="jp_morgan_casa">JP MORGAN CASA</option>
                                        <option value="jpmorgan">JPMORGAN</option>
                                        <option value="kuspit">KUSPIT</option>
                                        <option value="libertad">LIBERTAD</option>
                                        <option value="mapfre_tepeyac">MAPFRE TEPEYAC</option>
                                        <option value="masari">MASARI</option>
                                        <option value="merril_lynch_cb">MERRIL LYNCH CB</option>
                                        <option value="mifel">MIFEL</option>
                                        <option value="monexcb">MONEXCB</option>
                                        <option value="multiva_banco">MULTIVA BANCO</option>
                                        <option value="multiva_cbolsa">MULTIVA CBOLSA</option>
                                        <option value="nafin">NAFIN</option>
                                        <option value="order">ORDER</option>
                                        <option value="oskandia">OSKNDIA</option>
                                        <option value="pagatodo">PAGATODO</option>
                                        <option value="perseverancia">PERSEVERANCIA</option>
                                        <option value="principal">PRINCIPAL</option>
                                        <option value="profundo_gnp">PROFUTURO GNP</option>
                                        <option value="recursos_reform">RECURSOS REFORM</option>
                                        <option value="republicny">REPUBLICNY</option>
                                        <option value="sabadell">SABADELL</option>
                                        <option value="santander">SANTANDER</option>
                                        <option value="scotiabank">SCOTIABANK</option>
                                        <option value="seguros_mty">SEGUROS MTY.</option>
                                        <option value="skandia_vida">SKANDIA VIDA</option>
                                        <option value="soc_hipotecaria">SOC HIPOTECARIA</option>
                                        <option value="sofiexpress">SOFIEXPRESS</option>
                                        <option value="stp">STP</option>
                                        <option value="sura">SURA</option>
                                        <option value="tamibe">TAMIBE</option>
                                        <option value="tokio">TOKIO</option>
                                        <option value="usb_bank_mexico">USB BANK MEXICO</option>
                                        <option value="unagra">UNAGRA</option>
                                        <option value="valores_mexican">VALORES MEXICAN</option>
                                        <option value="value">VALUE</option>
                                        <option value="vanguardia">VANGUARDIA</option>
                                        <option value="ve_por_mas">VE POR MAS</option>
                                        <option value="vector_cb">VECTOR CB</option>
                                        <option value="volkswagen_bank">VOLKSWAGEN BANK</option>
                                        <option value="zurich">ZURICH</option>
                                        <option value="zurich_vida">ZURICH VIDA</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="comments">Comentarios</label>
                                    <textarea id="comments"
                                              name="comments"
                                              v-model="order.comments"
                                              class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                </div>
                                <!--<div class="form-group">
                                    <label for="address">Dirección del banco</label>
                                    <textarea id="address"
                                              name="address"
                                              v-model="order.bank_address"
                                              required
                                              class="form-control" rows="3" placeholder="Dirección del banco"></textarea>
                                </div>-->

                                <!--<div class="form-group">
                                    <span for="file">Adjuntar copia de su información bancaria para confirmar los datos</span>
                                    <input id="file"
                                           name="file[]"
                                           type="file"
                                           v-on:change="onFileChange">
                                </div>-->
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="clabe">Clabe interbancaria</label>
                                    <input id="clabe"
                                           name="clabe"
                                           v-model="order.clabe"
                                           autocomplete="off"
                                           type="text" class="form-control" placeholder="Clabe interbancaria">
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

                                <!--<div class="form-group">
                                    <label for="comments">Comentarios</label>
                                    <textarea id="comments"
                                              name="comments"
                                              v-model="order.comments"
                                              class="form-control" rows="3" placeholder="Comentarios"></textarea>
                                </div>-->
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