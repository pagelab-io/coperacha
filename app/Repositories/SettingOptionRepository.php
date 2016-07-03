<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:04 PM
 */

namespace App\Repositories;


use App\Http\Requests\PLRequest;
use App\Models\Setting;
use App\Models\SettingOption;
use Illuminate\Container\Container as App;

class SettingOptionRepository extends BaseRepository{

    //region attributes
    /**
     * @var Setting
     */
    private $_settingOption = null;
    //endregion

    //region Static
    //endregion

    public function __construct(SettingOption $settingOption, App $app){
        parent::__construct($app);
        $this->_settingOption = $settingOption;
    }

    //region Methods

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\SettingOption';
    }

    /**
     * Create a new Setting
     *
     * @param PLRequest $request
     * @return Setting
     * @throws \Exception
     */
    public function create(PLRequest $request){
        \Log::info("=== Setting Option create ===");
        $this->_settingOption->setting_id = $request->get('setting_id');
        $this->_settingOption->name = $request->get('name');
        $this->_settingOption->subtype = ($request->exists('subtype')) ? $request->get('subtype') : "";
        if (!$this->_settingOption->save()) throw new \Exception("Unable to create SettingOption", -1);
        \Log::info("=== Setting Option created successfully : ".$this->_settingOption." ===");
        return $this->_settingOption;
    }
    //endregion

    //region Private Methods
    //endregion

}