<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:23 PM
 */

namespace App\Repositories;


class MoneyboxPayment extends BaseRepository{

    //region attributes

    /**
     * @var MoneyboxPayment
     */
    private $_moneyboxPayment = null;

    //endregion

    //region Static
    //endregion

    public function __construct(MoneyboxPayment $moneyboxPayment){
        $this->_moneyboxPayment = $moneyboxPayment;
    }

    //region Methods

    /**
     * return namespace for MoneyboxPayment model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\MoneyboxPayment';
    }

    //endregion

    //region Private Methods
    //endregion
}