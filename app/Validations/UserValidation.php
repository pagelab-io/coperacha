<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/06/2016
 * Time: 05:18 PM
 */

namespace App\Validations;


class UserValidation {

    // region attributes
    //endregion

    //region Static methods

    /**
     * Rules for register fields
     *
     * @return array
     */
    static function profile_rules()
    {
        return [
            'user_id' => 'required|numeric',
        ];
    }

    static function update_rules()
    {
        return [
            'user_id' => 'required|numeric',
            'person_id' => 'required|numeric',
            'name' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email',
            'birthday' => 'required|date_format:"Y-m-d"',
            'gender' => 'required', // TODO -  verificar que sea un enum valido
            'city' => 'required|string',
            'country' => 'required|string',
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