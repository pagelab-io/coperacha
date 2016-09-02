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
     * @var PayPalRepository
     */
    private $_paypal;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    //endregion

    //region Static
    //endregion

    public function __construct(
        Payment $payment,
        PLConektaOxxo $oxxo,
        PLConektaSpei $spei,
        PayPalRepository $payPalRepository,
        MoneyboxRepository $moneyboxRepository,
        PersonRepository $personRepository)
    {
        $this->_payment = $payment;
        $this->_oxxo = $oxxo;
        $this->_spei = $spei;
        $this->_paypal = $payPalRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
        $this->_personRepository = $personRepository;
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
            case PLConstants::PAYMENT_PAYPAL:
                $response = $this->paypalPayment($request);
                break;
        }

        return $response;
    }


    public function conektaResponse(PLRequest $request)
    {
        \Log::info("=== Conekta Response ===");
        $response = new PLResponse();

        if ($request->get('type') == 'charge.paid'){
            $payment = null;
            $moneybox = null;
            $return_data = $request->get('data');
            \Log::info("======>");
            \Log::info($return_data['reference_id']);

            /*\Log::info("=== Searching payment ===");
            try { $payment = $this->byToken($request->get('token')); }
            catch(\Exception $ex) { throw new \Exception('Unable to find the selected payment, try again', -1, $ex); }
            \Log::info("=== Payment: ".$payment." ===");

            \Log::info("=== Searching moneybox ===");
            try { $moneybox = $this->_moneyboxRepository->byId($payment->moneybox_id);}
            catch(\Exception $ex) { throw new \Exception('Unable to find moneybox', -1, $ex); }
            \Log::info("=== Moneybox: ".$moneybox." ===");*/

        } else {
            \Log::info("Error ...");
        }

        $response->description = 'success';
        return $response;
    }

    public function paypalResponse(PLRequest $request)
    {
        \Log::info("=== PayPal Response ===");
        $response = new PLResponse();

        if($request->exists('token') && $request->exists('PayerID')) {
            \Log::info($request);
            $payment = null;
            $moneybox = null;

            \Log::info("=== Searching payment ===");
            try { $payment = $this->byToken($request->get('token')); }
            catch(\Exception $ex) { throw new \Exception('Unable to find the selected payment, try again', -1, $ex); }
            \Log::info("=== Payment: ".$payment." ===");

            \Log::info("=== Searching moneybox ===");
            try { $moneybox = $this->_moneyboxRepository->byId($payment->moneybox_id);}
            catch(\Exception $ex) { throw new \Exception('Unable to find moneybox', -1, $ex); }
            \Log::info("=== Moneybox: ".$moneybox." ===");

            // DoExpressCheckout
            $doExpress = $this->_paypal->checkOut('DoExpressCheckoutPayment', $request, array('amount' => $payment->amount));
            if (is_array($doExpress)) {
                if ($doExpress['success'] == 1) {
                    try {
                        \DB::beginTransaction();
                        $payment->status = PLConstants::PAYMENT_PAYED;
                        $payment->save();
                        $moneybox->collected_amount += $payment->amount;
                        $moneybox->save();
                        \DB::commit();
                    } catch(\Exception $ex) {
                        \Log::info("=== Executing rollback ... ===");
                        \DB::rollback();
                        throw $ex;
                    }
                    $response->data = $doExpress;
                    $response->description = "Pago realizado correctamente";
                } else {
                    $response->status = -301;
                    $response->data = $doExpress;
                    $response->description = "No se pudieron actualizar los datos del pago";
                }
            }

        } else {
            $response->status = -300;
            $response->description = 'Invalid parameters';
        }

        return $response;
    }

    public function byToken($token)
    {
        return Payment::where('uid', $token)->firstOrFail();
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

        $response = new PLResponse();

        \Log::info("=== Searching person ===");
        try{$person = $this->_personRepository->byId($request->get('person_id')); }
        catch(\Exception $ex){ throw new \Exception("Unable to find person", -1); }
        \Log::info("=== Person : ".$person."===");

        \Log::info("=== Searching moneybox ===");
        try{$moneybox = $this->_moneyboxRepository->byId($request->get('moneybox_id')); }
        catch(\Exception $ex){ throw new \Exception("Unable to find moneybox", -1); }
        \Log::info("=== Moneybox : ".$moneybox."===");

        $paypalResponse = $this->_paypal->sendPayment($request);
        \Log::info($paypalResponse);
        if (is_array($paypalResponse)) {
            if($paypalResponse['success'] == 1) {
                $payment = new Payment();
                $payment->person_id     = $request->get('person_id');
                $payment->moneybox_id   = $request->get('moneybox_id');
                $payment->amount        = $request->get('amount');
                $payment->method        = PLConstants::PAYMENT_PAYPAL;
                $payment->uid           = urldecode($paypalResponse['data']['TOKEN']);
                $payment->status        = PLConstants::PAYMENT_PENDING;
                if (!$payment->save()) throw new Exception("Unable to create payment", -1);
                $response->description = "PayPal Payment created successfully";
                $response->data = $paypalResponse;
            } else {
                $response->description = "Error in setExpressChekout";
                $response->status = -300;
                $response->data = $paypalResponse;
            }
        }
        return $response;
    }

    //endregion
}