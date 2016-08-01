<?php

namespace App\Models;

class PayPal
{

    /**
     * PayPal API Username.
     * @var type
     */
    public $API_Username;

    /**
     * PayPal API Password.
     * @var type
     */
    public $API_Password;

    /**
     * PayPal API Signature.
     * @var type
     */
    public $API_Signature;

    /**
     * Sandbox or Live.
     * @var type
     */
    public $mode;

    /**
     * PayPal currency code.
     * @var type
     */
    public $currencyCode;

    /**
     * Point to paypal-process.php page.
     * @var type
     */
    public $returnURL;

    /**
     * Cancel URL if the user clicks cancel.
     * @var type
     */
    public $cancelURL;

    /**
     * Error URL if the user clicks cancel.
     * @var type
     */
    public $errorURL;

    /**
     * Pending URL if the user clicks cancel.
     * @var type
     */
    public $pendingURL;

    /**
     * Cancel URL if the user clicks cancel.
     * @var type
     */
    public $finalizeurl;

    /**
     * Version for the API.
     * @var type
     */
    public $version;

    /**
     * Show the initial window in PayPal
     * Billing or Login
     * @var
     */
    public $settings;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->API_Username = env('API_USERNAME');
        $this->API_Password = env('API_PASSWORD');
        $this->API_Signature = env('API_SIGNATURE');
        $this->currencyCode = env('CURRENCY_CODE');
        $this->returnURL = env('RETURN_URL');
        $this->cancelURL = env('CANCEL_URL');
        $this->errorURL = env('ERROR_URL');
        $this->pendingURL = env('PENDING_URL');
        $this->finalizeurl = env('FINALIZE_URL');
        $this->version = env('VERSION');
        $this->mode = env('MODE');
        $this->settings = env('WEBSTORE_SETTINGS');
    }

    /**
     *
     * @param $methodName
     * @param $nvpStr
     * @return any
     */
    public function PPHttpPost($methodName, $nvpStr)
    {

        $API_Endpoint = 'https://api-3t' . $this->isSandbox() . '.paypal.com/nvp';

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $API_Endpoint);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        // Turn off the server and peer verification (TrustManager Concept).
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        // Set the API operation, version, and API signature in the request.
        $nvpreq = "&USER=$this->API_Username" .
            "&PWD=$this->API_Password" .
            "&SIGNATURE=$this->API_Signature" .
            "&VERSION=$this->version" .
            "&PAYMENTACTION=Sale" .
            "&PAYMENTREQUEST_0_CURRENCYCODE=$this->currencyCode" .
            "&CURRENCYCODE=$this->currencyCode" .
            "&RETURNURL=$this->returnURL" .
            "&CANCELURL=$this->cancelURL" .
            "&METHOD=" . $methodName . $nvpStr;

        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $nvpreq);

        // Get response from the server.
        $httpResponse = curl_exec($ch);

        if (!$httpResponse) {
            exit("$this->API_Username failed: " . curl_error($ch) . '(' . curl_errno($ch) . ')');
        }

        // Extract the response details.
        $httpResponseAr = explode("&", $httpResponse);

        $httpParsedResponseAr = array();
        foreach ($httpResponseAr as $i => $value) {
            $tmpAr = explode("=", $value);
            if (sizeof($tmpAr) > 1) {
                $httpParsedResponseAr[$tmpAr[0]] = $tmpAr[1];
            }
        }

        if ((0 == sizeof($httpParsedResponseAr)) || !array_key_exists('ACK', $httpParsedResponseAr)) {
            exit("Invalid HTTP Response for POST request($nvpreq) to $API_Endpoint.");
        }

        return $httpParsedResponseAr;
    }

    /**
     *
     * @return string
     */
    public function isSandbox()
    {
        if ($this->mode == 1)
            return '.sandbox';
        else
            return '';
    }

}