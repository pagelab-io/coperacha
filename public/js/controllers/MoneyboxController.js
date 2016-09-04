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
            if($scope.step1.style.display != 'none') {
                $scope.step1.style.display = "none";
                $scope.step2.style.display = "block";
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
            // build the settings object
            var participation = $scope.participation.split('|');
            var privacy = $scope.privacy.split('|');
            var privacyValue = 1;
            var participationValue = 1;

            if (participation[2] == 'Y') {
                participationValue = document.getElementById('txtOption-'+participation[1]).value;
            }

            if (privacy[2] == 'Y') {
                privacyValue = document.getElementById('txtOption-'+privacy[1]).value;
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
                            alert("Ocurrio un error al actualizar la alcancía, intentalo nuevamente porfavor");
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
                            alert("Ocurrio un error al generar la alcancía, intentalo nuevamente porfavor");
                        }
                    })
                .error(function(response){
                    $scope.utils.hideLoader();
                    console.log(response);
                });
            }

        }

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