/**
 * Created by daniel on 29/08/2016.
 */

var vm = new Vue({
    el: '#FormShare',
    data: {
        url: '',
        emails: '', //daniel_pro4@hotmail.com;sanchezz985@gmail.com
        loading: false,
        message: {
            status: 'success',
            text: ''
        }
    },
    
    watch: {
        emails: function (data) {
            this.emails = data.replace(/\s+/g, '');
        }
    },

    ready: function () {
        this.url = (this.$el.dataset.url);
    },

    methods: {
        onSubmit: function (e) {
            var utils = new Utils();
            var validation = true;

            if (utils.isNullOrEmpty(this.emails)) {
                utils.setValidationError("Debes ingresar al menos un correo electrónico.");
                validation = false;
            }

            if (!utils.isNullOrEmpty(this.emails)) {
                var emails = this.emails.split(';');
                var count  = 0;
                for (var i = 0; i < emails.length; i++ ) {

                    if (emails[i] == "") continue;

                    // Empty white space
                    var email = emails[i].trim();

                    if(!utils.isValidEmail(email)) {
                        utils.setValidationError("Uno de los correos electrónicos no tiene el formato correcto.");
                        validation = false;
                    } else {
                        count++;
                    }
                }
                if (count <= 0) {
                    utils.setValidationError("El formato de los correos es incorrecto");
                    validation = false;
                }
            }

            if (!validation) return;

            this.loading = true;
            this.$http.post('/sendinvitation', {
                url: this.url,
                emails: this.emails
            }).then(function(response, status, request) {
                if (response.status == 200) {
                    if (response.data.success == true) {
                        this.message.text = 'Mensajes enviados correctamente';
                        this.emails = '';
                        this.loading = false;
                        setTimeout(function () {
                            this.message.text = '';
                        }.bind(this), 3000);
                    } else {
                        this.message.text = 'Ocurrio una problema al entregar los mensajes, por favor inténtelo más tarde';
                        this.emails = '';
                        this.loading = false;
                        setTimeout(function () {
                            this.message.text = '';
                        }.bind(this), 3000);
                    }
                } else {
                    console.log(response);
                }
            }, function() {
                this.message.text = 'El Mensaje no se pudo enviar, inténtelo más tarde.';
            });
        }
    }
});