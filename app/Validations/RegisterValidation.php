<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 22/06/2016
 * Time: 09:30 PM
 */

namespace App\Validations;

class RegisterValidation{

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
            //required
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required_if:isFB,0',
            'facebook_uid' => 'required_if:isFB,1',
            'isFB' => 'required|digits:1|number_between:0,1',
            // optionals
            'birthday' => 'date_format:"Y-m-d"'
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