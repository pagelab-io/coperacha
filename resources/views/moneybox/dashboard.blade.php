@extends("layouts.content")

@section("page-content")
    <div id="divLoading" class="loader hidden"></div>
    <section class="block my-moneybox-view">
        <div class="holder">
            <div class="container-fluid" ng-controller="moneyboxController">
                <div class="header-block">
                    <div class="stage-element">
                        <a class="stage-item profile selected" ng-click="tabMoneyboxes()" id="tabMyMoneyboxes">
                            <div class="stage-item-icon"></div>
                            <div class="stage-item-label">Creadas por mi</div>
                            <div class="stage-bar"></div>
                        </a>
                        <a class="stage-item" ng-click="tabMoneyboxes()" id="tabMoneyboxParticipation">
                            <div class="stage-item-icon"></div>
                            <div class="stage-item-label">Participación</div>
                        </a>
                    </div>
                </div>
                <div class="content-block" id="my-moneyboxes">
                    @include('partials/moneybox-list', [
                        'withMessage' => true,
                        'title' => 'Creadas por mi',
                        'moneyboxes' => $moneyboxes['my_moneyboxes']
                    ])
                </div>
                <div class="content-block" id="moneybox-participation" style="display:none">
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