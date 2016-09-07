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
        $scope.privacy = '';
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
                }
            }
        };

        $scope.step2Click = function()
        {
            if($scope.step2.style.display != 'none') {
                $scope.step2.style.display = "none";
                $scope.step1.style.display = "block";
            }
        };

        $scope.createMoneybox = function()
        {
            if (!$scope.validateStep2())
                return;

            // build the settings object
            var participation = $scope.participation.split('|');
            var privacy = $scope.privacy.split('|');
            var privacyValue = 1;
            var participationValue = 1;

            if (participation[2] == 'Y') {
                participationValue = document.getElementById('txt-option-'+participation[1]).value;
            }

            if (privacy[2] == 'Y') {
                privacyValue = document.getElementById('txt-option-'+privacy[1]).value;
            }

            if ($scope.amount != 0 && $scope.privacy != 0)
            {
                $scope.settings.push({'member_setting_id':$scope.amount_id, 'setting_id':participation[0],'option_id':participation[1],'value':participationValue});
                $scope.settings.push({'member_setting_id':$scope.privacy_id,'setting_id':privacy[0],'option_id':privacy[1],'value':privacyValue});
            } else {
                $scope.settings.push({'setting_id':participation[0],'option_id':participation[1],'value':participationValue});
                $scope.settings.push({'setting_id':privacy[0],'option_id':privacy[1],'value':privacyValue});
            }

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

            if ($scope.moneybox_id != 0) {
                // update
                $scope.request['method'] = 'updateMoneybox';
                $scope.request['moneybox_id'] = $scope.moneybox_id;
                $scope.utils.showLoader();
                console.log($scope.request);
                Moneybox.update($scope.request)
                    .success(function(response){
                        if (response.status == 200) {
                            window.location = '/moneybox/detail/'+response.data.url;
                        } else {
                            $scope.utils.hideLoader();
                            $scope.utils.setAlertTitle("Coperacha - Alerta");
                            document.getElementById('alert-content').innerHTML="" +
                            "<p>Ocurrio una incidencia al actualizar la alcancía, intentalo nuevamente por favor<p>";
                            $scope.utils.showAlert();
                        }
                    })
                    .error(function(response){
                        $scope.utils.hideLoader();
                        console.log(response);
                    });
            } else {
                // creation
                $scope.request['method'] = 'createMoneybox';
                $scope.utils.showLoader();
                console.log($scope.request);
                Moneybox.create($scope.request)
                    .success(function(response){
                        if (response.status == 200) {
                            window.location = '/moneybox/detail/'+response.data.url;
                        } else {
                            $scope.utils.hideLoader();
                            $scope.utils.setAlertTitle("Coperacha - Alerta");
                            document.getElementById('alert-content').innerHTML="" +
                            "<p>Ocurrio una incidencia al crear la alcancía, intentalo nuevamente por favor<p>";
                            $scope.utils.showAlert();
                        }
                    })
                .error(function(response){
                    $scope.utils.hideLoader();
                    console.log(response);
                });
            }

        };

        $scope.validateStep2 = function()
        {
            var utils = $scope.utils;

            if (utils.isNullOrEmpty($scope.participation)) {
                utils.setValidationError("Selecciona un tipo de monto");
                return false;
            }else if (utils.isNullOrEmpty($scope.privacy)) {
                utils.setValidationError("Selecciona una opcion de privacidad");
                return false;
            }

            return true;
        };

        $scope.validateStep1 = function()
        {
            var utils = $scope.utils;
            if (utils.isNullOrEmpty($scope.category_id)) {
                utils.setValidationError("El campo Categoría es requerido");
                return false;
            } else if (utils.isNullOrEmpty($scope.name)) {
                utils.setValidationError("El campo Nombre es requerido");
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
                        element.value="0";
                }
            }
        };

        $scope.changePrivacy = function()
        {
            console.log($scope.privacy);
        };

        $scope.fileChanged = function (element) {
            if ($scope.moneybox_id && element.files.length > 0) {
                var file = element.files[0];
                var imageType = /image.*/;
                if (file.type.match(imageType)) {

                    var form = new FormData();
                    form.append('api-key', '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC');
                    form.append('id', $scope.moneybox_id);
                    form.append('file', file);

                    Moneybox.upload(form).success(function (r) {
                        console.log(r);

                        var reader = new FileReader();
                        reader.onload = function () {
                            document.querySelector('#moneybox-image').src = (reader.result);
                        };
                        reader.readAsDataURL(file);

                    }).error(function(response){
                        $('body').html(response);
                    });

                } else {
                    console.log("File not supported!");
                }
            }
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