<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:23 PM
 */

namespace App\Repositories;


use App\Models\Payment;

class PaymentRepository extends BaseRepository{

    //region attributes

    /**
     * @var Payment
     */
    private $_payment = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Payment $payment){
        $this->_payment = $payment;
    }

    //region Methods

    /**
     * return namespace for MoneyboxPayment model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Payment';
    }

    //endregion

    //region Private Methods
    //endregion
}