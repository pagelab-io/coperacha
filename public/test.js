(function(){

    var app = angular.module('testApp', []);

    app.controller('TestController', ['$http','$log', function($http, $log){

        var testApp = this;

        // url local
        var url = "/auth/login";

        // var productiva
        //var url = "http://www.coperacha.pagelab.io/auth/login";

        // se arma JSON con datos de entrada
        var request = {};

        // se manda a llamar a la function
        console.log(url);
        $http.post(url, request).success(function(response){

            if (response.status == 0) {
                $log.info(response.status);
                $log.info(response.description);
                $log.info(response.data);
            }else {
                $log.info(response.status);
                $log.info(response.description);
                $log.info(response.data);
            }

        }).error(function(){
            console.log("gdjhsjfd");
        });

    }]);

})();