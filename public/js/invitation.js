/**
 * Created by daniel on 29/08/2016.
 */

var vm = new Vue({
    el: '#FormShare',

    data: {
        emails: 'daniel_pro4@hotmail.com, sanchezz985@gmail.com',
        message: {
            status: 'success',
            text: ''
        }
    },

    methods: {
        onSubmit: function (e) {
            this.$http.post('/sendinvitation', {
                url: 'dbc0908372299d32dc812f99a15758a9',
                emails: this.emails
            }).then(function(response, status, request) {
                console.log(response);
                if (response.status == 200) {
                    var res = JSON.parse(response.body);
                    if (res.success == true) {
                        this.message.text = 'Mensaje enviado correctamente';
                       // this.emails = '';
                    }
                }

            }, function() {
                console.log('failed');
                this.message.text = 'El Mensaje no se pudo enviar, inténtelo más tarde.';
            });
        }
    }
});