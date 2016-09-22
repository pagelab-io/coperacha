<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:23 PM
 */

namespace App\Repositories;

use App\Entities\Moneybox;
use App\Entities\Person;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Entities\Payment;
use App\Models\Mailer;
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

    /**
     * @var Mailer
     */
    private $_mailer;

    //endregion

    //region Static
    //endregion

    public function __construct(
        Payment $payment,
        PLConektaOxxo $oxxo,
        PLConektaSpei $spei,
        PayPalRepository $payPalRepository,
        MoneyboxRepository $moneyboxRepository,
        PersonRepository $personRepository,
        Mailer $mailer)
    {
        $this->_payment = $payment;
        $this->_oxxo = $oxxo;
        $this->_spei = $spei;
        $this->_paypal = $payPalRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
        $this->_personRepository = $personRepository;
        $this->_mailer = $mailer;
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

    /**
     * Do payment by PayPal, OXXO, SPEI
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
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

    /**
     * Get the Conekta response after payment and send emails.
     *
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
    public function conektaResponse(PLRequest $request)
    {
        \Log::info("=== Conekta Response ===");
        $response = new PLResponse();

        if ($request->get('type') == 'charge.paid'){
            $payment = null;
            $moneybox = null;
            $return_data = $request->get('data');

            \Log::info("=== Searching payment ===");
            try { $payment = $this->byToken($return_data['object']['reference_id']); }
            catch(\Exception $ex) { throw new \Exception('Unable to find the selected payment, try again', -1, $ex); }
            \Log::info("=== Payment: ".$payment." ===");

            \Log::info("=== Searching moneybox ===");
            try { $moneybox = $this->_moneyboxRepository->byId($payment->moneybox_id);}
            catch(\Exception $ex) { throw new \Exception('Unable to find moneybox', -1, $ex); }
            \Log::info("=== Moneybox: ".$moneybox." ===");

            try {
                \DB::beginTransaction();
                $payment->status = PLConstants::PAYMENT_PAYED;
                $payment->save();
                $moneybox->collected_amount += $payment->amount;
                $moneybox->commission_amount += $payment->commission;
                $moneybox->save();
                \DB::commit();
            } catch(\Exception $ex) {
                \Log::info("=== Executing rollback ... ===");
                \DB::rollback();
                throw $ex;
            }
            $response->description = 'success';

            // send email
            $payer   = $this->getPayerOrCreator($payment->person_id);
            $creator = $this->getPayerOrCreator($moneybox->person_id);
            $this->sendPaymentEmails($payer, $creator, $moneybox, $this->amountComplete($moneybox));

        } else {
            \Log::info("Waiting for charge ...");
            $response->description = 'Waiting for charge ...';
        }

        return $response;
    }

    /**
     * Get the PayPal response after payment and send emails
     *
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
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
            $doExpress = $this->_paypal->checkOut('DoExpressCheckoutPayment', $request, array('amount' => $payment->amount, 'commission' => $payment->commission));
            if (is_array($doExpress)) {
                if ($doExpress['success'] == 1) {
                    try {
                        \DB::beginTransaction();
                        $payment->status = PLConstants::PAYMENT_PAYED;
                        $payment->save();
                        $moneybox->collected_amount += $payment->amount;
                        $moneybox->commission_amount += $payment->commission;
                        $moneybox->save();
                        \DB::commit();
                    } catch(\Exception $ex) {
                        \Log::info("=== Executing rollback ... ===");
                        \DB::rollback();
                        throw $ex;
                    }
                    $response->data = $doExpress;
                    $response->description = "Pago realizado correctamente";

                    // send email
                    $payer   = $this->getPayerOrCreator($payment->person_id);
                    $creator = $this->getPayerOrCreator($moneybox->person_id);
                    $this->sendPaymentEmails($payer, $creator, $moneybox, $this->amountComplete($moneybox));

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

    /**
     * Search a specified payment by token after payments.
     * @param $token
     * @return mixed
     */
    public function byToken($token)
    {
        return Payment::where('uid', $token)->firstOrFail();
    }

    public function paymentAVGB(){
        $result = array('P' => 0,'O' => 0,'S' => 0);
        $payments = Payment::where('status', PLConstants::PAYMENT_PAYED)->get();
        $sum = 0;
        if(count($payments) > 0){
            foreach($payments as $payment){
                $sum++;
                $result[$payment->method] += 1;
            }
            foreach($result as $key => $value){
                $avg = ($result[$key]/$sum)*100;
                $result[$key] = $avg;
            }
        }

        return $result;
    }

    public function paymentAVGByPerson($person_id)
    {
        $result = array('P' => 0,'O' => 0,'S' => 0);
        $payments = Payment::where(array(array('person_id', $person_id), array('status', PLConstants::PAYMENT_PAYED)))->get();
        $sum = 0;
        if(count($payments) > 0){
            foreach($payments as $payment){
                $sum++;
                $result[$payment->method] += 1;
            }
            foreach($result as $key => $value){
                $avg = ($result[$key]/$sum)*100;
                $result[$key] = $avg;
            }
        }

        return $result;
    }

    public function paymentAVGByMoneybox($moneybox_id)
    {
        $moneybox = $this->_moneyboxRepository->byId($moneybox_id);
        $result = array('P' => 0,'O' => 0,'S' => 0);
        $payments = $moneybox->payments;
        $sum = 0;
        if(count($payments) > 0){
            foreach($payments as $payment){
                if($payment->status == PLConstants::PAYMENT_PAYED) {
                    $sum++;
                    $result[$payment->method] += 1;
                }
            }
            foreach($result as $key => $value){
                $avg = ($result[$key]/$sum)*100;
                $result[$key] = $avg;
            }
        }

        return $result;
    }

    //endregion

    //region Private Methods

    /**
     * Create a Conekta charge for OXXO.
     *
     * @param PLRequest $request
     * @return PLResponse
     */
    private function oxxoPayment(PLRequest $request)
    {
        $oxxoResponse = $this->_oxxo->sendPayment($request);
        if (is_array($oxxoResponse)) {
            $payment = new Payment();
            $payment->person_id     = $request->get('person_id');
            $payment->moneybox_id   = $request->get('moneybox_id');
            $payment->amount        = $request->get('amount');
            $payment->commission    = $request->get('commission');
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

    /**
     * Create a Conekta charge for SPEI
     * @param PLRequest $request
     * @return PLResponse
     */
    private function speiPayment(PLRequest $request)
    {
        $speiResponse = $this->_spei->sendPayment($request);
        if (is_array($speiResponse)) {
            $payment = new Payment();
            $payment->person_id     = $request->get('person_id');
            $payment->moneybox_id   = $request->get('moneybox_id');
            $payment->amount        = $request->get('amount');
            $payment->commission    = $request->get('commission');
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

    /**
     * Generates an url for PayPal SetExpressCheckout
     *
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
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
                if($paypalResponse['success'] == 1) {
                    $payment = new Payment();
                    $payment->person_id     = $request->get('person_id');
                    $payment->moneybox_id   = $request->get('moneybox_id');
                    $payment->amount        = $request->get('amount');
                    $payment->commission    = $request->get('commission');;
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
        }
        return $response;
    }

    /**
     * Get moneybox creator or moneybox payer
     * @param $person_id
     * @return Person
     * @throws \Exception
     */
    private function getPayerOrCreator($person_id)
    {
        $person = null;
        \Log::info("=== Searching Payer or moneybox creator ===");
        try { $person = $this->_personRepository->byId($person_id);}
        catch(\Exception $ex) { throw new \Exception('Unable to find person', -1, $ex); }
        \Log::info("=== Person: ".$person." ===");
        return $person;
    }

    /**
     * Send all emails after payment
     *
     * @param Person $payer
     * @param Person $creator
     * @param Moneybox $moneybox
     * @param bool $goal_finished
     */
    private function sendPaymentEmails(Person $payer, Person $creator, Moneybox $moneybox, $goal_finished = false)
    {
        \Log::info("sending payment confirmation email ...");
        // ====== Send email for payer ========
        $data = array(
            'payer' => $payer,
            'moneybox' => $moneybox
        );
        $payerUser = $payer->user;
        \Log::info($payerUser->email);
        $options = array(
            'to' => $payerUser->email,
            'bcc' => explode(',', PLConstants::EMAIL_BCC),
            'title' => 'Confirmación de pago'
        );
        $this->_mailer->send(PLConstants::EMAIL_PAYMENT_CONFIRMATION, $data, $options);

        \Log::info("sending new coperacha email ...");
        // ====== Send email for moneybox creator ========
        $data = array(
            'creator' => $creator,
            'moneybox' => $moneybox
        );
        $creatorUser = $creator->user;
        $options = array(
            'to' => $creatorUser->email,
            'bcc' => explode(',', PLConstants::EMAIL_BCC),
            'title' => '¡Nueva coperacha!'
        );
        $this->_mailer->send(PLConstants::EMAIL_NEW_COPERACHA, $data, $options);

        if ($goal_finished) {
            \Log::info("sending goal complete email ...");
            // ====== Send email for moneybox creator ========
            $data = array(
                'creator' => $creator,
                'moneybox' => $moneybox
            );
            $creatorUser = $creator->user;
            $options = array(
                'to' => $creatorUser->email,
                'bcc' => explode(',', PLConstants::EMAIL_BCC),
                'title' => 'Meta alcanzada'
            );
            $this->_mailer->send(PLConstants::EMAIL_GOAL_FINISHED, $data, $options);
        }

    }

    private function amountComplete(Moneybox $moneybox)
    {
        return $moneybox->collected_amount >= $moneybox->goal_amount;
    }

    //endregion
}