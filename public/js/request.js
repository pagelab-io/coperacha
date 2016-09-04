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
            moneybox_id: 0,
            name: 'Daniel Pérez Atanacio',
            bank_name: 'santander',
            bank_address: 'Teziutlán Sur 23',
            clabe: '98289893 9329893',
            account: '98898943',
            comments: 'Solicito mi dinero por favor...',
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
                console.log(response.data);

                _this.message.text = 'Información enviada correctamente, Gracias.';
                _this.loading = false;

                for (var field in _this.order) {
                    _this.order[field] = '';
                }

                setTimeout(function () {
                    _this.message.text = '';
                }, 3*1000);
            }, function (error) {
                console.error(error);
                $('body').html(error.body);
            });
        }
    }
});

window.RequestViewModel = vm;