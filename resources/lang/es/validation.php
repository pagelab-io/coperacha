<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'El campo :attribute debe ser aceptado',
    'active_url'           => 'El campo :attribute no es una URL válida',
    'after'                => 'La fecha :attribute debe ser una fecha despues de :date',
    'alpha'                => 'El campo :attribute solo debe contener letras',
    'alpha_dash'           => 'El campo :attribute solo debe contener letras, números y guiones',
    'alpha_num'            => 'El campo :attribute solo debe contener letras y números',
    'array'                => 'El campo :attribute debe ser un array',
    'before'               => 'El campo :attribute debe ser una fecha antes de :date',
    'between'              => [
        'numeric' => 'El campo :attribute debe estar entre :min y :max',
        'file'    => 'El campo :attribute debe pesar entre :min y :max kilobytes',
        'string'  => 'El campo :attribute debe tener entre :min y :max caractéres',
        'array'   => 'El campo :attribute debe tener entre :min y :max items',
    ],
    'boolean'              => 'El campo :attribute debe ser true o false.',
    'confirmed'            => 'El campo :attribute no coincide',
    'date'                 => 'El campo :attribute no es una fecha válida',
    'date_format'          => 'El campo :attribute no coincide con el formato :format',
    'different'            => 'El campo :attribute y :other deben ser diferentes',
    'digits'               => 'El campo :attribute debe tener :digits digitos',
    'digits_between'       => 'El campo :attribute debe estar entre :min y :max digitos',
    'distinct'             => 'El campo :attribute tiene un valor duplicado',
    'email'                => 'El campo :attribute debe ser una dirección de correo válida',
    'exists'               => 'El campo :attribute es inválido',
    'filled'               => 'El campo :attribute es requerido',
    'image'                => 'El campo :attribute debe ser una imagen',
    'in'                   => 'El campo :attribute es inválido',
    'in_array'             => 'El campo :attribute no existe en :other.',
    'integer'              => 'El campo :attribute debe ser un entero',
    'ip'                   => 'El campo :attribute debe ser una IP válida',
    'json'                 => 'El campo :attribute debe ser una cadena JSON válida',
    'max'                  => [
        'numeric' => 'El campo :attribute no debe ser mayor a :max.',
        'file'    => 'El campo :attribute no debe pesar mas de :max kilobytes.',
        'string'  => 'El campo :attribute no debe contener mas de :max caracteres',
        'array'   => 'El campo :attribute no debe contener mas de :max items',
    ],
    'mimes'                => 'El campo :attribute debe ser un archivo de tipo: :values.',
    'min'                  => [
        'numeric' => 'El campo :attribute debe ser al menos :min',
        'file'    => 'El campo :attribute debe pesar al menos :min kilobytes',
        'string'  => 'El campo :attribute debe tener al menos :min caracteres',
        'array'   => 'El campo :attribute debe contener al menos :min items',
    ],
    'not_in'               => 'El campo seleccionado :attribute es inválido',
    'numeric'              => 'El campo :attribute debe ser numérico',
    'present'              => 'El campo :attribute debe estar presente',
    'regex'                => 'El formato del campo :attribute es inválido',
    'required'             => 'EL campo :attribute es requerido.',
    'required_if'          => 'El campo :attribute es requerido cuando :other es :value.',
    'required_unless'      => 'El campo :attribute es requerido a no ser que :other este en :values.',
    'required_with'        => 'El campo :attribute es requerido cuando :values esta presente',
    'required_with_all'    => 'El campo :attribute es requerido cuando :values esta presente.',
    'required_without'     => 'El campo :attribute es requerido cuando :values no esta presente',
    'required_without_all' => 'El campo :attribute es requerido cuando ninguno de los siguientes valores: :values estan presentes',
    'same'                 => 'El campo :attribute y :other deben coincidir',
    'size'                 => [
        'numeric' => 'El campo :attribute debe tener un tamaño de :size.',
        'file'    => 'El campo :attribute debe tener un peso de :size kilobytes.',
        'string'  => 'El campo :attribute debe tener :size caracteres',
        'array'   => 'El campo :attribute debe contener :size items',
    ],
    'string'               => 'El campo :attribute debe ser una cadena',
    'timezone'             => 'El campo :attribute debe ser una zona válida',
    'unique'               => 'El campo :attribute ya esta registrado',
    'url'                  => 'El campo :attribute tiene un formato incorrecto',
    'number_between'       => "The :attribute debe ser un número entre :min y :max",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
