<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/06/2016
 * Time: 05:02 PM
 */

namespace App\Http\Controllers\Moneybox;


use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Models\Moneybox;
use App\Repositories\MoneyboxRepository;

class MoneyboxController extends PLController{

    //region Attributes
    /**
     * @var Moneybox
     */
    private $_moneyboxRepository;
    //endregion

    //region Static Methods
    //endregion

    public function __construct(MoneyboxRepository $moneyboxRepository)
    {
        $this->_moneyboxRepository = $moneyboxRepository;
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
        try {
            // 2: create moneybox
            $moneybox = $this->_moneyboxRepository->createMoneybox($request);
            if ($moneybox instanceof Moneybox) {

                // 3: create settings
                // TODO - create settings
                $this->_response['description'] = "Moneybox created successfully";
                $this->_response['data'] = $moneybox;
            }
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