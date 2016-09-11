<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 26/06/2016
 * Time: 11:44 AM
 */

namespace App\Http\Controllers\Moneybox;

use App\Entities\Payment;
use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Repositories\PaymentRepository;

class PaymentController extends PLController{

    //region Attributes

    /**
     * @var PaymentRepository
     */
    private $_paymentRepository;

    /**
     * @var Payment
     */
    private $_payment;

    //endregion

    //region Static methods
    //endregion

    public function __construct(Payment $payment, PaymentRepository $paymentRepository)
    {
        $this->_payment = $payment;
        $this->_paymentRepository = $paymentRepository;
    }

    //region Private methods
    //endregion

    //region Methods

    public function createPayment(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());

        try {
            $this->setResponse($this->_paymentRepository->payment($request));
            return response()->json($this->getResponse());
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }

    public function paypalResponse(PLRequest $request)
    {
        try {
            $this->setResponse($this->_paymentRepository->paypalResponse($request));
            if($this->getResponse()->status == 200)
            {
                if(\Session::get('tmp_participant'))
                    \Session::forget('');
                return redirect('/');
            } else {
                // TODO - change this for anoter view
                return response()->json($this->getResponse());
            }
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }
    }

    public function conektaResponse(PLRequest $request)
    {
        try {
            $this->setResponse($this->_paymentRepository->conektaResponse($request));
            if($this->getResponse()->status == 200)
            {
                if(\Session::get('tmp_participant'))
                    \Session::forget('');
            }
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