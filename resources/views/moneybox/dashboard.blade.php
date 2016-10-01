@extends("layouts.content")

@section("page-content")
    <div id="divLoading" class="loader hidden"></div>
    <section class="block my-moneybox-view">
        <div class="holder">
            <div class="container-fluid">
                <div class="content-block">
                    @include('partials/moneybox-list', [
                        'withMessage' => true,
                        'title' => 'Creadas por mi',
                        'moneyboxes' => $moneyboxes['my_moneyboxes']
                    ])
                    @include('partials/moneybox-list', [
                        'withMessage' => false,
                        'title' => 'Alcancías en las que participo',
                        'moneyboxes' => $moneyboxes['moneyboxes_participation']
                    ])
                </div>
            </div>
        </div>
    </section>
@endsection

@section("js")
    <script src="{{asset('/js/vendor/vuejs/vue.js')}}"></script>
    <script src="{{asset('/js/vendor/vuejs/vue-resource.js')}}"></script>
    <script src="{{asset('/js/moneybox.js')}}"></script>
@endsection