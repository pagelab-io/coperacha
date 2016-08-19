(function(){

    angular.
        module("MoneyboxService", []).
        factory("Moneybox", Moneybox);

    Moneybox.$inject = ['$http'];

    function Moneybox($http){
        var Moneybox = {

            /**
             * Url base
             */
            url: 'api/v1/moneybox',

            /**
             * Url base for sessions
             */
            urlSession: '/moneybox',

            create: function(request){
                return $http.post(Moneybox.url, request);
            },

            createSession: function(request){
                return $http.post(Moneybox.urlSession+"/createSession", request);
            },

            getSession: function(request){
                return $http.post(Moneybox.urlSession+"/getSession", request);
            },

            deleteSession: function(request){
                return $http.post(Moneybox.urlSession+"/deleteSession", request);
            }
        };
        return Moneybox;
    }

})();
