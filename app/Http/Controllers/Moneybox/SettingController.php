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
use App\Entities\SettingOption;
use App\Http\Responses\PLResponse;
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
            $this->setResponse($this->_settingRepository->create($request));
            return response()->json($this->getResponse());
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
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
            $this->setResponse($this->_settingOptionRepository->create($request));
            return response()->json($this->getResponse());
        } catch (\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
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
            $this->setResponse($this->_settingRepository->childsOf($request));
            return response()->json($this->getResponse());
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }

    //endregion


}