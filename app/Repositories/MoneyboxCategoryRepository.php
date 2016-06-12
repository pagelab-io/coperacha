<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:18 PM
 */

namespace App\Repositories;


use App\Models\MoneyboxCategory;

class MoneyboxCategoryRepository extends BaseRepository{

    //region attributes

    /**
     * @var MoneyboxCategory
     */
    private $_moneyboxCategory = null;

    //endregion

    //region Static
    //endregion

    public function __construct(MoneyboxCategory $moneyboxCategory){
        $this->_moneyboxCategory = $moneyboxCategory;
    }

    //region Methods

    /**
     * return namesapace for MoneyboxCategory Model
     * @return mixed
     */
    function model()
    {
        return 'App\Models\MoneyboxCategory';
    }

    //endregion

    //region Private Methods
    //endregion
}