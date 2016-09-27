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

            create: function (request)
            {
                return $http.post(Moneybox.url, request);
            },

            update: function (request)
            {
                return $http.put(Moneybox.url, request);
            },

            upload: function (form)
            {
                return $http.post(Moneybox.url + '/upload', form, {
                    transformRequest: angular.identity,
                    headers: {'Content-Type': undefined}
                });
            }

        };
        return Moneybox;
    }

})();
