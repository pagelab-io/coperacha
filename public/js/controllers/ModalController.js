(function(){

    angular
        .module('ModalController', [])
        .controller('modalController', modalController);

    modalController.$inject = ['$scope'];

    function modalController($scope)
    {

        $scope.popup = document.getElementsByClassName('popup-wrapper')[0];

        /**
         * Show modal
         */
        $scope.showModal = function()
        {
            if($scope.popup != null){
                $scope.popup.style.display = "block";
                $scope.addEvents();
            }
        };

        /**
         * Hide modal
         */
        $scope.hideModal = function()
        {
            if($scope.popup != null)
                $scope.popup.style.display = "none";
        };

        /**
         * attach the events for modal
         */
        $scope.addEvents = function()
        {
            document.addEventListener('keyup', function(e){
                if(e.keyCode === 27){
                    $scope.hideModal();
                }
            });

            var closeButton = document.getElementsByClassName('close-popup')[0];
            closeButton.addEventListener('click', function(){
                $scope.hideModal();
            });
        };

    }

})();