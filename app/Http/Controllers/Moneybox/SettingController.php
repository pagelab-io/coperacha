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
use App\Models\SettingOption;
use App\Repositories\SettingOptionRepository;
use App\Repositories\SettingRepository;

class SettingController extends PLController{

    //region Attributes
    /**
     * @var SettingRepository
     */
    private $_settingRepository;

    /**
     * @var SettingOptionRepository
     */
    private $_settingOptionRepository;
    //endregion

    //region Static methods
    //endregion

    public function __construct(SettingRepository $settingRepository, SettingOptionRepository $settingOptionRepository)
    {
        $this->_settingRepository = $settingRepository;
        $this->_settingOptionRepository = $settingOptionRepository;
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
     * Create a new Option for selected Setting
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createOptions(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());
        try {
            $option = $this->_settingOptionRepository->create($request);
            if($option instanceof SettingOption)
            {
                $this->_response['description'] = "option was added successfully";
                $this->_response['data'] = $option;
            }
            return response()->json($this->_response);
        } catch (\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }
    }

    /**
     * Get all settings in the database
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());

        try {
            $this->_response['data'] = $this->_settingRepository->childsOf($request);
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