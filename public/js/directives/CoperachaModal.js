(function(){

    angular
        .module('CoperachaModalDirective', [])
        .directive('coperachaModal', function () {
            return {
                templateUrl: '/templates/login-popup.html',
                restrict: 'E',
                link : function postLink(scope, element, attrs) {

                    scope.showModal = function(path)
                    {
                        if (path != undefined) {
                            element.find('.dialog-view').attr('data-redirect-to', path);
                        }
                        element.css({'display':'block'});
                    };

                    scope.hideModal = function()
                    {
                        element.css({'display':'none'});
                        element.attr('data-redirect-to', '');
                    };

                    // close Popup
                    element.find('.close').click(function(){
                        scope.hideModal();
                    });

                }
            };
        });

})();