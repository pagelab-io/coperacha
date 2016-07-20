<?php

namespace App\Models;


use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Transactions\TxCreateParticipant;

class ParticipantModel {

    //region Attributes

    /**
     * @var TxCreateParticipant
     */
    private $_txCreateParticipant;

    //endregion

    //region Static methods
    //endregion

    public function __construct(TxCreateParticipant $txCreateParticipant)
    {
        $this->_txCreateParticipant = $txCreateParticipant;
    }

    //region Private methods
    //endregion

    //region Methods

    /**
     *
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
    public function createParticipant(PLRequest $request)
    {
        $person = null;
        $user   = null;

        $txResponse = $this->_txCreateParticipant->executeTx($request);

        if (is_array($txResponse)) {
            $user = $txResponse['user'];
            $person = $txResponse['person'];
        }

        // armamos la respuesta
        $response = new PLResponse();
        $response->data = array('user' => $user, 'person' => $person);

        return $response;
    }

    //endregion
} 