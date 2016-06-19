<?php

namespace App\Http\Controllers\Register;

use App\Http\PLController;
use App\Http\PLRequest;
use App\Models\Person;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;
use Log;

class RegisterController extends PLController{

    //region attributes

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    /**
     * @var UserRepository
     */
    private $_userRepository;

    //endregion

    //region Static methods
    //endregion

    public function __construct(PersonRepository $personRepository, UserRepository $userRepository)
    {
        $this->_personRepository = $personRepository;
        $this->_userRepository = $userRepository;
    }

    //region Methods

    public function register(PLRequest $request)
    {

        try {

            $person = null;
            $user   = null;
            $fbUser = null;

            // print request
            $this->printRequest($request);

            // step 1: check for user existence
            if ($this->_userRepository->userExist($request->get('email'))) {
                throw new \Exception ("User already exist", -2);
            } else {

                // step 1: create person
                $person = $this->_personRepository->create($request);

                if ($person instanceof Person)
                {

                    // step 2: create user
                    $user = $this->_userRepository->create($request, $person);

                    if ($request->get('isFB') == 1) {
                        \Log::info("FBUser");
                    }

                }

                // return response
                $this->_response['description'] = "Registro realizado correctamente";
                $this->_response['data'] = array([
                    'Person' => $person,
                    'User' => $user,
                    'FBUser' => $fbUser
                ]);
                $this->printResponse($this->_response, $request->getSession()->getId());
                return response()->json($this->_response);
            }

        }
        catch (\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            $this->printResponse($this->_response, $request->getSession()->getId());
            return response()->json($this->_response);
        }

    }

    //endregion

    //region Private Methods
    //endregion


}
