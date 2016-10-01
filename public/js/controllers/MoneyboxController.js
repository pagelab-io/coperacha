(function(){

    angular
        .module("MoneyboxController", [])
        .controller('moneyboxController', moneyboxController);

    moneyboxController.$inject = ['$scope', 'Moneybox'];

    function moneyboxController($scope, Moneybox) {
        initDatePicker();
        $scope.utils = new Utils();
        $scope.step1 = document.getElementById('moneybox-step1');
        $scope.step2 = document.getElementById('moneybox-step2');
        $scope.request = {};
        $scope.name = '';
        $scope.person_name = '';
        $scope.person_id = '';
        $scope.goal_amount = '';
        $scope.end_date = '';
        $scope.description = '';
        $scope.category_id = '';
        $scope.privacy1 = '0|0|N';
        $scope.privacy2 = '0|0|N';
        $scope.privacy3 = '0|0|N';
        $scope.participation = '';
        $scope.settings = [];
        $scope.moneybox_id = 0;
        $scope.amount_id = 0;
        $scope.privacy_id = 0;
        $scope.step2.style.display = "none";

        $scope.step1Click = function()
        {
            if ($scope.validateStep1()) {
                if($scope.step1.style.display != 'none') {
                    $scope.step1.style.display = "none";
                    $scope.step2.style.display = "block";
                    document.getElementById('pageTitle').innerHTML = "CREAR MI ALCANCÍA 2/2";
                }
            }
        };

        $scope.step2Click = function()
        {
            if($scope.step2.style.display != 'none') {
                $scope.step2.style.display = "none";
                $scope.step1.style.display = "block";
                document.getElementById('pageTitle').innerHTML = "CREAR MI ALCANCÍA 1/2";
            }
        };

        $scope.createMoneybox = function()
        {
            if (!$scope.validateStep2())
                return;

            // build the settings object
            var participation = $scope.participation.split('|');
            var participationValue = 1;

            var privacy1 = $scope.privacy1.split('|');
            var privacy2 = $scope.privacy2.split('|');
            var privacy3 = $scope.privacy3.split('|');
            var privacyValue1 = 1;
            var privacyValue2 = 1;
            var privacyValue3 = 1;

            if (participation[2] == 'Y') {
                participationValue = document.getElementById('txt-option-'+participation[1]).value;
                console.log(participationValue);
                if(participationValue < 50) {
                    $scope.utils.setAlertTitle("Coperacha - Alerta");
                    document.getElementById('alert-content').innerHTML="" +
                    "<p>Los montos mínimos de participación son $50.00<p>";
                    $scope.utils.showAlert();
                    return;
                }
            }

            if ($scope.moneybox_id == 0) {
                $scope.settings.push({'setting_id':participation[0],'option_id':participation[1],'value':participationValue});
                if(privacy1[0] != 0 && privacy1[1] != 0)
                    $scope.settings.push({'setting_id':privacy1[0],'option_id':privacy1[1],'value':privacyValue1});
                if(privacy2[0] != 0 && privacy2[1] != 0)
                    $scope.settings.push({'setting_id':privacy2[0],'option_id':privacy2[1],'value':privacyValue2});
                if(privacy3[0] != 0 && privacy3[1] != 0)
                    $scope.settings.push({'setting_id':privacy3[0],'option_id':privacy3[1],'value':privacyValue3});

                // build the request to save the moneybox
                $scope.request = {
                    'category_id' : $scope.category_id,
                    'person_id' : $scope.person_id,
                    'name' : $scope.name,
                    'description' : $scope.description,
                    'goal_amount' : $scope.goal_amount,
                    'end_date' : $scope.end_date,
                    'settings' : JSON.stringify($scope.settings),
                    'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
                };

            } else {
                // build the request to save the moneybox
                $scope.request = {
                    'description' : $scope.description,
                    'end_date' : $scope.end_date,
                    'api-key' : '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC'
                };
            }


            if ($scope.moneybox_id != 0) {
                // update
                $scope.request['method'] = 'updateMoneybox';
                $scope.request['moneybox_id'] = $scope.moneybox_id;
                $scope.utils.showLoader();
                Moneybox.update($scope.request)
                    .success(function(response){
                        if (response.status == 200) {
                            if($scope.fileExist()){
                                $scope.uploadImage(document.getElementById('file'), false, function(imageResponse){

                                    // si hay error en la subida del archivo dejar pasar de todos modos ya que la alcancia ya se creo.
                                    if (imageResponse.success) {
                                        window.location = '/moneybox/detail/'+response.data.url;
                                    } else {
                                        window.location = '/moneybox/detail/'+response.data.url;
                                    }

                                });
                            } else {
                                window.location = '/moneybox/detail/'+response.data.url;
                            }
                        } else {
                            $scope.utils.hideLoader();
                            $scope.utils.setAlertTitle("Coperacha - Alerta");
                            document.getElementById('alert-content').innerHTML="" +
                            "<p>Ocurrió una incidencia al actualizar la alcancía, inténtalo nuevamente por favor<p>";
                            $scope.utils.showAlert();
                        }
                    })
                    .error(function(response){
                        $scope.utils.hideLoader();
                    });
            } else {
                // creation
                $scope.request['method'] = 'createMoneybox';
                $scope.utils.showLoader();
                Moneybox.create($scope.request)
                    .success(function(response){
                        if (response.status == 200) {

                            if ($scope.fileExist()) {
                                $scope.moneybox_id = response.data.id;
                                $scope.uploadImage(document.getElementById('file'), true, function(imageResponse){
                                    // si hay error en la subida del archivo dejar pasar de todos modos ya que la alcancia ya se creo.
                                    if (imageResponse.success) {
                                        window.location = '/moneybox/detail/'+response.data.url;
                                    } else {
                                        window.location = '/moneybox/detail/'+response.data.url;
                                    }

                                });
                            } else {
                                window.location = '/moneybox/detail/'+response.data.url;
                            }

                        } else {
                            $scope.utils.hideLoader();
                            $scope.utils.setAlertTitle("Coperacha - Alerta");
                            document.getElementById('alert-content').innerHTML="" +
                            "<p>Ocurrió una incidencia al crear la alcancía, inténtalo nuevamente por favor<p>";
                            $scope.utils.showAlert();
                        }
                    })
                .error(function(response){
                    $scope.utils.hideLoader();
                });
            }
        };

        $scope.validateStep2 = function()
        {
            var utils = $scope.utils;

            if ($scope.moneybox_id == 0) {
                if (utils.isNullOrEmpty($scope.participation)) {
                    utils.setValidationError("Selecciona un tipo de monto");
                    return false;
                }else if ($scope.privacy1 == "0|0|N" && $scope.privacy2 == "0|0|N" && $scope.privacy3 == "0|0|N") {
                    utils.setValidationError("Selecciona una opción de privacidad");
                    return false;
                }
            } else {
                if (utils.isNullOrEmpty($scope.description)) {
                    utils.setValidationError("El campo descripción es requerido");
                    return false;
                }else if (utils.isNullOrEmpty($scope.end_date)) {
                    utils.setValidationError("El campo fecha límite es requerido");
                    return false;
                } else if (!utils.isValidDate($scope.end_date)) {
                    utils.setValidationError("El campo fecha límite no tiene un formato válido yyyy-mm-dd");
                    return false;
                }
            }

            return true;
        };

        $scope.validateStep1 = function()
        {
            var utils = $scope.utils;
            if (utils.isNullOrEmpty($scope.category_id)) {
                utils.setValidationError("El campo categoría es requerido");
                return false;
            } else if (utils.isNullOrEmpty($scope.name)) {
                utils.setValidationError("El campo nombre es requerido");
                return false;
            } else if (utils.isNullOrEmpty($scope.description)) {
                utils.setValidationError("El campo descripción es requerido");
                return false;
            } else if (utils.isNullOrEmpty($scope.goal_amount)) {
                utils.setValidationError("El campo cantidad a reunir es requerido");
                return false;
            } else if (!utils.isValidNumber($scope.goal_amount)) {
                utils.setValidationError("El campo cantidad a reunir no es una cantidad valida");
                return false;
            } else if ($scope.goal_amount < 50 || $scope.goal_amount > 400000) {
                utils.setValidationError("La cantidad a reunir debe ser entre $50.00 y $400,000 MXN");
                return false;
            } else if (utils.isNullOrEmpty($scope.end_date)) {
                utils.setValidationError("El campo fecha límite es requerido");
                return false;
            } else if (!utils.isValidDate($scope.end_date)) {
                utils.setValidationError("El campo fecha límite es no tiene un formato válido yyyy-mm-dd");
                return false;
            }
            return true;
        };

        $scope.changeParticipation = function()
        {
            var options = document.getElementsByClassName('radio-option');
            for(var i = 0; i < options.length; i++ ){
                var tmp_element = options[i].value.split('|');
                if(tmp_element[2] == 'Y') {
                    var element = document.getElementById('txt-option-'+tmp_element[1]);
                    if ($scope.participation != options[i].value)
                        element.value="50";
                }
            }
        };

        $scope.changePrivacy = function(){};

        $scope.uploadImage = function (element, creation, callback) {
            if ($scope.moneybox_id && element.files.length > 0) {
                var file = element.files[0];
                var imageType = /image.*/;
                if (true || file.type.match(imageType)) {

                    var form = new FormData();
                    form.append('api-key', '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC');
                    form.append('id', $scope.moneybox_id);
                    form.append('file', file);

                    $scope.utils.showLoader();
                    Moneybox.upload(form).success(function (response) {

                        if (response.success) {
                            console.log("exito al cargar la imagen");
                            callback(response);
                            /*$scope.utils.hideLoader();
                            var reader = new FileReader();
                            reader.onload = function () {
                                document.querySelector('#moneybox-image').src = (reader.result);
                                $scope.utils.setAlertTitle("Coperacha - Alerta");
                                document.getElementById('alert-content').innerHTML="" +
                                "<p>Imágen actualizada correctamente.<p>";
                                $scope.utils.showAlert();
                            };
                            reader.readAsDataURL(file);*/
                        }

                    }).error(function(response){
                        callback(response);
                        //$('body').html(response);
                    });

                } else {
                    console.log("Archivo no soportado!");
                }
            }
        };

        $scope.fileChanged = function(element)
        {
            var imageType = /image.*/;
            var file = element.files[0];
            if($scope.fileExist()){
                if(!file.type.match(imageType)){
                    alert("archivo no soportado");
                }
            }
        };

        $scope.fileExist = function()
        {
            return document.getElementById("file").files.length > 0;
        };

    }

    /**
     * Init the datepicker component
     */
    function initDatePicker(){
        // init date picker
        $( "#datepicker" ).datepicker({
            dateFormat: 'yy-mm-dd',
            dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
            dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
            monthNames: [ "Enero", "Febrero", "Marzo", "April", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            minDate: new Date()
        });
    }

})();