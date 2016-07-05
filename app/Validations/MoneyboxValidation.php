<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/06/2016
 * Time: 07:14 PM
 */

namespace App\Validations;


class MoneyboxValidation {

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
            'category_id' => 'required|numeric',
            'name' => 'required|string',
            'goal_amount' => 'required|numeric',
            'owner_id' => 'required|numeric',
            'end_date' => 'required|date_format:"Y-m-d"',
            'settings' => 'required|json',
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