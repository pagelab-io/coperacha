(function(){

    angular
        .module('LoginModalController', [])
        .controller('loginModalController', modalController);

    modalController.$inject = ['$scope'];

    function modalController($scope)
    {

        $scope.modalvisible  = false;

        $scope.showModal = function(){
            console.log("show");
            $scope.modalvisible = true;
        };

        $scope.hideModal = function(){
            console.log("hide");
            $scope.modalvisible = false;
        };

    }

})();