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
        $scope.utils = new Utils();

        /**
         * Register a new user by email
         */
        $scope.emailRegister = function ()
        {
            console.log($scope.gender);
            if($scope.emailValidate()){

                $scope.birthday = $scope.birthdayYear+"-"+$scope.birthdayMonth+"-"+$scope.birthdayDay;
                $scope.request = $scope.buildRequest();
                $scope.utils.showLoader();
                Register.register($scope.request).success(function(response)
                {
                    if (response.status == 200) {
                        var user = response.data['User'];
                        window.userdata = response.data;
                        window.location.assign("/user/profile/" + user.id);
                    } else if(response.status == -2) {
                        $scope.utils.hideLoader();
                        $scope.utils.setAlertTitle("Coperacha - Alerta");
                        document.getElementById('alert-content').innerHTML="" +
                        "<p>El correo ingresado ya existe en el sistema, por favor intenta con otro.<p>";
                        $scope.utils.showAlert();
                    } else {
                        $scope.utils.hideLoader();
                        $scope.utils.setAlertTitle("Coperacha - Alerta");
                        document.getElementById('alert-content').innerHTML="" +
                        "<p>Se ha generado producido un error al realizar el registro, por favor inténtalo más tarde<p>";
                        $scope.utils.showAlert();
                    }
                }).error(function(response){
                    $scope.utils.hideLoader();
                    $scope.utils.setAlertTitle("Coperacha - Alerta");
                    document.getElementById('alert-content').innerHTML="" +
                    "<p>Se ha generado producido un error al realizar el registro, por favor inténtalo más tarde<p>";
                    $scope.utils.showAlert();
                });
            }
        };

        /**
         * Validate when register is by email
         * @returns {boolean}
         */
        $scope.emailValidate = function()
        {

            var utils = $scope.utils;

            if (utils.isNullOrEmpty($scope.name)) {
                utils.setValidationError("El campo Nombre es requerido");
                return false;
            } else if (utils.isNullOrEmpty($scope.lastname)) {
                utils.setValidationError("El campo Apellido es requerido");
                return false;
            } else if (utils.isNullOrEmpty($scope.email)) {
                utils.setValidationError("El campo Correo electrónico es requerido");
                return false;
            } else if (!utils.isValidEmail($scope.email)) {
                utils.setValidationError("El Correo electrónico ingresado no es válido");
                return false;
            } else if (utils.isNullOrEmpty($scope.password)) {
                utils.setValidationError("El campo Contraseña no es válido");
                return false;
            } else if (!utils.isNullOrEmpty($scope.confirmPassword)) {
                if($scope.confirmPassword != $scope.password){
                    utils.setValidationError("Las contraseñas no coinciden");
                    return false;
                }
            }

            return true;

        };


        /**
         * Register by Faceboook
         */
        $scope.facebookRegister = function()
        {
            // 1. Facebook Login
            FBLogin(function (result) {
                if (result.status === 'connected') {
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
                            if (response.status == 200) {
                                var user = response.data['User'];
                                window.location="/user/profile/"+user.id;
                            } else if(response.status == -2) {
                                $scope.utils.hideLoader();
                                $scope.utils.setAlertTitle("Coperacha - Alerta");
                                document.getElementById('alert-content').innerHTML="" +
                                "<p>El correo ingresado ya existe en el sistema, por favor intenta con otro.<p>";
                                $scope.utils.showAlert();
                            }

                        }).error(function(response){
                            $scope.utils.hideLoader();
                            $scope.utils.setAlertTitle("Coperacha - Alerta");
                            document.getElementById('alert-content').innerHTML="" +
                            "<p>Se ha generado producido un error al realizar el registro, por favor inténtalo más tarde<p>";
                            $scope.utils.showAlert();
                        });

                    });

                } else {
                    $scope.utils.setAlertTitle("Coperacha - Alerta");
                    document.getElementById('alert-content').innerHTML="" +
                    "<p>Ocurrio un problema al hacer la conexión con Facebook, por favor intentalo maás tarde<p>";
                    $scope.utils.showAlert();
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
