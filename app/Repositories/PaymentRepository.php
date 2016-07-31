<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:23 PM
 */

namespace App\Repositories;


use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Entities\Payment;
use App\Models\PLConektaOxxo;
use App\Models\PLConektaSpei;
use App\Utilities\PLConstants;
use Mockery\CountValidator\Exception;

class PaymentRepository extends BaseRepository
{

    //region attributes

    /**
     * @var Payment
     */
    private $_payment;

    /**
     * @var PLConektaOxxo
     */
    private $_oxxo;

    /**
     * @var PLConektaSpei
     */
    private $_spei;

    /**
     * PLPaypel
     * @var
     */
    private $_paypal;

    //endregion

    //region Static
    //endregion

    public function __construct(Payment $payment, PLConektaOxxo $oxxo, PLConektaSpei $spei)
    {
        $this->_payment = $payment;
        $this->_oxxo = $oxxo;
        $this->_spei = $spei;
    }

    //region Methods

    /**
     * return namespace for MoneyboxPayment model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Payment';
    }

    public function payment(PLRequest $request)
    {

        $response = new PLResponse();

        switch ($request->get('payment_method')) {
            case PLConstants::PAYMENT_OXXO :
                $response = $this->oxxoPayment($request);
                break;
            case PLConstants::PAYMENT_SPEI:
                $response = $this->speiPayment($request);
                break;
            case PLConstants::PAYMENT_PAYPAL: // hacer paypal
                break;
        }

        return $response;
    }

    //endregion

    //region Private Methods

    private function oxxoPayment(PLRequest $request)
    {
        $oxxoResponse = $this->_oxxo->sendPayment($request);
        if (is_array($oxxoResponse)) {
            $payment = new Payment();
            $payment->person_id     = $request->get('person_id');
            $payment->moneybox_id   = $request->get('moneybox_id');
            $payment->amount        = $request->get('amount');
            $payment->method        = PLConstants::PAYMENT_OXXO;
            $payment->uid           = $oxxoResponse['reference_id'];
            $payment->status        = PLConstants::PAYMENT_PENDING;
            if (!$payment->save()) throw new Exception("Unable to create payment", -1);
        }

        $response = new PLResponse();
        $response->data = $oxxoResponse;
        $response->description = "Oxxo Payment created successfully";
        return $response;
    }

    private function speiPayment(PLRequest $request)
    {
        $speiResponse = $this->_spei->sendPayment($request);
        if (is_array($speiResponse)) {
            $payment = new Payment();
            $payment->person_id     = $request->get('person_id');
            $payment->moneybox_id   = $request->get('moneybox_id');
            $payment->amount        = $request->get('amount');
            $payment->method        = PLConstants::PAYMENT_SPEI;
            $payment->uid           = $speiResponse['reference_id'];
            $payment->status        = PLConstants::PAYMENT_PENDING;
            if (!$payment->save()) throw new Exception("Unable to create payment", -1);
        }

        $response = new PLResponse();
        $response->data = $speiResponse;
        $response->description = "Spei Payment created successfully";
        return $response;
    }

    private function paypalPayment(PLRequest $request)
    {
        // TODO
    }


    //endregion
}