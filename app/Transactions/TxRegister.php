<?php

namespace App\Transactions;

use App\Entities\FbUser;
use App\Entities\Person;
use App\Entities\User;
use App\Http\Requests\PLRequest;
use App\Repositories\UserRepository;
use App\Utilities\PLCustomLog;

/**
 * Register's transaction
 * Class TxRegister
 * @package App\Transactions
 */
class TxRegister extends PLTransaction {

    //region attributes

    /**
     * @var PLCustomLog;
     */
    public $log;

    /**
     * @var UserRepository
     */
    private $_userRepository;


    //endregion

    //region Static
    //endregion

    public function __construct(UserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
        $this->log = new PLCustomLog("TxRegister");
    }

    //region methods

    /**
     * Execute the transaction for register a new user
     *
     * @param PLRequest $request
     * @param array $params
     * @throws \Exception
     * @return array
     */
    public function executeTx(PLRequest $request, $params = array())
    {
        $response   = array();
        $fbUser     = null;
        $user       = null;
        $this->log->info("Executing register transaction");
        if ($this->_userRepository->userExist($request->get('email'))) {
            $user = $this->_userRepository->byEmail($request->get('email'));

            // if user is visitant but he has tracking 0 or 1 (first access or user active)
            if ($user->tracking == 0 || $user->tracking == 1) throw new \Exception ("User already exist", -2);
            if ($user->tracking == -1) { // just update data becasuse he should be visitant

                try {

                    \DB::beginTransaction();
                    $person = $this->updatePerson($request, $user);
                    $user    = $this->updateUser($request, $user);
                    if ($request->get('isFB') == 1)
                        $fbUser = $this->createFacebookUser($request, $user);
                    \DB::commit();

                    $response['Person'] = $person;
                    $response['User']   = $user;
                    $response['FbUser'] = $fbUser;

                } catch(\Exception $ex) {
                    $this->log->info("Executing rollback");
                    \DB::rollback();
                    throw $ex;
                }
            }

        } else {

            try {

                \DB::beginTransaction();
                $person = $this->createPerson($request);
                $user = $this->createUser($request, $person);
                if ($request->get('isFB') == 1)
                    $this->createFacebookUser($request, $user);
                \DB::commit();
                $response['Person'] = $person;
                $response['User']   = $user;
                $response['FbUser'] = $fbUser;

            } catch(\Exception $ex) {
                $this->log->info("Executing rollback");
                \DB::rollback();
                throw $ex;
            }
        }

        return $response;
    }

    //endregion

    //region Private methods

    /**
     * Create a new Person
     * @param PLRequest $request
     * @throws \Exception
     * @return Person
     */
    private function createPerson(PLRequest $request)
    {
        $this->log->info("Creating person");
        $person                 = new Person();
        $person->name        = $request->get('name');
        $person->lastname    = $request->get('lastname');
        if($request->exists('birthday')) $person->birthday = $request->get('birthday');
        if($request->exists('gender')) $person->gender = $request->get('gender');
        if($request->exists('phone')) $person->phone = $request->get('phone');
        if($request->exists('city')) $person->city = $request->get('city');
        if($request->exists('country')) $person->country = $request->get('country');
        if (!$person->save()) throw new \Exception("Unable to create Person", -1);
        $this->log->info("Person created successfully : ". $person);
        return $person;
    }

    /**
     * Create a new User
     * @param PLRequest $request
     * @param Person $person
     * @throws \Exception
     * @return User
     */
    private function createUser(PLRequest $request, Person $person)
    {
        $this->log->info("Creating user");
        $user            = new User();
        $user->person_id = $person->id;
        $user->email     = $request->get('email');
        $user->password  = ($request->exists('facebook_uid')) ? '' : bcrypt($request->get('password'));
        $user->username  = ($request->exists('username')) ? $request->get('username') : $request->get('email');
        if (!$user->save()) throw new \Exception("Unable to create User", -1);
        $this->log->info("User created successfully : ".$user);
        return $user;
    }

    /**
     * Create a new Facebook User
     * @param PLRequest $request
     * @param User $user
     * @return FbUser
     * @throws \Exception
     */
    private function createFacebookUser(PLRequest $request, User $user)
    {
        $this->log->info("Creating FBUser");
        $fbUser = new FbUser();
        $fbUser->user_id = $user->id;
        $fbUser->fb_uid = $request->get('facebook_uid');
        if (!$fbUser->save()) throw new \Exception("Unable to create FBUser", -1);
        $this->log->info("FBUser created successfully : ".$fbUser);
        return $fbUser;
    }

    /**
     * Update person
     * @param PLRequest $request
     * @param User $user
     * @throws \Exception
     * @return Person
     */
    private function updatePerson(PLRequest $request, User $user)
    {
        $this->log->info("Updating person");
        $person                = $user->person;
        $person->name       = $request->get('name');
        $person->lastname   = $request->get('lastname');
        if($request->exists('birthday')) $person->birthday = $request->get('birthday');
        if($request->exists('gender')) $person->gender = $request->get('gender');
        if($request->exists('phone')) $person->phone = $request->get('phone');
        if($request->exists('city')) $person->city = $request->get('city');
        if($request->exists('country')) $person->country = $request->get('country');
        if (!$person->save()) throw new \Exception("Unable to update Person", -1);
        $this->log->info("Person updated successfully : ".$person);
        return $person;
    }

    /**
     * Update user
     * @param PLRequest $request
     * @param User $user
     * @return User
     * @throws \Exception
     */
    private function updateUser(PLRequest $request, User $user)
    {
        $this->log->info("Updating user");
        $user->tracking  = 0;
        if ($request->get('isFB') == 0)
            $user->password  = bcrypt($request->get('password'));
        if (!$user->save())
            throw new \Exception("Unable to update User", -1);
        $this->log->info("User updated successfully : ".$user);
        return $user;
    }

    //endregion


}