/**
 * Created by daniel on 01/10/2016.
 */
(function ($) {
    var Moneybox = {

        init: function () {
            this.divLoading = $('#divLoading');
            this.bindEvents();
        },

        bindEvents: function () {
            var _this = this;

            $('.btn-thanks').on('click', function (evt) {
                if (evt.preventDefault) {
                    evt.preventDefault();
                }
                _this.url = this.dataset.url;
                _this.btnThanks_Click();
            });

            $('.btn-remove').on('click', function (evt) {
                if (evt.preventDefault) {
                    evt.preventDefault();
                }
                _this.url = this.dataset.url;
                _this.name = this.dataset.name;
                _this.btnRemove_Click();
            });
        },

        btnRemove_Click: function () {
            var _this = this;
            var utils = new Utils();
            var onTrash = function () {
                _this.divLoading.removeClass('hidden');

                $.post('/sendremove', {
                    url: _this.url
                }).then(function (response) {
                    _this.divLoading.addClass('hidden');

                    if (response.data.active == 0) {
                        document.getElementById('small-alert-content').innerHTML = "<p>Alcancía eliminada correctamente<p>";
                        utils.showAlert(true);
                        setTimeout(function () {
                            window.location.assign('/moneybox/dashboard');
                        }, 1000);
                    }

                }, function () {
                    console.error('La alcancía no se pudo eliminar, inténtelo más tarde.');
                });
            };

            bootbox.confirm({
                title: "Eliminar alcancía",
                message: "¿Quieres eliminar la alcancía <strong>" + _this.name + "</strong>? Esta operación no se puede deshacer.",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancelar'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> Aceptar'
                    }
                },
                callback: function (result) {
                    if (result == true) {
                        onTrash();
                    }
                }
            });

        },

        btnThanks_Click: function () {
            this.divLoading.removeClass('hidden');
            var _this = this;

            var onTanks = function (url) {
                $.post('/sendthanks', {
                    url: url
                }).then(function (response) {

                    var utils = new Utils();
                    _this.divLoading.addClass('hidden');
                    if (response.data.length > 0) {
                        setTimeout(function () {
                            var emails = "";
                            for(var i = 0; i < response.data.length; i++) {
                                emails += "<p>"+response.data[i]+"</p>";
                            }
                            document.getElementById('small-alert-content').innerHTML = "" +
                                "<p>Los mensajes fueron enviados exitosamente a: <p>"+emails;
                            utils.showAlert(true);
                        }, 100);
                    }

                }, function () {
                    console.error('El Mensaje no se pudo enviar, inténtelo más tarde.');
                });
            };

            // Do thanks
            onTanks(this.url);
        }
    };

    Moneybox.init();

})(jQuery);