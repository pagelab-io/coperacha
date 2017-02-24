<section class="moneybox-list" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <h3 class="moneybox-title">{{$title}}</h3>
    <div class="row clearfix">
        @if(count($moneyboxes) > 0)
            @foreach($moneyboxes as $i => $moneybox)
                <?php
                    // Data transforms
                    $end_date = \App\Utilities\PLDateTime::toCarbon($moneybox->end_date);
                    $current_date = \Carbon\Carbon::now();
                ?>
                <div class="col-xs-6 col-sm-4">
                    <article class="moneybox-item" title="{{$moneybox->id}}">
                        <header>
                            <picture>
                                <img class="img-responsive"
                                     style="height: 70px; width: auto"
                                     src="{{$moneybox->lastfile ? url('/moneybox/image/' . $moneybox->lastfile->name) : url($moneybox->category->path)}}">
                            </picture>
                        </header>
                        <main class="actions">
                            <h2 class="title">
                                <a href="{{url('/moneybox/detail/'.$moneybox->url)}}">{{$moneybox->name}}</a>
                            </h2>
                            @if (Auth::user()->person->id == $moneybox->person_id)
                                @if (Carbon\Carbon::now() >= $moneybox->end_date)
                                    <div class="form-group">
                                        <a data-url="{{$moneybox->url}}"
                                           class="btn btn-primary btn-thanks"
                                           title = "Enviar correo de agradecimiento.">Agradecimiento</a>
                                    </div>
                                @endif
                            @endif

                            @if (Auth::user()->person->id == $moneybox->person_id)
                                <div class="form-group">
                                    <a class="btn btn-primary {{($moneybox->orders > 0) ? 'disabled' : 'enabled'}}"
                                       title = "Modificar datos de la alcancía"
                                       href={{url('/moneybox/create/'.$moneybox->url)}}>Modificar</a>
                                </div>
                            @endif

                            <div class="form-group">
                                @if (Auth::user()->person->id == $moneybox->person_id)
                                    <a class="btn btn-primary {{$moneybox->collected_amount > 0 ? 'enabled' : 'disabled'}} {{($moneybox->orders > 0) ? 'disabled' : 'enabled'}}""
                                       title = "Enviar correo para solicitar dinero."
                                       href="{{url('moneybox/request/'.$moneybox->url)}}">Utilizar dinero</a>
                                @endif
                            </div>

                            <div class="form-group">
                                @if ($current_date <= $end_date)
                                    <a class="btn btn-primary {{($moneybox->orders > 0) ? 'disabled' : 'enabled'}}"
                                       title = "Enviar correo a conocidos para participar"
                                       href="{{url('/moneybox/detail/'.$moneybox->url)}}">Invitar/Participar</a>
                                @endif
                            </div>

                            @if (Auth::user()->person->id == $moneybox->person_id)
                                @if ($moneybox->collected_amount == 0)
                                    <div class="form-group">
                                        <a data-url="{{$moneybox->url}}"
                                           data-name="{{$moneybox->name}}"
                                           class="btn btn-danger btn-remove"
                                           title = "Eliminar alcancía">Eliminar alcancía</a>
                                    </div>
                                @endif
                            @endif
                        </main>
                        <footer>
                            @if($current_date <= $end_date)
                                <div>
                                    Faltan: <span>{{$current_date->diffInDays($end_date)}} días</span>
                                </div>
                            @else
                                <div>
                                    Status:<span><strong> Fecha finalizada </strong></span>
                                </div>
                            @endif
                            <div>
                                Participantes: <span>{{$moneybox->participant_number}}</span>
                            </div>
                            <div>
                                Recolectado:
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