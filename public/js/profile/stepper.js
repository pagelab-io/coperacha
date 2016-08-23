/**
 * Created by daniel on 21/08/2016.
 */

var vm = new Vue({
    el: '#StepItem',

    data: {
        userid: 0,
        tab: 'profile',
        isProfile: true,
        isPassword: false,
        isShare: false
    },

    computed: {

    },

    /**
     *
     */
    created: function () {

    },

    /**
     *
     */
    ready: function () {

    },

    methods: {

        activeTab: function (tab) {

            this.isProfile = false;
            this.isPassword = false;
            this.isShare = false;

            this.tab = tab;

            switch (tab) {
                case 'profile': this.isProfile = true; break;
                case 'password': this.isPassword = true; break;
                case 'share': this.isShare = true; break;
            }
        },

        /**
         * Handler the submit form
         */
        onClickProfile: function (e) {
            this.activeTab('profile');
        },

        /**
         * Handler the submit form
         */
        onClickPassword: function (e) {
            this.activeTab('password');
        },

        /**
         * Handler the submit form
         */
        onClickShare: function (e) {
            this.activeTab('share');
        }
    }
});
