<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 26/06/2016
 * Time: 11:44 AM
 */

namespace App\Http\Controllers\Moneybox;

use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;

class SettingController extends PLController{

    //region Attributes
    /**
     * @var SettingRepository
     */
    private $_settingRepository;
    //endregion

    //region Static methods
    //endregion

    public function __construct(SettingRepository $settingRepository)
    {
        $this->_settingRepository = $settingRepository;
    }

    //region Private methods
    //endregion

    //region Methods

    /**
     * Create a new Setting
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createSetting(PLRequest $request)
    {
        // validate the request
        $this->validate($request,$request->rules(),$request->messages());

        try {
            $setting = $this->_settingRepository->create($request);
            if($setting instanceof Setting)
            {
                $this->_response['description'] = "setting was added successfully";
                $this->_response['data'] = $setting;
            }
            return response()->json($this->_response);

        } catch(\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }
    }

    /**
     * Get all settings in the database
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll()
    {
        try {
            $this->_response['data'] = $this->_settingRepository->getAll();
            return response()->json($this->_response);
        } catch(\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }
    }

    //endregion


} 