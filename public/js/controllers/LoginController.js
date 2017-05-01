(function(){

    angular
        .module("LoginController", [])
        .controller('loginController', loginController);

    loginController.$inject = ['$scope', '$element', 'Login'];

    function loginController($scope, $element, Login)
    {
        /**
         * add the enter action
         */
        document.addEventListener('keyup', function(e){
            if (e.keyCode === 13) {
                if ($scope.email != "" && $scope.password != "") {
                    $scope.emailLogin();
                }
            }
        });

        $scope.utils = new Utils();
        $scope.email = "";
        $scope.FBemail = "";
        $scope.password = "";
        $scope.facebook_uid = "";
        $scope.request = {};

        /**
         * Login by email
         * TODO - make validations
         */
        $scope.emailLogin = function ()
        {

            if(!$scope.validateLogin())
                return ;

            $scope.redirectTo = $element.attr('data-redirect-to');
            $scope.request = $scope.buildRequest();
            $scope.utils.showLoader();
            Login.login($scope.request).success(function(response){
                // console.log(response);
                if (response.status == 200) {
                    var user = response.data;
                    if ($scope.redirectTo) {
                        window.location.assign($scope.redirectTo);
                    } else {
                        window.location.assign("/moneybox/dashboard");
                    }
                } else if(response.status == -1) {
                    $scope.utils.hideLoader();
                    $scope.utils.setAlertTitle("Coperacha - Alerta");
                    document.getElementById('alert-content').innerHTML="" +
                    "<p>Correo y/o contraseña inválidos<p>";
                    $scope.utils.showAlert();
                }
            }).error(function(response){
                $scope.utils.hideLoader();
                $scope.utils.setAlertTitle("Coperacha - Alerta");
                document.getElementById('alert-content').innerHTML="" +
                "<p>Ocurrió una incidencia al intentar iniciar sesión, por favor inténtalo más tarde.<p>";
                $scope.utils.showAlert();
            });
        };

        /**
         * Login by Facebook
         * TODO - make validations
         */
        $scope.facebookLogin = function()
        {
            $scope.redirectTo = $element.attr('data-redirect-to');

            // 1. Facebook Login
            FBLogin(function (result) {
                if (result.status === 'connected') {
                    console.log('Logged in Facebook.');

                    // 2. get Facebook data
                    FBData(function(result) {
                        $scope.FBemail = result.email;
                        $scope.facebook_uid = result.id;

                        // 3. call facebook register
                        $scope.request = $scope.buildFacebookRequest();
                        $scope.utils.showLoader();
                        Login.login($scope.request).success(function(response)
                        {
                            // console.log(response);
                            if (response.status == 200) {
                                var user = response.data;
                                //window.location="/user/profile/"+ user.id;
                                if ($scope.redirectTo) {
                                    window.location.assign($scope.redirectTo);
                                } else {
                                    window.location.assign("/moneybox/dashboard/");
                                }
                            } else if(response.status == -1) {
                                $scope.utils.hideLoader();
                                $scope.utils.setAlertTitle("Coperacha - Alerta");
                                document.getElementById('alert-content').innerHTML="" +
                                "<p>Ocurrió una incidencia al intentar iniciar sesión, por favor inténtalo más tarde.<p>";
                                $scope.utils.showAlert();
                            }
                        }).error(function(response){
                            $scope.utils.hideLoader();
                            console.log(response);
                        });

                    });

                } else {
                    $scope.utils.setAlertTitle("Coperacha - Alerta");
                    document.getElementById('alert-content').innerHTML="" +
                    "<p>Ocurrió una incidencia al hacer la conexión con Facebook, por favor inténtalo más tarde.<p>";
                    $scope.utils.showAlert();
                }
            });
        };

        /**
         * Build the request for login
         * @returns {{email: string, password: string, isFB: number, method: string, api-key: string}}
         */
        $scope.buildRequest = function()
        {
            var request = {
                'email': $scope.email,
                'password': $scope.password,
                'isFB': 0,
                'method': 'login',
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };
            return request;
        };

        /**
         * Build the request for Facebook login
         *
         * @returns {{email: (string|*), facebook_uid: (*|string), isFB: number, method: string, api-key: string}}
         */
        $scope.buildFacebookRequest = function()
        {
            var request = {
                'email': $scope.FBemail,
                'facebook_uid': $scope.facebook_uid,
                'isFB': 1,
                'method': 'login',
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };
            return request;
        };

        $scope.validateLogin = function()
        {
            var utils = $scope.utils;

            if (utils.isNullOrEmpty($scope.email)) {
                utils.setValidationError("El correo electrónico es requerido.");
                return false;
            } else if (!utils.isValidEmail($scope.email)) {
                utils.setValidationError("El correo electrónico no tiene un formato válido");
                return false;
            } else if (utils.isNullOrEmpty($scope.password)) {
                utils.setValidationError("La contraseña es requerida");
                return false;
            }

            return true;
        }

    }

})();
