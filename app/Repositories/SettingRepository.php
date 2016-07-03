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
     * @var array
     */
    private $childrens = [];

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
        $this->setDefault();
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
        $this->_setting->path = ($request->get('path') != "") ? $request->get('path') : "/";
        $this->_setting->type = ($request->get('type') != "") ? $request->get('type') : "text";
        if (!$this->_setting->save()) throw new \Exception("Unable to create Setting", -1);
        \Log::info("=== Setting created successfully : ".$this->_setting." ===");
        return $this->_setting;
    }

    /**
     * Get all settings with it's childrens
     *
     * @param PLRequest $request
     * @return mixed
     */
    public function childsOf(PLRequest $request)
    {
        \Log::info("=== Get all settings with it's childrens ===");
        $parents = Setting::where("path",$request->get("path"))->get();

        if (count($parents) > 0)
            foreach ($parents as $parent)
                $parent->options;

        return $parents;
    }

    /**
     * Set the default values for person
     */
    public function setDefault()
    {
        $this->_setting->path = '/';
        $this->_setting->type = 'text';
    }
    //endregion

    //region Private Methods
    //endregion

}