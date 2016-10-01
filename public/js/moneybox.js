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
                _this.btnRemove_Click();
            });
        },

        btnRemove_Click: function () {
            this.divLoading.removeClass('hidden');
            var _this = this;
            var utils = new Utils();

            $.post('/sendremove', {
                url: this.url
            }).then(function (response) {
                _this.divLoading.addClass('hidden');

                if (response.data.active == 0) {
                    document.getElementById('small-alert-content').innerHTML = "<p>Alcancía eliminada correctamente<p>";
                    utils.showAlert(true);
                    setTimeout(function() {
                        window.location.assign('/moneybox/dashboard');
                    }, 1000);
                }

            }, function () {
                console.error('La alcancía no se pudo eliminar, inténtelo más tarde.');
            });
        },

        btnThanks_Click: function () {
            this.divLoading.removeClass('hidden');
            var _this = this;

            $.post('/sendthanks', {
                url: this.url
            }).then(function (response) {

                var emails = response.data.join(',');
                var utils = new Utils();

                _this.divLoading.addClass('hidden');

                if (response.data.length > 0) {
                    setTimeout(function() {
                        document.getElementById('small-alert-content').innerHTML = "" +
                            "<p>Los mensajes fueron enviados exitosamente a: " + emails + "<p>";

                        utils.showAlert(true);
                    }, 375);
                }

            }, function () {
                console.error('El Mensaje no se pudo enviar, inténtelo más tarde.');
            });
        }
    };

    Moneybox.init();

})(jQuery);