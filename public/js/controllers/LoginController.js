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
                        window.location.assign("/user/profile/" + user.id);
                    }
                } else if(response.status == -1) {
                    $scope.utils.hideLoader();
                    alert("Correo y/o contraseña inválidos.");
                }
            }).error(function(response){
                $scope.utils.hideLoader();
                console.log(response);
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
                                    window.location.assign("/user/profile/" + user.id);
                                }
                            } else if(response.status == -1) {
                                $scope.utils.hideLoader();
                                alert("Ocurrio un problema al hacer la autenticación por medio de Facebook, por favor intentalo más tarde");
                            }
                        }).error(function(response){
                            $scope.utils.hideLoader();
                            console.log(response);
                        });

                    });

                } else {
                    console.log("Ocurrio un problema al hacer la conexión con Facebook, por favor intentalo más tarde");
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
        }

    }

})();
