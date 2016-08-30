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
        sending: false,
        sended: false,
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
            this.sending = true;

            this.$http.post('/sendmail', this.contact).then(function(response, status, request) {

                if (response.status == 200) {
                    var res = JSON.parse(response.body);
                    if (res.success == true) {

                        this.message = 'Mensaje enviado correctamente';
                        this.contact.name = '';
                        this.contact.email = '';
                        this.contact.content = '';
                        this.sendText = 'Enviar';

                        _this.sended = true;
                        _this.sending = false;

                        setTimeout(function () {
                            _this.sended = false;
                        }, 3 * 1000);
                    }
                }

            }, function() {
                console.log('failed');
                this.message = 'El Mensaje no se pudo enviar, inténtelo más tarde.';
            });
        }
    }

});

