/**
 * Created by daniel on 13/08/2016.
 */

var vm = new Vue({
    el: '#contact-form',
    data: {

        contact: {
            name: 'Daniel Pérez',
            email: 'Daniel_pro4@hotmail.com',
            content: 'sending text form contact'
        },

        sending: false,
        sendText: 'Enviar',
        message: ''

    },

    computed: {
        isValid: function () {
            return this.contact.name != '' && this.contact.email != ''
        }
    },

    methods: {
        onSubmit: function () {

            var _this = this;
            this.sendText = 'Enviando...';

            this.$http.post('/sendmail', this.contact).then(function(response, status, request) {

                if (response.status == 200) {
                    var res = JSON.parse(response.body);
                    if (res.success == true) {
                        this.sending = true;
                        this.message = 'Mensaje enviado correctamente';
                        this.contact.name = '';
                        this.contact.email = '';
                        this.contact.content = '';
                        this.sendText = 'Enviar';

                        setTimeout(function () {
                            _this.sending = false;
                        }, 3000);
                    }
                }

            }, function() {
                console.log('failed');
                this.message = 'El Mensaje no se pudo enviar, inténtelo más tarde.';
            });
        }
    }

});

