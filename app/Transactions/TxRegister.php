<?php

namespace App\Transactions;

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

        if ($this->_userRepository->userExist($request->get('email'))) throw new \Exception ("User already exist", -2);

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
            $user->password  = md5($request->get('password'));
            $user->username  = $request->get('email');
            if (!$user->save()) throw new \Exception("Unable to create User", -1);
            \Log::info("=== User created successfully : ".$user." ===");


            if ($request->get('isFB') == 1) \Log::info("TODO -  create FBUser");

            \DB::commit();

            $response['Person'] = $person;
            $response['User']   = $user;
            $response['FbUser'] = $fbUser;

        } catch(\Exception $ex) {
            \Log::info("=== Executing rollback ... ===");
            \DB::rollback();
            throw $ex;
        }

        return $response;

    }

    //endregion

}