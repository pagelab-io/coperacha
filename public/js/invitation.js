/**
 * Created by daniel on 29/08/2016.
 */

var vm = new Vue({
    el: '#FormShare',

    data: {
        url: '',
        emails: '', //daniel_pro4@hotmail.com, sanchezz985@gmail.com
        message: {
            status: 'success',
            text: ''
        }
    },

    ready: function () {
        this.url = (this.$el.dataset.url);
        this.btnSend = $('#btnSendInvitation');
    },

    methods: {
        onSubmit: function (e) {
            this.btnSend.text('Enviando').addClass('disabled');

            this.$http.post('/sendinvitation', {
                url: this.url,
                emails: this.emails
            }).then(function(response, status, request) {
                if (response.status == 200) {
                    var res = JSON.parse(response.body);
                    if (res.success == true) {
                        this.message.text = 'Mensaje enviado correctamente';
                        this.emails = '';

                        setTimeout(function () {
                            this.btnSend.text('Enviar invitaciones').removeClass('disabled');
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