<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/07/2016
 * Time: 11:11 PM
 */

namespace App\Validations;


class ParticipantValidation {

    // region attributes
    //endregion

    //region Static methods

    /**
     * Validation rules for moneybox creation
     *
     * @return array
     */
    static function rules()
    {
        return [
            'moneybox_id' => 'required|numeric',
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'settings' => 'required|json',
        ];
    }

    /**
     * Messages for register validations
     * @return array
     */
    static function messages()
    {
        return [];
    }

    //endregion

    //region Private methods
    //endregion

    //region Methods
    //endregion

} 