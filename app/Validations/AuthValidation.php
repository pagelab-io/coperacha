<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/06/2016
 * Time: 05:18 PM
 */

namespace App\Validations;


class AuthValidation {

    // region attributes
    //endregion

    //region Static methods

    /**
     * Rules for create setting
     *
     * @return array
     */
    static function password_recovery_rules()
    {
        return [
            'email' => 'required|email',
        ];
    }

    /**
     * Messages for create setting
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