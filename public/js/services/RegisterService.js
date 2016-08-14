(function(){

    angular.
        module("RegisterService", []).
        factory("Register", Register);

    Register.$inject = ['$http'];

    function Register($http){
        var Register = {
            /**
             * Url base
             */
            url: '/api/v1/register',
            register: function(request){
                return $http.post(Register.url, request);
            }
        };
        return Register;
    }

})();
