(function(){

    angular
        .module('ModalController', [])
        .controller('modalController', modalController);

    modalController.$inject = ['$scope'];

    function modalController($scope)
    {
        document.addEventListener('keyup', function(e){
            if (e.keyCode === 27) {
                if(document.getElementById('alert-modal-coperacha').style.display == 'none'){
                    $scope.hideModal();
                }
            }
        });
    }
})();