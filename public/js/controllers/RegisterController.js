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
        $scope.facebook_uid = '';
        $scope.request = {};
        // TODO -  use this for redirections
        $scope.toMoneybox = 0;
        $scope.toProfile = 0;
        $scope.utils = new Utils();

        /**
         * Register a new user by email
         * TODO - make validations
         */
        $scope.emailRegister = function ()
        {
            $scope.birthday = $scope.birthdayYear+"-"+$scope.birthdayMonth+"-"+$scope.birthdayDay;

            if ($scope.confirmPassword != "")
            {
                if($scope.confirmPassword != $scope.password){
                    alert("Las contraseñas no coinciden"); // TODO - change this alert
                    return;
                }
            }
            $scope.request = $scope.buildRequest();
            $scope.utils.showLoader();
            Register.register($scope.request).success(function(response)
            {
                console.log(response);
                if (response.status == 200) {
                    var user = response.data['User'];
                    window.userdata = response.data;
                    window.location.assign("/user/profile/" + user.id);
                } else if(response.status == -2) {
                    $scope.utils.hideLoader();
                    alert("El correo ingresado ya existe en el sistema, por favor intenta con otro.");
                } else {
                    $scope.utils.hideLoader();
                    alert("Ocurrio un error mientras realizabamos tu registro, por favor intenta mas tarde");
                }
            }).error(function(response){
                $scope.utils.hideLoader();
                console.log(response);
            });
        };

        /**
         * Register by Faceboook
         */
        $scope.facebookRegister = function()
        {
            // 1. Facebook Login
            FBLogin(function (result) {
                if (result.status === 'connected') {
                    console.log('Logged in Facebook.');

                    // 2. get Facebook data
                    FBData(function(result){
                        var names = result.name.split(" ");
                        $scope.name = names[0];
                        for (var i = 1; i<names.length; i++){
                            $scope.lastname += names[i]+" ";
                        }
                        $scope.FBemail = result.email;
                        $scope.facebook_uid = result.id;

                        // 3. call facebook register
                        $scope.request = $scope.buildFacebookRequest();
                        $scope.utils.showLoader();
                        Register.register($scope.request).success(function(response)
                        {
                            console.log(response);
                            if (response.status == 200) {
                                var user = response.data['User'];
                                window.location="/user/profile/"+user.id;
                            } else if(response.status == -2) {
                                $scope.utils.hideLoader();
                                alert("El correo ingresado ya existe en el sistema, por favor intenta con otro.");
                            }

                        }).error(function(response){
                            console.log(response);
                        });

                    });

                } else {
                    console.log("Ocurrio un problema al hacer la conexión con Facebook, por favor intentalo maás tarde");
                }
            });

        };

        /**
         * Build the request for register
         * @returns JSON
         */
        $scope.buildRequest = function()
        {
            var request = {
                'name': $scope.name,
                'lastname': $scope.lastname,
                'email': $scope.email,
                'password': $scope.password,
                'isFB' : 0,
                'method': 'register',
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };
            if ($scope.gender != "") request.gender = $scope.gender;
            if ($scope.username != "") request.username = $scope.username;
            if ($scope.username != "") request.username = $scope.username;
            if ($scope.birthday != "--") request.birthday = $scope.utils.formatDate($scope.birthday);
            if ($scope.country != "") request.country = $scope.country;
            if ($scope.city != "") request.city = $scope.city;

            return request;
        };

        /**
         * Build the request for Facebook register
         */
        $scope.buildFacebookRequest = function()
        {
            var request = {
                'name': $scope.name,
                'lastname': $scope.lastname,
                'email': $scope.FBemail,
                'facebook_uid': $scope.facebook_uid,
                'isFB' : 1,
                'method': 'register',
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };

            return request;
        }

    }

})();
