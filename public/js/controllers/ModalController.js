(function(){

    angular
        .module('ModalController', [])
        .controller('modalController', modalController);

    modalController.$inject = ['$scope'];

    function modalController($scope)
    {

        /**
         * show modal
         */
        $scope.showModal = function()
        {
            var popup = document.getElementsByClassName('popup-wrapper');
            $(popup).css({display:'block'});
        }
    }

})();