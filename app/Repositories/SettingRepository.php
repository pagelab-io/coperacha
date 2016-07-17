<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:04 PM
 */

namespace App\Repositories;


use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Entities\Setting;
use Illuminate\Container\Container as App;

class SettingRepository extends BaseRepository{

    //region attributes
    /**
     * @var Setting
     */
    private $_setting = null;
    //endregion

    //region Static
    //endregion

    public function __construct(App $app, Setting $setting){
        parent::__construct($app);
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
        return 'App\Entities\Setting';
    }

    /**
     * Create a new Setting
     *
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
    public function create(PLRequest $request){

        \Log::info("=== Setting create ===");
        $this->_setting->name = $request->get('name');
        $this->_setting->path = (trim($request->get('path')) != "") ? trim($request->get('path')) : "/";
        $this->_setting->type = (trim($request->get('type')) != "") ? trim($request->get('type')) : "text";
        if (!$this->_setting->save()) throw new \Exception("Unable to create Setting", -1);
        \Log::info("=== Setting created successfully : ".$this->_setting." ===");

        $response               = new PLResponse();
        $response->description  = "setting was added successfully";
        $response->data         = $this->_setting;

        return $response;
    }

    /**
     * Get all settings with it's childrens
     *
     * @param PLRequest $request
     * @return PLResponse
     */
    public function childsOf(PLRequest $request)
    {
        \Log::info("=== Get all settings with it's childrens ===");
        $parents = Setting::where("path",$request->get("path"))->get();

        if (count($parents) > 0)
            foreach ($parents as $parent)
                $parent->options;

        $response               = new PLResponse();
        $response->description  = "listing all settings successfully";
        $response->data         = $parents;
        return $response;
    }
    //endregion

    //region Private Methods
    //endregion

}