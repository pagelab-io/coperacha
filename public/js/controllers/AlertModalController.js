(function(){

    angular
        .module('AlertModalController', [])
        .controller('alertModalController', modalController);

    modalController.$inject = ['$scope','$timeout'];

    function modalController($scope, $timeout)
    {

        $scope.modalvisible  = false;
        $scope.title         = "Atención";
        $scope.content       = '';

        $scope.showAlert = function(){
            $scope.modalvisible = true;
        };

        $scope.hideAlert = function (){
            $scope.modalvisible = false;
        };

        $scope.trigger = function(){
            $scope.modalvisible = !$scope.modalvisible;
        }
    }

})();