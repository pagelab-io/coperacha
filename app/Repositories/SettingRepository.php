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
use Illuminate\Container\Container as App;

class SettingRepository extends BaseRepository{

    //region attributes
    /**
     * @var Setting
     */
    private $_setting = null;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository = null;
    //endregion

    //region Static
    //endregion

    public function __construct(Setting $setting, App $app, MoneyboxRepository $moneyboxRepository){
        parent::__construct($app);
        $this->_setting = $setting;
        $this->_moneyboxRepository = $moneyboxRepository;
    }

    //region Methods

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Setting';
    }

    /**
     * Create a new Setting
     *
     * @param PLRequest $request
     * @return Setting
     * @throws \Exception
     */
    public function create(PLRequest $request){
        \Log::info("=== Setting create ===");
        $this->_setting->name = $request->get('name');
        if (!$this->_setting->save()) throw new \Exception("Unable to create Setting", -1);
        \Log::info("=== Setting created successfully : ".$this->_setting." ===");
        return $this->_setting;
    }

    /**
     * Get all settings
     *
     * @return mixed
     */
    public function getAll()
    {
        \Log::info("=== get all settings ===");
        return $this->all();
    }

    //endregion

    //region Private Methods
    //endregion

}