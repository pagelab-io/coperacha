@extends("layouts.content")

@section("page-content")
    <section class="block my-moneybox-view">
        <div class="holder">
            <div class="container-fluid">
                <div class="content-block">
                    <div class="row moneybox-list clearfix">
                        @if(count($moneyboxes['my_moneyboxes']) > 0)
                            @foreach($moneyboxes['my_moneyboxes'] as $i => $moneybox)
                                <div class="col-xs-6 col-sm-4 moneybox-item">
                                    <header>
                                        <picture>
                                            <img class="img-responsive"
                                                 width="90px"
                                                 height="70px"
                                                 src="{{$moneybox->image ? url('/moneybox/image/' . $moneybox->image) : '/images/icon-mbox-1.png'}}">
                                        </picture>
                                    </header>
                                    <main class="actions">
                                        <h2 class="title">{{$moneybox->name}}</h2>
                                        <div class="form-group">
                                            <a class="btn btn-primary" href={{url('/moneybox/create/'.$moneybox->url)}}>Modificar</a>
                                        </div>
                                        <div class="form-group">
                                            <a class="btn btn-primary" href="{{url('moneybox/request/'.$moneybox->url)}}">Utilizar dinero</a>
                                        </div>
                                        <div class="form-group">
                                            <a class="btn btn-primary" href="{{url('/moneybox/detail/'.$moneybox->url)}}">Invitar/Participar</a>
                                        </div>
                                    </main>
                                    <footer>
                                        <?php
                                        $end_date = \App\Utilities\PLDateTime::toCarbon($moneybox->end_date);
                                        $current_date = \Carbon\Carbon::now();
                                        ?>
                                        <div>Faltan: <span>{{$current_date->diffInDays($end_date)}} días</span></div>
                                        <div>Participantes: <span>{{count($moneybox->participants)}}</span></div>
                                        <div>Recolectado: <span>$ {{number_format($moneybox->collected_amount,2)}}</span></div>
                                    </footer>
                                </div>
                            @endforeach
                        @else
                            <div style="text-align: center; height: 400px;">
                                <h3 style="color:#51B7CD">No has creado ninguna alcancía, puedes empezar <a href="{{route('moneybox.create')}}" style="color:#FF5000">aqui !</a></h3>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')

@endsection