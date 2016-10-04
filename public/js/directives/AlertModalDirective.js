(function(){

    angular
        .module('AlertModalDirective', [])
        .directive('alertModal', function () {
            return {
                restrict: 'E',
                link : function postLink(scope, element, attrs){
                    scope.$watch('modalvisible', function(){
                        if(scope.modalvisible){
                            element.css({'display':'block'});
                        }else{
                            element.css({'display':'none'});
                        }
                    });
                },
                templateUrl: '/templates/alert-modal.html'
            };
        });

})();