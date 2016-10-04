(function(){

    angular
        .module('LoginModalDirective', [])
        .directive('loginModal', function () {
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

                    document.addEventListener('keyup', function(e){
                        if(e.keyCode == 27){
                            var alert = document.getElementsByClassName('alert-modal')[0];
                            if(alert.style.display="block"){
                                alert.style.display="none";
                            }else{
                                scope.hideModal();
                                scope.$digest();
                            }
                        }
                    });

                    document.getElementsByClassName('close-popup')[0].addEventListener('click', function(e){
                        scope.hideModal();
                        scope.$digest();
                    });
                },
                templateUrl: '/templates/login-popup.html'
            };
        });

})();