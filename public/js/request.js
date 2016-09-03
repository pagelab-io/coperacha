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
            file: ''
        },
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
         * Submit the request form
         *
         * @param id
         */
        onSubmit: function () {

            this.order.moneybox_id = this.$el.dataset.moneybox_id;

            var path = base + '/sendrequest';
            var data = {
                moneyboxid: this.moneyboxid,
                order: this.order
            };

            this.$http.post(path, data).then(function (response) {
                console.log(response);
            }, function (error) {
                console.error(error);
                $('body').html(error.body);
            });
        }
    }
});

window.RequestViewModel = vm;