(function(){

    angular
        .module("ParticipantController", [])
        .controller('participantController', participantController);

    participantController.$inject = ['$scope', 'Participant'];

    function participantController($scope, Participant)
    {
        $scope.utils = new Utils();
        $scope.request = {};

        $scope.goToParticipation = function()
        {
            window.location = "/moneybox/join";
        }

    }

})();