(function(){

    angular
        .module('CoperachaModalDirective', [])
        .directive('coperachaModal', function () {
            return {
                templateUrl: '/templates/login-popup.html',
                restrict: 'E'
            };
        });

})();