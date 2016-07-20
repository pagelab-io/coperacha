<?php

namespace App\Http\Controllers\Participant;

use \App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Models\Moneybox;
use App\Models\Participant;
use App\Models\ParticipantModel;
use App\Models\Person;
use App\Repositories\MemberSettingRepository;
use App\Repositories\MoneyboxRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;

class ParticipantController extends PLController {

    //region attributes

    /**
     * @var ParticipantModel
     */
    private $_participant;

    //endregion

    //region Static methods
    //endregion

    public function __construct(ParticipantModel $participant)
    {
        $this->_participant = $participant;
    }

    //region Methods

    /**
     * register method
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createParticipant(PLRequest $request)
    {

        // validate the request
        $this->validate($request, $request->rules(),$request->messages());

        try {
            $this->setResponse($this->_participant->createParticipant($request));
            return response()->json($this->getResponse());
        }
        catch (\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }

    }

    //endregion

    //region Private Methods
    //endregion

} 