<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 31/07/2016
 * Time: 05:31 PM
 */

namespace App\Repositories;

use Carbon\Carbon;
use App\Http\Requests\PLRequest;
use App\Models\IPLPayment;
use App\Models\PayPal;

class PayPalRepository implements IPLPayment{

    /**
     * @PayPal
     */
    private $_paypal;

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    public function __construct(PayPal $paypal, PersonRepository $personRepository, MoneyboxRepository $moneyboxRepository) {
        $this->_paypal = $paypal;
        $this->_personRepository = $personRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
    }

    public function setCancelUrl($url)
    {
        $this->_paypal->setCancelUrl($url);
    }

    /**
     * Method to build the PayPal String
     *
     * The method var can contains the next values:
     *
     * - SetExpressCheckout
     * - DoExpressCheckoutPayment
     *
     * @param string $method
     * @param PLRequest $request
     * @param null $options
     * @throws \Exception
     * @return string
     */
    public function checkOut($method = "SetExpressCheckout", PLRequest $request, $options = null){

        \Log::info("--- PayPal Chekout ---");
        $paypal_string = "";
        $paypal_response = null;

        $paypal_string .=
            "&L_PAYMENTREQUEST_0_NAME0=Nueva Coperacha".
            "&L_PAYMENTREQUEST_0_QTY0=1";

        switch ($method) {

            case 'SetExpressCheckout':

                \Log::info("--- executing SetExpressCheckout ---");

                // Parameters for SetExpressCheckout, which will be sent to PayPal
                $paypal_string .=
                    '&L_PAYMENTREQUEST_0_AMT0='.$request->get('amount').
                    '&LANDINGPAGE=Billing'.
                    '&NOSHIPPING=1'.
                    '&PAYMENTREQUEST_0_ITEMAMT='.$request->get('amount').
                    '&PAYMENTREQUEST_0_TAXAMT=0'.
                    '&PAYMENTREQUEST_0_SHIPPINGAMT=0'.
                    '&PAYMENTREQUEST_0_INSURANCEAMT=0'.
                    '&PAYMENTREQUEST_0_AMT='.$request->get('amount').
                    '&PAYMENTREQUEST_0_CUSTOM='.$this->generate_uid();

                // We need to execute the "SetExpressCheckOut" method to obtain paypal token
                $httpParsedResponseAr = $this->_paypal->PPHttpPost($method, $paypal_string);

                // Manages the response
                $paypal_response = $this->paypalResponse($httpParsedResponseAr, $method);

                break; // end SetExpressCheckout

            case 'DoExpressCheckoutPayment':

                \Log::info("--- executing DoExpressCheckout ---");
                $token    = $request->get('token');
                $payer_id = $request->get('PayerID');

                \Log::info($token);
                \Log::info($payer_id);

                // Parameters for DoExpressCheckout, which will be sent to PayPal
                $paypal_string .=
                    '&L_PAYMENTREQUEST_0_AMT0='.$options['amount'].
                    '&TOKEN='.$token.
                    '&PAYERID='.$payer_id.
                    '&PAYMENTREQUEST_0_ITEMAMT='.$options['amount'].
                    '&PAYMENTREQUEST_0_TAXAMT=0'.
                    '&PAYMENTREQUEST_0_SHIPPINGAMT=0'.
                    '&PAYMENTREQUEST_0_INSURANCEAMT=0'.
                    '&PAYMENTREQUEST_0_AMT='.$options['amount'];

                $httpParsedResponseAr = $this->_paypal->PPHttpPost($method, $paypal_string);
                $paypal_response = $this->paypalResponse($httpParsedResponseAr, $method, $token);
                break;
        }

        return $paypal_response;
    }

    public function paypalResponse($httpParsedResponseAr, $method, $token = null) {

        switch($method){

            case 'SetExpressCheckout':

                \Log::info("Generating response for SetExpressCheckout ...");
                //Respond according to message we receive from Paypal
                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){

                    //Redirect user to PayPal store with Token received.
                    $paypalurl ='https://www' . $this->_paypal->isSandbox() . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"]. '';
                    \Log::info("--- SetExpressCheckout success, now begin the redirection---");
                    return array(
                        'success' => 1,
                        'url' => $paypalurl,
                        'data' => $httpParsedResponseAr,
                        'error' => ""
                    );

                }else{

                    \Log::info("--- SetExpressCheckout error ---");
                    //Show error message
                    $paypalurl = $this->_paypal->errorURL;
                    return array(
                        'success' => 0,
                        'url' => $paypalurl,
                        'data' => "",
                        'error' => $httpParsedResponseAr
                    );
                }
                break;

            case 'DoExpressCheckoutPayment':
                \Log::info("Generating response for DoExpressCheckout ...");
                //Check if everything went ok..
                if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){

                    $statusMessage = null;
                    /*
                    //Sometimes Payment are kept pending even when transaction is complete.
                    //hence we need to notify user about it and ask him manually approve the transiction
                    */
                    /*if('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]){
                        $statusMessage = "Payment Received! Your product will be sent to you very soon!";
                    }
                    else if('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]){
                        $statusMessage = "Transaction Complete, but payment is still pending!";
                        $statusMessage .= "You need to manually authorize this payment in your PayPal Account";
                    }*/

                    // we can retrive transection details using either GetTransactionDetails or GetExpressCheckoutDetails
                    // GetTransactionDetails requires a Transaction ID, and GetExpressCheckoutDetails requires Token returned by SetExpressCheckOut
                    $paypal_string = '&TOKEN='.$token;
                    $httpParsedResponseAr = $this->_paypal->PPHttpPost('GetExpressCheckoutDetails', $paypal_string);

                    if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])){
                        \Log::info("--- DoExpressCheckout success ---");
                        return array(
                            'success' => 1,
                            'url' => $this->_paypal->finalizeurl,
                            'data' => $httpParsedResponseAr['PAYMENTREQUEST_0_CUSTOM'],
                            'error' => ""
                        );
                    }else{
                        \Log::info("--- DoExpressCheckout error ---");
                        return array(
                            'success' => 0,
                            'url' => $this->_paypal->errorURL,
                            'data' => "",
                            'error' => $httpParsedResponseAr
                        );
                    }
                }else{
                    return array(
                        'success' => 0,
                        'url' => $this->_paypal->errorURL,
                        'data' => "",
                        'error' => $httpParsedResponseAr
                    );
                }
                break;
        }
        return null;
    }

    public function sendPayment(PLRequest $request)
    {
        return $this->checkout("SetExpressCheckout", $request);
    }

    private function generate_uid()
    {
        $date = new Carbon();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.$date->toDateTimeString();
        $characters = str_replace(array(':','-'), 'z', $characters);
        return substr(str_shuffle(trim($characters)), 0, 10);
    }
}