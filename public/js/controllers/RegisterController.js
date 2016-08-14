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
        $scope.request = {};

        $scope.emailRegister = function ()
        {
            console.log("registrando ...");
            console.log("nombre: "+$scope.name);
            console.log("apellido: "+$scope.lastname);
            console.log("email: "+$scope.email);
            console.log("contraseña: "+$scope.password);

            $scope.request = {
                'name': $scope.name,
                'lastname': $scope.lastname,
                'email': $scope.email,
                'password': $scope.password,
                'isFB' : '0',
                'method': 'register',
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };

            Register.register($scope.request).success(function(response){
                console.log(response);
            }).error(function(response){
                console.log(response);
            });

        };

        $scope.facebookRegister = function()
        {

        };
    }

})();