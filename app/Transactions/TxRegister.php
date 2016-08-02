<?php

namespace App\Transactions;

use App\Entities\FbUser;
use App\Entities\Person;
use App\Entities\User;
use App\Http\Requests\PLRequest;
use App\Repositories\UserRepository;

class TxRegister extends PLTransaction{

    //region attributes

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
    }

    //region Private methods
    //endregion

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

        if ($this->_userRepository->userExist($request->get('email'))){
            $user = $this->_userRepository->byEmail($request->get('email'));

            // if user is visitant but he has tracking 0 or 1 (first access or user active)
            if ($user->tracking == 0 || $user->tracking == 1) throw new \Exception ("User already exist", -2);

            if ($user->tracking == -1) { // just update data becasuse he should be visitant

                try {

                    \DB::beginTransaction();

                    \Log::info("=== Updating person ... ===");
                    $person             = $user->person;
                    $person->name       = $request->get('name');
                    $person->lastname   = $request->get('lastname');
                    if (!$person->save()) throw new \Exception("Unable to update Person", -1);
                    \Log::info("=== Person created successfully : " . $person . " ===");

                    \Log::info("=== Updating user ... ===");
                    $user->password  = bcrypt($request->get('password'));
                    $user->tracking  = 0;
                    if (!$user->save()) throw new \Exception("Unable to update User", -1);
                    \Log::info("=== User created successfully : ".$user." ===");

                    if ($request->get('isFB') == 1) \Log::info("TODO -  do something");

                    \DB::commit();

                    $response['Person'] = $person;
                    $response['User']   = $user;
                    $response['FbUser'] = $fbUser;

                } catch(\Exception $ex) {
                    \Log::info("=== Executing rollback ... ===");
                    \DB::rollback();
                    throw $ex;
                }

            }

        } else {

            try {

                \DB::beginTransaction();

                \Log::info("=== Creating person ... ===");
                $person             = new Person();
                $person->name       = $request->get('name');
                $person->lastname   = $request->get('lastname');
                if (!$person->save()) throw new \Exception("Unable to create Person", -1);
                \Log::info("=== Person created successfully : " . $person . " ===");


                \Log::info("=== Creating user ... ===");
                $user            = new User();
                $user->person_id = $person->id;
                $user->email     = $request->get('email');
                $user->password  = ($request->exists('facebook_uid')) ? '' : bcrypt($request->get('password'));
                $user->username  = $request->get('email');
                if (!$user->save()) throw new \Exception("Unable to create User", -1);
                \Log::info("=== User created successfully : ".$user." ===");

                if ($request->get('isFB') == 1) {

                    \Log::info("=== Creating FBUser ... ===");
                    $fbUser = new FbUser();
                    $fbUser->user_id = $user->id;
                    $fbUser->fb_uid = $request->get('facebook_uid');
                    if (!$fbUser->save()) throw new \Exception("Unable to create FBUser", -1);
                    \Log::info("=== FBUser created successfully : ".$fbUser." ===");

                }

                \DB::commit();

                $response['Person'] = $person;
                $response['User']   = $user;
                $response['FbUser'] = $fbUser;

            } catch(\Exception $ex) {
                \Log::info("=== Executing rollback ... ===");
                \DB::rollback();
                throw $ex;
            }
        }

        return $response;

    }

    //endregion

}