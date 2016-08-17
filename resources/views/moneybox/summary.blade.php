@extends("layouts.master")

@section("content")

    @include('partials.header')

    <section class="block request-view">
        <div class="holder">
            <div class="container-fluid">

                <div class="header-block">
                    <div class="title">
                    </div>
                </div>

                <div class="content-block">
                    <form action="#" class="form">
                        <div class="form-group">
                            <p class="text-info">Verifica por favor que los datos sean correctos</p>
                        </div>


                        <div class="form-group clearfix">
                            <div class="pull-right">
                                <button class="btn btn-primary small">REALIZAR PAGO</button>
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