@extends("layouts.content")

@section("page-content")
    <section class="block" id="pricing">
        <div class="holder">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <img class="img-responsive" src="{{asset('/images/pricing-1.png')}}" alt="pricing">
                    </div>
                    <div class="col-sm-6">
                        <div class="header-block">
                            <h2 class="title">Transparente y sin comisiones ocultas</h2>
                        </div>
                        <div class="content-block">
                            <ul>
                                <li>Haz una alcancía de manera totalmente gratuita</li>
                                <li>Sin comisiones para los participantes</li>
                                <li>Completamente gratuito si utilizas el bote en uno de nuestros partners</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="block" id="stages">
        <div class="holder">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="header-block">
                            <div class="title">Fácil y rápido</div>
                        </div>
                        <div class="content-block">
                            <div class="text-center">
                                <img style="display: inline-block;" class="img-responsive" src="{{asset('/images/pricing-2.png')}}" alt="pricing">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection