(function(){

    angular
        .module("RegisterController", [])
        .controller('registerController', registerController);

    registerController.$inject = ['$scope', 'Register'];

    function registerController($scope, Register)
    {
        $scope.name = '';
        $scope.lastname = '';
        $scope.email = '';
        $scope.password = '';
        $scope.gender = '';
        $scope.username = '';
        $scope.confirmPassword = '';
        $scope.birthdayDay = '';
        $scope.birthdayMonth = '';
        $scope.birthdayYear = '';
        $scope.birthday = '';
        $scope.country = '';
        $scope.city = '';
        $scope.request = {};
        // TODO -  use this for redirections
        $scope.toMoneybox = 0;
        $scope.toProfile = 0;

        /**
         * Register a new user by email
         * TODO - make validations
         */
        $scope.emailRegister = function ()
        {
            var utils = new Utils();
            $scope.birthday = $scope.birthdayYear+"-"+$scope.birthdayMonth+"-"+$scope.birthdayDay;

            if ($scope.confirmPassword != "")
            {
                if($scope.confirmPassword != $scope.password){
                    alert("Las contraseñas no coinciden"); // TODO - change this alert
                    return;
                }
            }

            $scope.request = {
                'name': $scope.name,
                'lastname': $scope.lastname,
                'email': $scope.email,
                'password': $scope.password,
                'isFB' : '0',
                'method': 'register',
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };

            if ($scope.gender != "") $scope.request.gender = $scope.gender;
            if ($scope.username != "") $scope.request.username = $scope.username;
            if ($scope.username != "") $scope.request.username = $scope.username;
            if ($scope.birthday != "--") $scope.request.birthday = utils.formatDate($scope.birthday);
            if ($scope.country != "") $scope.request.country = $scope.country;
            if ($scope.city != "") $scope.request.city = $scope.city;

            Register.register($scope.request).success(function(response)
            {
                console.log(response);
                // redirigir dependiendo de donde se dio el click.
            }).error(function(response){
                console.log(response);
            });
        };

        $scope.facebookRegister = function()
        {

        };
    }

})();