/**
 * Created by daniel on 13/08/2016.
 */

var vm = new Vue({
    el: '#contact-form',
    data: {

        contact: {
            name: '',
            email: '',
            content: ''
        }
    },

    methods: {
        onSubmit: function () {

            var data = this.contact;

            this.$http.post('/sendmail', data).then(function(response, status, request) {

                if (response.status == 200) {
                    console.log(response.body);
                }

            }, function() {
                console.log('failed');
            });
        }
    }

});

