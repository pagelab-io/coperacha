(function(){

    angular.
        module("LoginService", []).
        factory("Login", Login);

    Login.$inject = ['$http'];

    function Login($http){
        var Login = {
            /**
             * Url base
             */
            url: '/api/v1/auth/login',
            login: function(request){
                return $http.post(Login.url, request);
            }
        };
        return Login;
    }

})();
