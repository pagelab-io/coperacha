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
            this.loading = true;

            this.$http.post('/sendmail', this.contact).then(function(response, status, request) {

                if (response.status == 200) {

                    if (response.data.success == true) {

                        for (var i in _this.contact) {
                            _this.contact[i] = '';
                        }

                        _this.loading = false;
                        _this.message.text = 'Mensaje enviado correctamente';

                        setTimeout(function () {
                            _this.message.text = ''
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

