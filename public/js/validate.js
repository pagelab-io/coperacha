var ValidateMForm = {

    /**
     * @type {Object}
     */
    handlers: {},

    /**
     * @type string[]
     */
    inputs: [
        'select[name=categories]',
        'input[name=beneficiario]',
        'input[name=alcancia]'
    ],

    mode: '',

    init: function () {

        ValidateMForm.$form = $('.form-create-moneybox');
        ValidateMForm.mode = $('.form-create-moneybox').data('mode');

        $('#moneybox-categories').change(function(){
            var url = '';
            switch ($(this).val()) {
                case "1": url='url(/images/fondo_1.jpg) 0 -255px no-repeat'; break;
                case "2": url='url(/images/fondo_2.png) 0 -255px no-repeat'; break;
                case "3": url='url(/images/fondo_3.jpg) 0 -255px no-repeat'; break;
                case "4": url='url(/images/fondo_4.jpg) 0 -255px no-repeat'; break;
                case "5": url='url(/images/fondo_5.jpg) 0 -255px no-repeat'; break;
                case "6": url='url(/images/fondo_6.jpg) 0 -255px no-repeat'; break;
                case "8": url='url(/images/fondo_8.jpg) 0 -255px no-repeat'; break;
                case "9": url='url(/images/fondo_9.jpg) 0 -255px no-repeat'; break;
                default: url='url(/images/fondo_2.png) 0 -255px no-repeat'; break;
            }
            console.log(url);
            $('.img-category').css({
                'background': url,
                'background-size': 'cover'
            });

        });

        ValidateMForm.getInputs(ValidateMForm.$form).on('change', ValidateMForm.onInputChange);

        // Attach submit handler.
        ValidateMForm.$form.on('submit', ValidateMForm.onSubmit);
    },

    /**
     * Add new form to validate.
     * @param {jQuery} $form
     */
    addForm: function($form) {
        if ($form instanceof jQuery) {

            $form.each(function() {
                var $f = $(this);

                // Attach change handler.
                ValidateMForm.getInputs($f).on('change', ValidateMForm.onInputChange);

                // Attach submit handler.
                $f.on('submit', ValidateMForm.onSubmit);
            });
        }
    },

    /**
     * Make an ajax request to send contact form.
     * @param {Object} data
     * @param {Object} handlers
     */
    ajaxRequest: function(data, handlers) {

        var Token = document.querySelector('meta[name=token]').getAttribute('content');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': Token
            }
        });

        $.ajax({
            data: data,
            type: 'POST',
            url: '/api/v1/mailcontact',
            beforeSend: handlers.beforeSend,
            error     : handlers.error,
            success   : handlers.success
        });
    },

    /**
     * Get form inputs.
     * @param {jQuery} $form
     * @returns {jQuery} matched inputs.
     */
    getInputs: function($form) {
        return $form.find(ValidateMForm.inputs.join());
    },

    /**
     * Get validity of a form input.
     * @param {jQuery} $input
     * @returns {boolean} validity
     */
    isInputValid: function($input) {
        var type  = $input.attr('name'),
            value = $input.val();

        if (!value) return false;

        switch (type) {
            case 'beneficiario':
            case 'alcancia':
                return value.length > 3;
            case 'telefono':
                return value.replace(/[^0-9]/g, '').length === 10;
            case 'email':
                var pattern = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
                return pattern.test(value);
            default:
                return true;
        }
    },

    /**
     * Toggle error mark in an input.
     */
    onInputChange: function() {
        var $input = $(this);

        // Retrieve error element if exists.
        var $errorElement = $input.data('error-element');

        if (ValidateMForm.isInputValid($input)) {

            if ($errorElement) {
                // Disappears and remove error element from DOM.
                $errorElement.fadeOut(function() { $errorElement.remove(); });

                // Set as null data of input.
                $input.data('error-element', null);

                // Set default color of input.
                $input.css('border-color', '#ddd');
            }

        } else {

            if (!$errorElement) {
                var clue = $input.data('clue') || 'Invalid';

                // Create error element and set.
                $errorElement = $('<span>').addClass('error-message');

                $errorElement
                    .insertBefore($input)
                    .css({'display': 'none', 'color': '#f00'})
                    .text(clue)
                    .fadeIn();

                $input.data('error-element', $errorElement);
            }

            $input.css('border-color', '#f00');
        }
    },

    /**
     * Submit form handler.
     * @param {Object} evt
     */
    onSubmit: function(evt) {
        evt.preventDefault();

        var $form = $(this),
            valid = true;

        // Validate inputs before submit.
        ValidateMForm.getInputs($form).each(function() {
            var $input = $(this);
            if (!ValidateMForm.isInputValid($input)) {
                $input.trigger('change');
                valid = false;
            }
        });

        // If no valid show alert with error.
        if (!valid) {
            console.log('Hay campos inválidos, por favor revisa las indicaciones en rojo.');
        } else {

            var nombre_creador = $('#nombre_creador').val();
            var nombre_alcancia = $('#nombre_alcancia').val();
            var category = $('#moneybox-categories').val();

            if (ValidateMForm.mode == 'guest') {
                var login_modal = $("#login-modal");
                setTimeout(function () {
                    var path = "/moneybox/create/create/" + nombre_alcancia + "/" + nombre_creador + "/" + category;
                    login_modal.attr('data-redirect-to', path);

                    // TODO
                    // Checar si funciona de esta manera porque no supe como ejecutar
                    // la directiva desde código

                    $('#login-modal-coperacha').fadeIn();
                }, 500);
            } else {
                window.location = "/moneybox/create/create/" + nombre_alcancia + "/" + nombre_creador + "/" + category;
            }
        }

    },

    /**
     * Reset form inputs.
     * @param {jQuery} $form
     */
    resetFormInputs: function($form) {
        ValidateMForm.getInputs($form).val('');
    }
};


$(ValidateMForm.init());