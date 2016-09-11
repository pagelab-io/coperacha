/**
 * Created by daniel on 20/08/2016.
 */

var $api = '$2y$10$ScZUgkFzrMr9NM5qPzKag.4mLTW8ugSG/DtT6nerJb3W1v5sg6UBC';
var months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
var base = window.location.origin;

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
            city: '',
            country: ''
        },
        fbuser: {
            fb_uid: ''
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
        isShare: false,

        passwordData: {
            current: '',
            new: '',
            confirm: ''
        },

        tabSelected: null
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
            this.onGetProfile(this.userid); // Called data from server
        }.bind(this), 100);

    },

    /**
     * Global methods
     */
    methods: {
        
        onTabSelectedChanged: function(tab) {
            var currentSelectedIndex = $('.stage-item.selected').index();
            var _this = this;
            var tabs = $('.stage-element').children();

            this.tabSelected = $('.stage-item.' + tab);

            var onAnimated = function (orientation) {
                var currentTab = $(tabs[current]);

                if (orientation == 'next') {
                    if (current++ < tabs.length) {
                        setTimeout(function () {
                            currentTab.index() < _this.tabSelected.index() ? currentTab.addClass('completed') : currentTab.removeClass('completed');
                            currentTab.index() == _this.tabSelected.index() ? _this.tabSelected.addClass('selected') : currentTab.removeClass('selected');

                            onAnimated(orientation);
                        }, 100);

                    } else {
                        //console.log('completed all items, current:', current);
                    }
                } else {
                    if (current-- >= 0) {
                        setTimeout(function () {
                            currentTab.index() < _this.tabSelected.index() ? currentTab.addClass('completed') : currentTab.removeClass('completed');
                            currentTab.index() == _this.tabSelected.index() ? _this.tabSelected.addClass('selected') : currentTab.removeClass('selected');

                            onAnimated(orientation);
                        }, 100);
                    } else {
                        //console.log('completed all items, current:', current);
                    }
                }
            };

            // Next
            if (currentSelectedIndex < this.tabSelected.index()) {
                var current = 0;
                onAnimated('next');
            } else {
                var current = tabs.length - 1;
                onAnimated('prev');
            }
        },

        /**
         * Handler the submit form
         */
        onClickProfile: function (e) {
            this.onTabSelectedChanged('profile');
        },

        /**
         * Handler the submit form
         */
        onClickPassword: function (e) {
            this.onTabSelectedChanged('password');
        },

        /**
         * Handler the submit form
         */
        onClickShare: function (e) {
            this.onTabSelectedChanged('share');
        },
        
        /**
         * Gets the profile by user id specified
         *
         * @param id
         */
        onGetProfile: function (id) {
            var path = base + '/api/v1/user/profile/'+ id + '?api-key=' + $api;
            this.$http.get(path).then(function (response) {
                var body = response.data;
                
                if (body.data && body.status == 200) {
                    this.user = body.data;
                    this.person = body.data.person;
                    this.fbuser = body.data.fbuser;

                    var date = new Date(this.person.birthday);
                    this.birthdayMonth = date.getMonth() + 1;
                    this.birthdayDay = date.getDate() + 1;
                    this.birthdayYear = date.getFullYear();

                    window.user = this.user;
                }

                this.loading = false;

            }, function (error) {
                console.error(error);
            });
        },

        /**
         * Handler the submit form data of the user
         */
        onUpdateData: function () {
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
        },

        /**
         * Handler the submit form of the change password
         * @param e
         */
        onChangePassword: function (e) {
            this.loading = true;

            var _this = this;
            var path = base + '/api/v1/user/changePassword/?api-key='+$api;
            var data = {
                user_id: this.user.id,
                currentPassword: this.passwordData.current,
                newPassword: this.passwordData.new,
                passwordConfirm: this.passwordData.confirm,
                method: 'PUT'
            };

            this.$http.put(path, data, {
                method: 'PUT'
            }).then(function (response) {
                // console.log(response);
                if (response.status === 200) {
                    this.loading = false;

                    if (response.data.status == 1) {

                        this.message = {
                            status: 'success',
                            text: response.data.description
                        };

                        setTimeout(function () {
                            for (var field in _this.passwordData) {
                                _this.passwordData[field] = '';
                            }
                            _this.message = {
                                status: '',
                                text: ''
                            };
                        }, 3 * 1000);

                    } else {
                        this.message = {
                            status: 'danger',
                            text: response.data.description
                        };
                    }

                } else {
                    console.error(response);
                }

            }, function (error) {
                console.error(error);
            });
        }

    }
});

window.ProfileViewModel = vm;