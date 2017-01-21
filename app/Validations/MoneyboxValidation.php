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
     * Validation rules for moneybox creation
     *
     * @return array
     */
    static function rules()
    {
        return [
            'category_id' => 'required|numeric',
            'name' => 'required|string',
            'goal_amount' => 'required|numeric',
            'person_id' => 'required|numeric',
            'end_date' => 'required|date_format:"Y-m-d"',
            'settings' => 'required|json',
        ];
    }

    /**
     * Validation rules for moneybox listing
     *
     * @return array
     */
    static function list_rules()
    {
        return [
            'person_id' => 'required|numeric',
            'method' => 'required|string'
        ];
    }

    /**
     * Validation rules for moneybox update
     * @return array
     */
    static function update_moneybox()
    {
        return [
            'moneybox_id' => 'required|numeric',
            'method' => 'required|string'
        ];
    }

    /**
     * Validation rules for moneybox invitations
     * @return array
     */
    static function send_invitations()
    {
        return [
            'url' => 'required|string',
            'emails' => 'required|string'
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