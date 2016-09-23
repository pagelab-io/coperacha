<?php

namespace App\Transactions;


use App\Entities\Invitation;
use App\Entities\MemberSetting;
use App\Entities\Moneybox;
use App\Entities\Participant;
use App\Entities\Person;
use App\Entities\Setting;
use App\Entities\SettingOption;
use App\Entities\User;
use App\Http\Requests\PLRequest;
use App\Repositories\MoneyboxRepository;
use App\Repositories\ParticipantRepository;
use App\Repositories\PersonRepository;
use App\Repositories\SettingOptionRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use App\Utilities\PLConstants;

class TxCreateParticipant extends PLTransaction{

    //region Attributes

    /**
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    /**
     * @var ParticipantRepository
     */
    private $_participantRepository;

    /**
     * @var SettingRepository
     */
    private $_settingRepository;

    /**
     * @var SettingOptionRepository
     */
    private $_optionRepository;

    //endregion

    //region Static Methods
    //endregion

    public function __construct(
        UserRepository $userRepository,
        PersonRepository $personRepository,
        MoneyboxRepository $moneyboxRepository,
        ParticipantRepository $participantRepository,
        SettingRepository $settingRepository,
        SettingOptionRepository $optionRepository)
    {
        $this->_userRepository          = $userRepository;
        $this->_personRepository        = $personRepository;
        $this->_moneyboxRepository      = $moneyboxRepository;
        $this->_participantRepository   = $participantRepository;
        $this->_settingRepository       = $settingRepository;
        $this->_optionRepository        = $optionRepository;
    }

    //region Private Methods

    private function createPerson(PLRequest $request)
    {
        \Log::info("=== Creating person ... ===");
        $person             = new Person();
        $person->name       = $request->get('name');
        $person->lastname   = $request->get('lastname');
        $person->phone      = $request->get('phone');
        if (!$person->save()) throw new \Exception("Unable to create Person", -1);
        \Log::info("=== Person created successfully : " . $person . " ===");

        return $person;
    }

    private function createUser(PLRequest $request, Person $person)
    {
        \Log::info("=== Creating user ... ===");
        $user            = new User();
        $user->person_id = $person->id;
        $user->email     = $request->get('email');
        $user->username  = $request->get('email');
        $user->tracking  = -1;
        if (!$user->save()) throw new \Exception("Unable to create User", -1);
        \Log::info("=== User created successfully : ". $user ."===");
        return $user;
    }

    private function createParticipant(Person $person, Moneybox $moneybox)
    {
        // if isn't participant
        \Log::info("=== Creating participant ===");
        $participant = new Participant();
        $participant->person_id = $person->id;
        $participant->moneybox_id = $moneybox->id;
        if (!$participant->save()) throw new \Exception("Unable to create Participant", -1);
        \Log::info("=== Participant created successfully : " . $participant. " ===");
        return $participant;
    }

    private function createSettings(PLRequest $request, Participant $participant){

        \Log::info("=== Creating settings ===");
        $settings = json_decode($request->get('settings'),true);
        $memberSettings = [];

        \Log::info("=== Build MemberSettingsArray ===");
        foreach($settings as $setting){
            try {
                if ($this->_settingRepository->byId($setting['setting_id']) instanceof Setting) {
                    if ($this->_optionRepository->byId($setting['option_id']) instanceof SettingOption) {
                        $ms             = new MemberSetting();
                        $ms->setting_id = $setting['setting_id'];
                        $ms->option_id  = $setting['option_id'];
                        $ms->owner_id   = $participant->id;
                        $ms->owner      = PLConstants::OWNER_PARTICIPANT;
                        $ms->value      = $setting['value'];
                        array_push($memberSettings, $ms);
                    }
                }
            }
            catch(\Exception $ex){
                throw new \Exception("Setting or Option does not exist", -1, $ex);
            }
        }

        \Log::info("=== Iterating in MemberSettingsArray for insert ===");
        foreach ($memberSettings as $memberSetting) {
            if (!$memberSetting->save()) throw new \Exception("Unable to create MemberSetting", -1);
        }
        \Log::info("=== Settings created successfully ===");
    }

    /**
     * Get's the invitation field if exist
     * @param $email
     * @param $moneybox_id
     * @return mixed
     */
    private function getInvitation($email, $moneybox_id)
    {
        if (Invitation::where(['email' => $email, 'moneybox_id' => $moneybox_id])->count() == 1){
            return Invitation::where(['email' => $email, 'moneybox_id' => $moneybox_id])->firstOrFail();
        }
        return null;
    }

    //endregion

    //region Methods

    /**
     * Execute the create participant transaction
     *
     * @param PLRequest $request
     * @param array $params
     * @return array
     * @throws \Exception
     */
    public function executeTx(PLRequest $request, $params = array())
    {

        $response   = array();
        $user       = null;
        $person     = null;

        try {
            \DB::beginTransaction();
            // retrieve person and user
            if ($this->_userRepository->userExist($request->get('email'))) {
                \Log::info("user already exist");
                $user   = $this->_userRepository->byEmail($request->get('email'));
                $person = $user->person;

                // update person before save participation
                $person->name       = $request->get('name');
                $person->lastname   = $request->get('lastname');
                $person->phone      = $request->get('phone');
                if (!$person->save()) throw new \Exception("Unable to update person", -1);

            } else {
                $person = $this->createPerson($request);
                $user   = $this->createUser($request, $person);
            }
            // check the moneybox existence
            $moneybox = $this->_moneyboxRepository->byId($request->get("moneybox_id"));
            if (!$moneybox instanceof Moneybox) throw new \Exception("Moneybox does not exist", -1);
            // check for participation in selected moneybox
            if ($this->_participantRepository->isParticipant($person->id, $moneybox->id)) {
                \Log::info("is participant");

                // update invitation's table
                $invitation = $this->getInvitation($user->email, $moneybox->id);
                if($invitation instanceof Invitation){
                    $invitation->status=1;
                    if (!$invitation->save()) throw new \Exception("Unable to update invitation", -1);
                }

                $response['user']   = $user;
                $response['person'] = $person;
                return $response;
            }
            // create participant
            $participant = $this->createParticipant($person, $moneybox);

            // update invitation's table
            $invitation = $this->getInvitation($user->email, $moneybox->id);
            if($invitation instanceof Invitation){
                $invitation->status=1;
                if (!$invitation->save()) throw new \Exception("Unable to update invitation", -1);
            }

            // create participant settings
            $this->createSettings($request, $participant);
            \DB::commit();
        } catch(\Exception $ex) {
            \Log::info("=== Executing rollback ... ===");
            \DB::rollback();
            throw $ex;
        }
        $response['user']   = $user;
        $response['person'] = $person;
        return $response;
    }

    //endregion

}