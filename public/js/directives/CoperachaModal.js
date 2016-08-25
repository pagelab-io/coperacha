(function(){

    angular
        .module('CoperachaModalDirective', [])
        .directive('coperachaModal', function () {
            return {
                templateUrl: '/templates/login-popup.html',
                restrict: 'E',
                link : function postLink(scope, element, attrs){

                    scope.showModal = function()
                    {
                        element.css({'display':'block'});
                    };

                    scope.hideModal = function()
                    {
                        element.css({'display':'none'});
                    };

                    // close Popup
                    element.find('.close').click(function(){
                        scope.hideModal();
                    });

                }
            };
        });

})();