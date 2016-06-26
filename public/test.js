(function(){

    var app = angular.module('testApp', []);

    app.controller('TestController', ['$http','$log', function($http, $log){

        // url local
        var url = "/moneybox/create";

        // var productiva
        //var url = "http://www.coperacha.pagelab.io/auth/login";

        var request = {
            'category_id' : 1,
            'name' : 'alcancia 1',
            'goal_amount' : '500.00',
            'owner' : 26,
            'end_date' : '0000-00-00',
            'method' : 'createMoneybox'
        };

        // se manda a llamar a la function
        console.log(url);
        $http.post(url, request).success(function(response){

            if (response.status == 200) {
                $log.info(response);
            }else {
                $log.info(response);
            }

        }).error(function(response){
            $log.info(response);
        });

    }]);

})();