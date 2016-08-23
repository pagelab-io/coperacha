/**
 * Created by daniel on 20/08/2016.
 */

var $api = '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC';
var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
var base = 'http://coperacha.pagelab.io';

var vm = new Vue({
    el: '#ProfileView',

    data: {
        userid: 0,
        user: {
            person_id: 0,
            email: '',
            password: '',
            username: '',
            tacking: 0
        },
        person: {
            name: '',
            lastname: '',
            birthday: '',
            gender: '',
            phone: '',
            city:'',
            country:''
        },
        birthdayMonth: '',
        birthdayDay: 1,
        birthdayYear: 1,
        loading: true,
        message: {
            text: '',
            status: ''
        },

        tab: 'profile',
        isProfile: true,
        isPassword: false,
        isShare: false
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

    },

    /**
     * Occurs when the document is mounted
     */
    ready: function () {
        this.userid = (this.$el.dataset.userid);

        setTimeout(function () {
            this.onGetProfile(this.userid); // Called data
        }.bind(this), 300);

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
        },
        
        /**
         * Gets the profile by user id specified
         *
         * @param id
         */
        onGetProfile: function (id) {
            var path = base + '/api/v1/user/profile/'+ id + '?api-key=' + $api;
            this.$http.get(path).then(function (response) {

                var body = JSON.parse(response.body);

                if (body.data) {
                    this.user = body.data;
                    this.person = body.data.person;

                    var date = new Date(this.person.birthday);
                    this.birthdayMonth = date.getMonth() + 1;
                    this.birthdayDay = date.getDate() + 1;
                    this.birthdayYear = date.getFullYear();
                }

                this.loading = false;

            }, function (error) {
                console.error(error);
            });
        },

        /**
         * Handler the submit form
         */
        onSubmit: function () {
            this.loading = true;

            var _this = this;
            var path = base + '/api/v1/user/profile/?api-key='+$api;
            var data = {
                user_id: this.user.id,
                username: this.user.username,
                email: this.user.email
            };

            for (var field in this.person) {
                if (field == 'birthday') {
                    data['birthday'] = this.birthdayYear + '/' + this.birthdayMonth + '/' + this.birthdayDay;
                } else {
                    data[field] = this.person[field];
                }
            }
            
            this.$http.put(path, data, {
                method: 'PUT'
            }).then(function (response) {

                if (response.status === 200) {
                    this.loading = false;
                    this.onGetProfile(this.userid);

                    this.message = {
                        status: 'success',
                        text: 'Usuario actualizado correctamente.'
                    };

                    setTimeout(function () {
                        _this.message = {
                            status: '',
                            text: ''
                        };
                    }, 3 * 1000);
                    
                } else {
                    console.error(response);
                }

            }, function (error) {
                console.error(error);
            });
        }
    }
});


window.vm = vm;