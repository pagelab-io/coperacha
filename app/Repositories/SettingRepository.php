<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:04 PM
 */

namespace App\Repositories;


use App\Models\Setting;

class SettingRepository extends BaseRepository{

    //region attributes
    /**
     * @var Setting
     */
    private $_setting = null;
    //endregion

    //region Static
    //endregion

    public function __construct(Setting $setting){
        $this->_setting = $setting;
    }

    //region Methods

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Model\Setting';
    }

    //endregion

    //region Private Methods
    //endregion

}