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
            accountType:    '',
            moneybox_id:    0,
            name:           '',
            bank_name:      '',
            bank_address:   '',
            clabe:          '',
            account:        '',
            comments:       '',
            cellphone:      '',
            areacode:       '52'
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
            if(!this.validateRequestForm()) return;
            var utils = new Utils();
            this.order.moneybox_id = this.$el.dataset.moneybox_id;

            var _this = this;
            var path = base + '/sendrequest';
            var form = new FormData();

            if (this.file) {
                form.append('file', this.file);
            }

            for (var field in this.order) {
                form.append(field, this.order[field]);
            }

            this.loading = true;

            this.$http.post(path, form).then(function (response) {
                if (response.status == 200) {
                    if (response.data.success == true) {
                        _this.loading = false;
                        document.getElementById('small-alert-content').innerHTML= "" +
                        "<p>Información enviada correctamente, <br>" +
                        "un administrador de coperacha se pondrá en contacto contigo a la brevedad para dar seguimiento a tu retiro.<p>";
                        utils.showAlert(true);
                        for (var field in _this.order) {
                            _this.order[field] = '';
                        }
                        // default values
                        _this.onAccountTypeChange();
                        _this.order.areacode = '52'
                    }
                } else {
                    console.log(response);
                }
            }, function (error) {
                $('body').html(error.body);
            });
        },

        validateRequestForm: function()
        {
            var utils = new Utils();

            if (utils.isNullOrEmpty(this.order.accountType)) {
                utils.setValidationError("Selecciona un tipo de cuenta.");
                return false;
            } else if (utils.isNullOrEmpty(this.order.name)) {
                utils.setValidationError("Ingresa el nombre del beneficiario.");
                return false;
            } else if (utils.isNullOrEmpty(this.order.bank_name)) {
                utils.setValidationError("Selecciona un banco.");
                return false;
            } else if (utils.isNullOrEmpty(this.order.email)) {
                utils.setValidationError("Ingresa un correo electrónico.");
                return false;
            } else if (!utils.isValidEmail(this.order.email)) {
                utils.setValidationError("El correo electrónico ingresado no tiene un formato válido.");
                return false;
            } else if (!utils.isNullOrEmpty(this.order.accountType)) {
                switch(this.order.accountType) {
                    case "1":
                        if (utils.isNullOrEmpty(this.order.account)) {
                            utils.setValidationError("Ingresa el número de tu tarjeta destino.");
                            return false;
                        } else if (!utils.isValidNumber(this.order.account)) {
                            utils.setValidationError("El número de tu tarjeta debe ser númerico.");
                            return false;
                        }
                        break;
                    case "2":
                        if (utils.isNullOrEmpty(this.order.clabe)) {
                            utils.setValidationError("Ingresa tu número clabe.");
                            return false;
                        } else if (!utils.isValidNumber(this.order.clabe)) {
                            utils.setValidationError("El número clabe debe ser númerico.");
                            return false;
                        }
                        break;
                    case "3":
                        if (utils.isNullOrEmpty(this.order.cellphone)) {
                            utils.setValidationError("Ingresa tu número de celular.");
                            return false;
                        } else if (!utils.isValidNumber(this.order.cellphone)) {
                            utils.setValidationError("El número de celular debe ser numérico.");
                            return false;
                        } else if (!utils.validLength(this.order.cellphone, 10)) {
                            utils.setValidationError("El número de celular debe tener 10 digitos.");
                            return false;
                        }
                        break;
                    default: console.log("..."); break;

                }
            }
            return true;
        },

        /**
         * accountType catalog:
         * 1 - tarjeta destino
         * 2 - clabe interbancaria
         * 3 - celular
         */
        onAccountTypeChange: function()
        {
            var type1 = document.getElementById("type1");
            var type2 = document.getElementById("type2");
            var type3 = document.getElementById("type3");

            switch(this.order.accountType) {
                case "1":
                    console.log(this.order.accountType);
                    type1.style.display="block";
                    type2.style.display="none";
                    type3.style.display="none";
                    break;
                case "2":
                    type1.style.display="none";
                    type2.style.display="block";
                    type3.style.display="none";
                    break;
                case "3":
                    type1.style.display="none";
                    type2.style.display="none";
                    type3.style.display="block";
                    break;
                default:
                    type1.style.display="none";
                    type2.style.display="none";
                    type3.style.display="none";
                    break;
            }
        }
    }
});

window.RequestViewModel = vm;