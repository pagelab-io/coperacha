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
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'password' => 'required',
            'isFB' => 'required|digits:1|number_between:0,1'
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