(function(){

    angular
        .module('coperachaApp',
        [
            'ModalController',
            'RegisterController',
            'LoginController',
            'MoneyboxController',
            'ParticipantController',
            'RegisterService',
            'LoginService',
            'MoneyboxService',
            'ParticipantService',
            'CoperachaModalDirective'
        ]);

})();