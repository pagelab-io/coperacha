(function(){

    angular.
        module("ParticipantService", []).
        factory("Participant", Participant);

    Participant.$inject = ['$http'];

    function Participant($http){
        var Participant = {
            /**
             * Url base
             */
            url: '/api/v1/participant',
            create: function(request){
                return $http.post(Participant.url, request);
            }
        };
        return Participant;
    }

})();
