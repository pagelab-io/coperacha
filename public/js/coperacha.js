(function(){

    angular
        .module('coperachaApp',
        [
            'ModalController',
            'RegisterController',
            'LoginController',
            'MoneyboxController',
            'RegisterService',
            'LoginService',
            'MoneyboxService',
            'CoperachaModalDirective'
        ]);

})();