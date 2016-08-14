@extends("layouts.content")

@section("page-content")
    <section class="block my-moneybox-view">
        <div class="holder">
            <div class="container-fluid">
                <div class="content-block">

                    <div class="row moneybox-list clearfix">
                        @for($i = 0; $i<8; $i++)
                            <div class="col-sm-4 moneybox-item">
                                <header>
                                    <img class="img-responsive" src="/images/icon-mbox-{{$i%2==0?'1':'2'}}.png" alt="">
                                </header>
                                <main class="actions">
                                    <h2 class="title">Prueba</h2>
                                    <div class="form-group">
                                        <a class="btn btn-primary">Modificar</a>
                                    </div>
                                    <div class="form-group">
                                        <a class="btn btn-primary">Utilizar dinero</a>
                                    </div>
                                    <div class="form-group">
                                        <a class="btn btn-primary">Invitar</a>
                                    </div>
                                </main>
                                <footer>
                                    <div>Faltan: <span>22 días</span></div>
                                    <div>Participantes: <span>1</span></div>
                                    <div>Recolectado: <span>$ 50.00</span></div>
                                </footer>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

@endsection