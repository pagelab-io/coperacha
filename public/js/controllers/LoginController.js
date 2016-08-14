(function(){

    angular
        .module("LoginController", [])
        .controller('loginController', loginController);

    loginController.$inject = ['$scope', 'Login'];

    function loginController($scope, Login)
    {
        $scope.email = "";
        $scope.password = "";
        $scope.facebook_uid = "";
        $scope.request = {};

        /**
         * Login by email
         * TODO - make validations
         */
        $scope.emailLogin = function ()
        {
            $scope.request = $scope.buildRequest();
            $scope.request.isFB = 0;
            console.log("email: "+$scope.email);
            console.log("password: "+$scope.password);
            Login.login($scope.request).success(function(response){
                console.log(response);
                window.location="/test";
            }).error(function(response){
                console.log(response);
            });
        };

        /**
         * Login by Facebook
         * TODO - make validations
         */
        $scope.facebookLogin = function()
        {
        };

        /**
         * Build the request for login
         * @returns JSON
         */
        $scope.buildRequest = function()
        {
            var request = {
                'email': $scope.email,
                'password': $scope.password,
                'method': 'login',
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };
            return request;
        }
    }

})();