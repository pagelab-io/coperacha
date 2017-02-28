<?php

namespace App\Models;

use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Transactions\TxRegister;
use App\Utilities\PLConstants;
use App\Utilities\PLCustomLog;

class Register {

    //region attributes

    /**
     * @var PLCustomLog
     */
    public $log;

    /**
     * @var TxRegister
     */
    private $_txRegister;

    /**
     * @var Mailer
     */
    private $_mailer;

    //endregion

    //region Static
    //endregion

    public function __construct(TxRegister $txRegister, Mailer $mailer)
    {
        $this->_txRegister = $txRegister;
        $this->_mailer = $mailer;
        $this->log = new PLCustomLog("Register");
    }

    //region Methods

    /**
     * User Register
     * @param PLRequest $request
     * @throws \Exception
     * @return PLResponse
     */
    public function userRegister(PLRequest $request)
    {
        $this->log->info("Registering new user");
        $response = new PLResponse();
        $txResponse = $this->_txRegister->executeTx($request);
        if (is_array($txResponse)) {
            $this->log->info("User registered successfully, begin authentication");
            \Auth::login($txResponse['User']);
            $response->description = 'User registered successfully';
            $response->data = $txResponse;
            $this->sendRegisterEmail($txResponse);
        }
        return $response;
    }

    //endregion

    //region Private Methods

    /**
     * Send the register email
     * @param $txResponse
     */
    private function sendRegisterEmail($txResponse)
    {
        $user    = $txResponse['User'];
        $data    =  array('person' => $txResponse['Person']);
        $options = array(
            'to' => $user->email,
            'bcc' => explode(',', PLConstants::EMAIL_BCC),
            'title' => '¡Bienvenida/o!'
        );
        $this->_mailer->send(PLConstants::EMAIL_REGISTER, $data, $options);
    }
    //endregion

} 