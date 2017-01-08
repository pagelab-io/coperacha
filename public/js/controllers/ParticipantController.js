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
        $scope.amount = 50;
        $scope.commission = '';
        $scope.settings = '';
        $scope.token = '';
        $scope.request = {};
        $scope.paymentMethod = '';
        $scope.moneybox_id = '';
        $scope.areacode = '';

        $scope.goToParticipation = function()
        {
            window.location = "/moneybox/join/"+$scope.moneyboxurl;
        };

        $scope.createParticipant = function()
        {
            if (!$scope.validate())
                return;

            var moneybox = JSON.parse($scope.moneybox);
            var participantSettings = [];
            var tmp = [];

            tmp = $scope.settings.split('|');
            participantSettings.push({'setting_id':tmp[0],'option_id':tmp[1],"value":1});

            if ($scope.validateAmount()) {
                $scope.request = {
                    'moneybox_id' : moneybox.id,
                    'name': $scope.name,
                    'lastname': $scope.lastname,
                    'email' : $scope.email,
                    'phone' : $scope.phone,
                    'areacode': $scope.areacode,
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
                                $scope.utils.setAlertTitle("Coperacha - Alerta");
                                document.getElementById('alert-content').innerHTML="" +
                                "<p>Ocurrio una incidencia al registrar tus datos, por favor inténtalo más tarde<p>";
                                $scope.utils.showAlert();
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

            if (parseFloat(amount) <= 49)
            {
                $scope.utils.setAlertTitle("Coperacha - Alerta");
                document.getElementById('alert-content').innerHTML="" +
                "<p>El monto mínimo de participación son $50.00<p>";
                $scope.utils.showAlert();
                return result;
            }

            for (var i = 0; i < settings.length; i++) {

                if (settings[i].setting_id == 1) { // validate amount settings
                    if (settings[i].option_id == 1) {
                        result = true;
                        break;
                    }else if (settings[i].option_id == 2) {
                        if (amount < settings[i].value) {
                            $scope.utils.setAlertTitle("Coperacha - Alerta");
                            document.getElementById('alert-content').innerHTML="" +
                            "<p>El monto sugerido para participar en esta alcancía es de $ " + parseFloat(settings[i].value)+"<p>";
                            $scope.utils.showAlert();
                        } else {
                            result = true;
                            break;
                        }
                    } else if (settings[i].option_id == 3) {
                        if (amount != settings[i].value) {
                            $scope.utils.setAlertTitle("Coperacha - Alerta");
                            document.getElementById('alert-content').innerHTML="" +
                            "<p>El monto fijado para esta alcancía es de $ " + parseFloat(settings[i].value)+"<p>";
                            $scope.utils.showAlert();
                        } else {
                            result = true;
                            break;
                        }
                    }
                }
            }

            return result;
        };

        $scope.createTmpParticipant = function(callback)
        {
            var tmp = $scope.settings.split('|');

            var request = {
                'amount': $scope.amount,
                'name': $scope.name,
                'lastname': $scope.lastname,
                'phone' : $scope.phone,
                'email' : $scope.email,
                'option_id' : tmp[1],
                'areacode': $scope.areacode,
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };

            Participant.createTmpParticipant(request)
                .success(function(response){
                    callback(response);
                })
                .error(function(response)
                {
                    $scope.utils.setAlertTitle("Coperacha - Alerta");
                    document.getElementById('alert-content').innerHTML="" +
                    "<p>Ocurrio un error al registrar tus datos, porfavor intentalo mas tarde<p>";
                    $scope.utils.showAlert();
                });

        };

        $scope.deleteTmpParticipant = function(callback)
        {

            var request = {'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'};
            Participant.deleteTmpParticipant(request)
                .success(function(response){
                    callback(response);
                })
                .error(function(response){
                    $scope.utils.setAlertTitle("Coperacha - Alerta");
                    document.getElementById('alert-content').innerHTML="" +
                    "<p>Ocurrio una incidencia, porfavor intentalo mas tarde<p>";
                    $scope.utils.showAlert();
                });
        };

        $scope.validatePaymentMethod = function()
        {
            var utils = $scope.utils;
            if ($scope.paymentMethod == 'P' || $scope.paymentMethod == 'O' || $scope.paymentMethod == 'S')
                $scope.doPayment();
            else if ($scope.paymentMethod == 'T') {
                utils.setPaymentCardForm();
                $("#close-alert-2").on('click', function(event) {
                    $("#close-alert-2").unbind("click");
                    utils.showLoader();
                    var $form = $("#card-form");
                    Conekta.token.create($form, function(response){
                        utils.hideLoader();
                        $scope.token = response.id; // conekta token
                        $scope.doPayment();
                    }, function(error_response) {
                        console.log(error_response);
                        utils.hideLoader();
                        utils.setValidationError(error_response.message_to_purchaser);
                    });
                });
            }

        };

        $scope.doPayment = function()
        {
            var moneybox = JSON.parse($scope.moneybox);
            $scope.request = {
                'person_id' : $scope.person_id,
                'moneybox_id'  : moneybox.id,
                'amount'  : $scope.amount,
                'commission' : $scope.commission,
                'payment_method'  : $scope.paymentMethod,
                'method' : 'createPayment',
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };
            if ($scope.paymentMethod == 'T')  $scope.request['token'] = $scope.token; // if card payment

            $scope.utils.showLoader();
            Participant.payment($scope.request)
                .success(function(response){
                    if(response.status == 200) {

                        if ($scope.paymentMethod == 'P') {
                            window.location = response.data.url;
                        } else if($scope.paymentMethod == 'O') {
                            $scope.utils.hideLoader();
                            $scope.utils.setAlertTitle("Confirmación de pago por OXXO");

                            var url = response.data.payment_method.barcode_url.split("https://s3.amazonaws.com/cash_payment_barcodes/");
                            var barcode = response.data.payment_method.barcode;

                            document.getElementById('alert-content').innerHTML="" +
                            "<p>Se ha generado un nuevo cargo, puedes ir a tu tienda OXXO más cercana y hacer tu pago con los siguientes datos:<p>" +
                            "<br>" +
                            "<image src='"+response.data.payment_method.barcode_url+"'>" +
                            "<br>" +
                            "<span>"+barcode+"</span>" +
                            "<br><br>" +
                            "<span class='info-alert'>Nota: al realizar tu pago, recibirás un correo de confirmación de pago</span>" +
                            "<br>" +
                            "<span class='info-alert'><a href='/payment/downloadPayment/oxxo/"+url[1]+"/"+barcode+"/0' target='_blank'>Descargar datos de pago</a></span>";
                            $scope.utils.showAlert();
                        } else if($scope.paymentMethod == 'S') {

                            $scope.utils.hideLoader();
                            $scope.utils.setAlertTitle("Confirmación de pago por SPEI");

                            var clabe = response.data.payment_method.clabe;

                            document.getElementById('alert-content').innerHTML="" +
                            "<p>Se ha generado un nuevo cargo, puedes ir a realizar tu pago con los siguientes datos:<p>" +
                            "<br>" +
                            "<span> No. Clabe: "+clabe+"</span>" +
                            "<br><br>" +
                            "<span class='info-alert'>Nota: al realizar tu pago, recibirás un correo de confirmación de pago</span>" +
                            "<br><br>" +
                            "<span class='info-alert'><a href='/payment/downloadPayment/spei/0/0/"+clabe+"' target='_blank'>Descargar datos de pago</a></span>";
                            $scope.utils.showAlert();
                        } else if($scope.paymentMethod == 'T') {
                            $scope.utils.hideLoader();
                            $scope.utils.setAlertTitle("Confirmación de pago por Tarjeta de crédito/débito");
                            document.getElementById('alert-content').innerHTML="" +
                                "<p>Tu pago se ha procesado correctamente, en un momento se verá reflejada tu aportación a la alcancía.<p>" +
                                "<br>" +
                                "<span class='info-alert'>Nota: al realizar tu pago, recibirás un correo de confirmación de pago</span>" +
                                "<br>" ;
                            $scope.utils.showAlert();
                        }

                    } else {
                        $scope.utils.hideLoader();
                        $scope.utils.setAlertTitle("Coperacha - Alerta");
                        document.getElementById('alert-content').innerHTML="" +
                        "<p>Ocurrió una incidencia al generarse el pago, por favor inténtelo más tarde o elija otro método de pago<p>";
                        $scope.utils.showAlert();
                    }
                })
                .error(function(response){
                    $scope.utils.hideLoader();
                    $scope.utils.setAlertTitle("Coperacha - Alerta");
                    document.getElementById('alert-content').innerHTML="" +
                    "<p>Ocurrio una incidencia al generarse el pago, por favor inténtelo más tarde<p>";
                    $scope.utils.showAlert();
                });
        };

        /**
         * Validate when register is by email
         * @returns {boolean}
         */
        $scope.validate = function()
        {
            var utils = $scope.utils;

            if (utils.isNullOrEmpty($scope.name)) {
                utils.setValidationError("El campo Nombre es requerido");
                return false;
            } else if (utils.isNullOrEmpty($scope.lastname)) {
                utils.setValidationError("El campo Apellido es requerido");
                return false;
            } else if (utils.isNullOrEmpty($scope.phone)) {
                utils.setValidationError("El campo teléfono es requerido");
                return false;
            } else if (!utils.isValidPhone($scope.phone)) {
                utils.setValidationError("El campo teléfono es incorrecto, deben ser 10 números");
                return false;
            } else if (!utils.isValidEmail($scope.email)) {
                utils.setValidationError("El Correo electrónico ingresado no es válido");
                return false;
            } else if (utils.isNullOrEmpty($scope.amount)) {
                utils.setValidationError("El campo Contraseña no es válido");
                return false;
            } else if (!utils.isValidNumber($scope.amount)) {
                utils.setValidationError("El campo Contraseña no es válido");
                return false;
            } else if (utils.isNullOrEmpty($scope.settings)) {
                utils.setValidationError("Debes elegir una opcion para tu participación");
                return false;
            }

            return true;

        };

        $scope.participantsByMoneybox = function()
        {
            var utils = $scope.utils;
            $scope.request = {
                'moneybox_id':$scope.moneybox_id,
                'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
            };

            Participant.getMoneyboxParticipants($scope.request)
                .success(function (response){
                    console.log(response);
                    utils.setAlertTitle("Participantes");
                    if(response.status==200){
                        var participants = response.data;
                        var content = "";
                        for (var i = 0; i < participants.length; i++) {
                            if (i % 2 == 0)
                                content += "<div class='row'>";

                            // participant content
                            var settings = participants[i].settings;
                            if (settings[0].option_id == 7) { // visible
                                content += "<div class='col-xs-6'>" +
                                "<img class='participant-avatar' src='http://www.netjoven.pe/images/avatar.png'>" +
                                "<p>Nombre: " + participants[i].person.name + "</p>" +
                                "<p>Monto: $" + participants[i].amount + "</p>" +
                                "</div>";
                            } else if (settings[0].option_id == 8) { // just name
                                content += "<div class='col-xs-6'>" +
                                "<img class='participant-avatar' src='http://www.netjoven.pe/images/avatar.png'>" +
                                "<p>Nombre: " + participants[i].person.name + "</p>" +
                                "</div>";
                            } else if (settings[0].option_id == 9) { // nothing
                                content += "<div class='col-xs-6'>" +
                                "<img class='participant-avatar' src='http://www.netjoven.pe/images/avatar.png'>" +
                                "<p>Anónimo</p></div>";
                            }

                            // participant content

                            if (i % 2 != 0)
                                content += "</hr></div>";
                        }
                        document.getElementById('alert-content').innerHTML=content;
                    } else if (response.status == -1){
                        document.getElementById('alert-content').innerHTML="" +
                        "<div class='row'>" +
                        " Esta alcancía aun no tiene participantes " +
                        "</div>";
                    }

                    utils.showAlert();
                });
        }
    }

})();