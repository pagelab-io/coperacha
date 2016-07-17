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
use App\Http\Responses\PLResponse;
use App\Models\Moneybox;
use App\Repositories\MoneyboxRepository;
use App\Repositories\MemberSettingRepository;

class MoneyboxController extends PLController {

    //region Attributes
    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    /**
     * @var MemberSettingRepository
     */
    private $_memberSettingsRepository;

    //endregion

    //region Static Methods
    //endregion

    public function __construct(MoneyboxRepository $moneyboxRepository, MemberSettingRepository $memberSettingsRepository)
    {
        $this->_moneyboxRepository = $moneyboxRepository;
        $this->_memberSettingsRepository = $memberSettingsRepository;
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
        try {
            $this->validate($request, $request->rules(), $request->messages());
            $this->setResponse($this->_moneyboxRepository->create($request));
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
     * Get all moneyboxes
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());
        $moneybox_list = [];

        try {

            $my_moneyboxes = $this->_moneyboxRepository->myMoneyboxes($request);
            $third_moneyboxes = $this->_moneyboxRepository->moneyboxesParticipation($request);

            $moneybox_list['my_moneyboxes'] = $my_moneyboxes;
            $moneybox_list['moneyboxes_participation'] = $third_moneyboxes;

            $this->_response['data'] = $moneybox_list;
            return response()->json($this->_response);

        } catch (\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }
    }

    /**
     * Update the selected Moneybox
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateMoneybox(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());

        $moneybox = null;

        try {

            $moneybox = $this->_moneyboxRepository->update($request);
            if ($request->exists('settings')) {
                $this->_memberSettingsRepository->updateSettings($request, $moneybox);
            }
            $this->_response['data'] = $moneybox;

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