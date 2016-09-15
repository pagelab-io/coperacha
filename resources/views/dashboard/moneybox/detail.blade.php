@extends("dashboard.layouts.app")

@section("content")
    <!-- Title and description-->
    <div class="dashboard-titles">
        <h2>Nombre de la alcancía: {{$moneybox->name}}</h2>
        <p>descripción: {{$moneybox->description}}</p>
    </div>
    <section class="dashboard row">
        Información
    </section>
@stop