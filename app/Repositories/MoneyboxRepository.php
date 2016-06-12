<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:29 PM
 */

namespace App\Repositories;


use App\Models\Moneybox;

class MoneyboxRepository extends BaseRepository{

    //region attributes

    /**
     * @var Moneybox
     */
    private $_moneybox = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Moneybox $moneybox){
        $this->_moneybox = $moneybox;
    }

    //region Methods
    /**
     * return namespace for Moneybox Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Model\Moneybox';
    }
    //endregion

    //region Private Methods
    //endregion
}