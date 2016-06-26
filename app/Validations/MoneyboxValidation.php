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
            'goal_amount' => 'required', // TODO - hacer validacion para decimales
            'owner' => 'required|numeric',
            'end_date' => 'required',    // TODO - ver que formato tendra la fecha
            'settings' => 'required|json', // TODO -  como validar los datos de mi objeto JSON
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