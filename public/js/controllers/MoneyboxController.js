(function(){

    angular
        .module("MoneyboxController", [])
        .controller('moneyboxController', moneyboxController);

    moneyboxController.$inject = ['$scope', 'Moneybox'];

    function moneyboxController($scope, Moneybox)
    {
        $scope.utils = new Utils();
        $scope.request = {};
    }

})();