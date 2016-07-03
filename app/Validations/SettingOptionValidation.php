<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 02/07/2016
 * Time: 11:35 PM
 */

namespace App\Validations;


class SettingOptionValidation {

    // region attributes
    //endregion

    //region Static methods

    /**
     * Rules for create settingOptions
     *
     * @return array
     */
    static function rules()
    {
        return [
            'setting_id' => 'required|numeric',
            'name' => 'required|string',
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