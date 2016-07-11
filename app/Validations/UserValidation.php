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
        ];
    }

    static function change_password_rules()
    {
        return [
            'user_id' => 'required|numeric',
            'currentPassword' => 'required',
            'newPassword' => 'required',
            'passwordConfirm' => 'required',
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