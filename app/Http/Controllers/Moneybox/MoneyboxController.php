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
use App\Entities\Moneybox;
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

        try {
            $this->setResponse($this->_moneyboxRepository->getAll($request));
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
            $this->setResponse($this->_moneyboxRepository->updateMoneybox($request));
            return response()->json($this->getResponse());
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }

    public function createSession(PLRequest $request)
    {
        $tmp_moneybox = array(
            'name'          => ($request->exists('name')) ? $request->get('name') : '',
            'person_id'     => ($request->exists('person_id')) ? $request->get('person_id') : '',
            'person_name'   => ($request->exists('person_name')) ? $request->get('person_name') : '',
            'goal_amount'   => ($request->exists('goal_amount')) ? $request->get('goal_amount') : '',
            'description'   => ($request->exists('description')) ? $request->get('description') : ''
        );
        $session = \Session::put('tmp_moneybox', $tmp_moneybox);
        $response = new PLResponse();
        $response->data = $session;
        $response->description = "Datos temporales para la alcancia creados correctamente";
        $this->setResponse($response);
        return response()->json($this->getResponse());
    }

    public function getSession()
    {
        $session = \Session::get('tmp_moneybox');
        $response = new PLResponse();
        $response->data = $session;
        $response->description = "Datos temporales para la alcancia recuperados correctamente";
        $this->setResponse($response);
        return response()->json($this->getResponse());
    }

    public function deleteSession()
    {
        $session = \Session::forget('tmp_moneybox');
        $response = new PLResponse();
        $response->data = $session;
        $response->description = "Datos temporales para la alcancia borrados correctamente";
        $this->setResponse($response);
        return response()->json($this->getResponse());
    }

    //endregion

} 