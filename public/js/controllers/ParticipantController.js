(function(){

    angular
        .module("ParticipantController", [])
        .controller('participantController', participantController);

    participantController.$inject = ['$scope', 'Participant', 'Moneybox'];

    function participantController($scope, Participant)
    {
        $scope.utils = new Utils();
        $scope.moneybox = null;
        $scope.moneyboxSettings = null;
        $scope.name = '';
        $scope.lastname = '';
        $scope.phone = '';
        $scope.email = '';
        $scope.amount = '';
        $scope.settings = '';
        $scope.request = {};

        $scope.goToParticipation = function()
        {
            window.location = "/moneybox/join/"+$scope.moneyboxurl;
        };

        $scope.createParticipant = function()
        {
            var moneybox = JSON.parse($scope.moneybox);
            var participantSettings = [];
            var tmp = [];

            if ($scope.settings != '') {
                tmp = $scope.settings.split('|');
                participantSettings.push({'setting_id':tmp[0],'option_id':tmp[1],"value":1});
            } else {
                alert("Selecciona una opción");
                return;
            }

            if ($scope.validateAmount()) {
                $scope.request = {
                    'moneybox_id' : moneybox.id,
                    'name': $scope.name,
                    'lastname': $scope.lastname,
                    'email' : $scope.email,
                    'phone' : $scope.phone,
                    'settings' : JSON.stringify(participantSettings),
                    'method' : 'createParticipant',
                    'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
                };

                $scope.utils.showLoader();
                // step 1. create the tmp participant
                $scope.createTmpParticipant(function(response){
                    console.log(response);
                    if(response.status == 200){
                        // step 2. create participant and redirect to another view
                        Participant.create($scope.request)
                            .success(function(create_response)
                            {
                                console.log(create_response);
                                if(create_response.status == 200){
                                    window.location = '/moneybox/summary/'+moneybox.url;
                                } else {
                                    $scope.utils.hideLoader();
                                }
                            })
                            .error(function(create_response)
                            {
                                $scope.utils.hideLoader();
                                alert("Ocurrio un error al registrar tus datos, porfavor intentalo mas tarde");
                                console.log(create_response);
                            });
                    }
                });
            }
        };

        /**
         * Validate settings
         * setting_id = 1 --- monto
         *  option_id = 1 --- Libre
         *  option_id = 2 --- Sugerido
         *  option_id = 3 --- Fijo
         *
         * setting_id = 2 --- privacidad
         *  option_id = 4 --- ocultar identidad
         *  option_id = 5 --- ocultar importe
         *  option_id = 6 --- ocultar importe alcancia
         */
        $scope.validateAmount = function()
        {
            var settings = JSON.parse($scope.moneyboxSettings);
            var amount   = parseFloat($scope.amount);
            var result   = false;

            if (amount == '' || isNaN(amount))
                return result;

            if (parseFloat(amount) <= 50)
            {
                alert("El monto mínimo de participación son $50.00");
                return result;
            }

            for (var i = 0; i < settings.length; i++) {

                if (settings[i].setting_id == 1) { // validate amount settings
                    if (settings[i].option_id == 2) {
                        if (amount < settings[i].value) {
                            alert("El monto sugerido para participar en esta alcancía es de $ " + parseFloat(settings[i].value));
                        } else {
                            result = true;
                            break;
                        }
                    } else if (settings[i].option_id == 3) {
                        if (amount != settings[i].value) {
                            alert("El monto fijado para esta alcancía es de $ " + parseFloat(settings[i].value));
                        } else {
                            result = true;
                            break;
                        }
                    }
                }
            }

            return result;
        }

        $scope.createTmpParticipant = function(callback)
        {
            var request = {
                'amount': $scope.amount,
                'email' : $scope.email,
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };

            Participant.createTmpParticipant(request)
                .success(function(response){
                    callback(response);
                })
                .error(function(response)
                {
                    alert("Ocurrio un error al registrar tus datos, porfavor intentalo mas tarde"+"\n\t"+response);
                });

        }

    }

})();