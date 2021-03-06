<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/06/2016
 * Time: 05:18 PM
 */

namespace App\Validations;


class SettingValidation {

    // region attributes
    //endregion

    //region Static methods

    /**
     * Rules for create setting
     *
     * @return array
     */
    static function rules()
    {
        return [
            'name' => 'required|string',
            'path' => 'required|string',
            'type' => 'required|string'
        ];
    }

    static function list_rules()
    {
        return [
            'path' => 'required|string',
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