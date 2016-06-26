<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/06/2016
 * Time: 05:02 PM
 */

namespace App\Http\Controllers\Moneybox;


use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;;
use App\Models\Moneybox;
use App\Repositories\MoneyboxRepository;
use App\Repositories\MoneyboxSettingRepository;

class MoneyboxController extends PLController{

    //region Attributes
    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    /**
     * @var MoneyboxSettingRepository
     */
    private $_moneyboxSettingsRepository;

    //endregion

    //region Static Methods
    //endregion

    public function __construct(MoneyboxRepository $moneyboxRepository, MoneyboxSettingRepository $moneyboxSettingRepository)
    {
        $this->_moneyboxRepository = $moneyboxRepository;
        $this->_moneyboxSettingsRepository = $moneyboxSettingRepository;
    }

    //region Private Methods
    //endregion

    //region Methods

    /**
     * Create a new moneybox
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createMoneybox(PLRequest $request)
    {
        // 1 : validate request
        $this->validate($request, $request->rules(), $request->messages());

        $moneybox = null;

        try {
            // 2: create moneybox
            $moneybox = $this->_moneyboxRepository->create($request);
            if ($moneybox instanceof Moneybox) {
                $this->_moneyboxSettingsRepository->setSettings($request, $moneybox);
                $this->_response['description'] = "Moneybox created successfully";
                $this->_response['data'] = $moneybox;
            }
            return response()->json($this->_response);
        } catch(\Exception $ex) {

            // if money box has been created, and after an exception is throwed, then delete unnecesary registers
            if($moneybox instanceof Moneybox)
            {
                // delete registers associated with the moneybox in moneybox_settings table
                $this->_moneyboxSettingsRepository->deleteSettings($moneybox);
                // delete moneybox
                $this->_moneyboxRepository->delete();
            }

            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }
    }

    //endregion

} 