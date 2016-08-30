<?php

namespace App\Models;

use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Transactions\TxRegister;
use App\Utilities\PLConstants;

class Register {

    //region attributes

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
    }

    //region Methods

    /**
     * @param PLRequest $request
     * @throws \Exception
     * @return PLResponse
     */
    public function userRegister(PLRequest $request)
    {
        $txRegister = $this->_txRegister->executeTx($request);
        $response = new PLResponse();

        if (is_array($txRegister)) {
            \Log::info("Usuario registrado correctamente, comenzando autenticación");
            \Auth::login($txRegister['User']);
            $response->description = 'User registered successfully';
            $response->data = $txRegister;

            // send email
            $data = array(
                'person' => $txRegister['Person']
            );
            $user = $txRegister['User'];
            $options = array(
                'to' => $user->email,
                'bcc' => explode(',', PLConstants::EMAIL_BCC),
                'title' => '¡Bienvenida/o!'
            );
            $this->_mailer->send(PLConstants::EMAIL_REGISTER, $data, $options);

        }

        return $response;

    }

    //endregion

    //private Methods
    //endregion

} 