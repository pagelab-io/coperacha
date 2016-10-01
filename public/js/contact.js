/**
 * Created by daniel on 13/08/2016.
 * 
 * MV*
 * MVVM
 */

var vm = new Vue({
    el: '#contact-form',
    data: {
        contact: {
            name: '',
            email: '',
            content: ''
        },
        loading: false,
        message: {
            status: '',
            text: ''
        }
    },

    computed: {
        isValid: function () {
            return this.contact.name != '' && this.contact.email != ''
        }
    },

    methods: {
        onSubmit: function () {
            var _this = this;
            var utils = new Utils();

            if(!this.validate())
                return;
            this.loading = true;

            this.$http.post('/sendmail', this.contact).then(function(response, status, request) {

                if (response.status == 200) {

                    if (response.data.success == true) {
                        for (var i in _this.contact) {
                            _this.contact[i] = '';
                        }
                        _this.loading = false;
                        document.getElementById('small-alert-content').innerHTML="" +
                        "<p>Tu mensaje fue enviado exitosamente, pronto nos pondremos en contacto contigo.<p>";
                        utils.showAlert(true);
                    }
                }

            }, function() {
                _this.loading = false;
                utils.setAlertTitle("Coperacha - Alerta");
                document.getElementById('alert-content').innerHTML="" +
                "<p>Ocurrio un problema al enviar el correo electrónico, por favor intentalo más tarde.<p>";
                utils.showAlert();
            });
        },

        validate: function() {
            var utils = new Utils();

            if (utils.isNullOrEmpty(this.contact.name)) {
                utils.setValidationError("El nombre es requerido.");
                return false;
            } else if (utils.isNullOrEmpty(this.contact.email)) {
                utils.setValidationError("El correo electrónico es requerido.");
                return false;
            } else if (!utils.isValidEmail(this.contact.email)) {
                utils.setValidationError("El correo electrónico es inválido.");
                return false;
            } else if (utils.isNullOrEmpty(this.contact.content)) {
                utils.setValidationError("El mensaje es requerido.");
                return false;
            }

            return true;
        }
    }

});

