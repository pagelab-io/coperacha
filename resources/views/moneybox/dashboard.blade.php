@extends("layouts.content")

@section("page-content")
    <section class="block my-moneybox-view">
        <div class="holder">
            <div class="container-fluid">
                <div class="content-block">
                    @include('partials/moneybox-list', [
                        'title' => 'Creadas por mi',
                        'moneyboxes' => $moneyboxes['my_moneyboxes']
                    ])
                    @include('partials/moneybox-list', [
                        'title' => 'Alcancías en las que participo',
                        'moneyboxes' => $moneyboxes['moneyboxes_participation']
                    ])
                </div>
            </div>
        </div>
    </section>
@endsection