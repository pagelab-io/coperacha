<?php

namespace App\Http\Controllers\Participant;

use \App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Models\Moneybox;
use App\Models\Participant;
use App\Models\Person;
use App\Repositories\MemberSettingRepository;
use App\Repositories\MoneyboxRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;

class ParticipantController extends PLController {

    //region attributes

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    /**
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * @var ParticipantRepository
     */
    private $_participantRepository;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    /**
     * @var MemberSettingRepository
     */
    private $_memberSettingRepository;

    //endregion

    //region Static methods
    //endregion

    public function __construct(
        PersonRepository $personRepository,
        UserRepository $userRepository,
        ParticipantRepository $participantRepository,
        MoneyboxRepository $moneyboxRepository)
    {
        $this->_personRepository = $personRepository;
        $this->_userRepository = $userRepository;
        $this->_participantRepository = $participantRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
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
        $this->validate($request,$request->rules(),$request->messages());

        try {

            $person = null;
            $user   = null;

            // obtain or create user and person
            if ($this->_userRepository->userExist($request->get('email'))) {
                $user = $this->_userRepository->byEmail($request->get('email'));
                $person = $user->person;
            } else {
                $person = $this->_personRepository->create($request);
                if ($person instanceof Person)
                    $user = $this->_userRepository->create($request, $person);
            }

            //obtain the moneybox
            $moneybox = $this->_moneyboxRepository->byId($request->get("moneybox_id"));

            if ($moneybox instanceof Moneybox) {

                // create participant
                $participant = $this->_participantRepository->create($person, $moneybox);

                if ($participant instanceof Participant) {
                    // create participant settings
                    //$this->_memberSettingRepository->setSettings($request, $participant);
                    $this->_response['description'] = "Participant was created successfully";
                    $participant->person;
                    $participant->moneybox;
                    $this->_response['data'] = $participant;
                }

            } else {
                throw new \Exception("Moneybox does not exist", -1);
            }

            return response()->json($this->_response);

        }
        catch (\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }

    }

    //endregion

    //region Private Methods
    //endregion

} 