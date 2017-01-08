<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 31/07/2016
 * Time: 01:22 PM
 */

namespace App\Validations;


class PaymentValidation {

    /**
     * Rules for register fields
     *
     * @return array
     */
    static function rules()
    {
        return [
            'person_id' => 'required|numeric',
            'moneybox_id'  => 'required|numeric',
            'amount'  => 'required',
            'commission' => 'required',
            'payment_method'  => 'required|string',
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

} 