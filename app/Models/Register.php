<?php

namespace App\Models;

use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Transactions\TxRegister;

class Register {

    //region attributes

    /**
     * @var TxRegister
     */
    private $_txRegister;

    //endregion

    //region Static
    //endregion

    public function __construct(TxRegister $txRegister)
    {
        $this->_txRegister = $txRegister;
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
        }

        return $response;

    }

    //endregion

    //private Methods
    //endregion

} 