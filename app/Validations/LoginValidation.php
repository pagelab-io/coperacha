<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 22/06/2016
 * Time: 11:10 PM
 */

namespace App\Validations;


class LoginValidation {

    // region attributes
    //endregion

    //region Static methods

    /**
     * Rules for register fields
     *
     * @return array
     */
    static function rules()
    {
        return [
            'email' => 'required|email',
            'isFB' => 'required|digits:1|number_between:0,1',
            'password' => 'required_if:isFB,0',
            'facebook_uid' => 'required_if:isFB,1',
            'method' => 'required|string'
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