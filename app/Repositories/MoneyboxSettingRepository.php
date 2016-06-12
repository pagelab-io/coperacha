<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:11 PM
 */

namespace App\Repositories;


use App\Models\MoneyboxSetting;

class MoneyboxSettingRepository extends BaseRepository{

    //region attributes

    /**
     * @var MoneyboxSetting
     */
    private $_moneyboxSetting = null;

    //endregion

    //region Static
    //endregion

    public function __construct(MoneyboxSetting $moneyboxSetting){
        $this->_moneyboxSetting = $moneyboxSetting;
    }

    //region Methods

    /**
     * return namespace for MoneyboxSetting model
     * @return mixed
     */
    function model()
    {
        return 'App\Models\MoneyboxSetting';
    }

    //endregion

    //region Private Methods
    //endregion
}