<section class="moneybox-list">
    <h3 class="moneybox-title">{{$title}}</h3>
    <div class="row clearfix">
        @if(count($moneyboxes) > 0)
            @foreach($moneyboxes as $i => $moneybox)
                <div class="col-xs-6 col-sm-4">
                    <article class="moneybox-item">
                        <header>
                            <picture>
                                <img class="img-responsive"
                                     style="height: 70px; width: auto"
                                     src="{{$moneybox->lastfile ? url('/moneybox/image/' . $moneybox->lastfile->name) : url($moneybox->category->path)}}">
                            </picture>
                        </header>
                        <main class="actions">
                            <h2 class="title">{{$moneybox->name}}</h2>
                            <div class="form-group">
                                @if (Auth::user()->person->id == $moneybox->person_id)
                                    <a class="btn btn-primary"
                                        href={{url('/moneybox/create/'.$moneybox->url)}}>Modificar</a>
                                @endif
                            </div>
                            <div class="form-group">
                                @if (Auth::user()->person->id == $moneybox->person_id)
                                    @if($moneybox->collected_amount > 0)
                                        <a class="btn btn-primary"
                                           href="{{url('moneybox/request/'.$moneybox->url)}}">Utilizar
                                            dinero</a>
                                    @else
                                        <a class="btn btn-primary disabled"
                                           href="{{url('moneybox/request/'.$moneybox->url)}}">Utilizar
                                            dinero</a>
                                    @endif
                                @endif
                            </div>
                            <div class="form-group">
                                <a class="btn btn-primary"
                                   href="{{url('/moneybox/detail/'.$moneybox->url)}}">Invitar/Participar</a>
                            </div>
                        </main>
                        <footer>
                            <?php
                            $end_date = \App\Utilities\PLDateTime::toCarbon($moneybox->end_date);
                            $current_date = \Carbon\Carbon::now();
                            ?>
                            <div>Faltan: <span>{{$current_date->diffInDays($end_date)}} días</span>
                            </div>
                            <div>Participantes: <span>{{count($moneybox->participants)}}</span>
                            </div>
                            <div>Recolectado:
                                <span>$ {{number_format($moneybox->collected_amount,2)}}</span>
                            </div>
                        </footer>
                    </article>
                </div>
            @endforeach
        @else
            @if ($withMessage == true)
                <div style="text-align: center; height: 400px;">
                    <h3 style="color:#51B7CD">No has creado ninguna alcancía, puedes empezar <a
                                href="{{route('moneybox.create')}}" style="color:#FF5000">aquí!</a>
                    </h3>
                </div>
            @endif
        @endif
    </div>
</section>