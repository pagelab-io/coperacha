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
            url: '/api/v1/moneybox',

            /**
             * Url base for sessions
             */
            urlSession: '/moneybox',

            create: function (request)
            {
                return $http.post(Moneybox.url, request);
            },

            update: function (request)
            {
                return $http.put(Moneybox.url, request);
            },

            getCategories: function(){
                return $http.get(Moneybox.url+"/categories?api-key=$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC");
            },

            step1: function(request){
                return $http.post(Moneybox.urlSession+"/createSession", request);
            },

            step2: function(){
                return $http.post(Moneybox.urlSession+"/deleteSession", null);
            }
        };
        return Moneybox;
    }

})();
