/**
 * Created by daniel on 03/09/2016.
 */

var $api = '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC';
var base = window.location.origin;

var vm = new Vue({
    el: '#RequestMoneyView',

    data: {
        loading: false,
        order: {
            moneybox_id:    0,
            name:           '',
            bank_name:      '',
            bank_address:   '',
            clabe:          '',
            account:        '',
            comments:       ''
        },
        file: '',
        message: {
            text: '',
            status: ''
        }
    },

    /**
     * Computed properties
     */
    computed: {

    },

    /**
     * Occurs when the document was created
     */
    created: function () {
        this.loading = true;
    },

    /**
     * Occurs when the document is mounted
     */
    ready: function () {
        this.loading = false;
    },

    /**
     * Global methods
     */
    methods: {
        /**
         *
         * @param e
         */
        onFileChange: function(e) {
            if (e.target.files.length > 0) {
                this.file = e.target.files[0];
            }
        },

        /**
         * Submit the request form
         *
         * @param id
         */
        onSubmit: function () {
            this.order.moneybox_id = this.$el.dataset.moneybox_id;

            var _this = this;
            var path = base + '/sendrequest';
            var form = new FormData();
            form.append('file', this.file);

            for (var field in this.order) {
                form.append(field, this.order[field]);
            }

            this.loading = true;

            this.$http.post(path, form).then(function (response) {

                if (response.status == 200) {
                    _this.message.text = 'Información enviada correctamente, ¡Gracias!';
                    _this.loading = false;

                    for (var field in _this.order) {
                        _this.order[field] = '';
                    }

                    setTimeout(function () {
                        $('#file').val('');
                        _this.message.text = '';
                    }, 3 * 1000);

                } else {
                    console.log(response);
                }
            }, function (error) {
                $('body').html(error.body);
            });
        }
    }
});

window.RequestViewModel = vm;