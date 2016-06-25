<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Repositories\FbUserRepository;
use App\Repositories\UserRepository;

class AuthController extends PLController
{

    //region attributes

    /**
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * @var FbUserRepository
     */
    private $_fbUserRepository;

    //endregion

    //region Static methods
    //endregion

    public function __construct(UserRepository $userRepository, FbUserRepository $fbUserRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_fbUserRepository = $fbUserRepository;
    }

    //region Methods

    /**
     * login method
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(PLRequest $request){

        // validate request
        $this->validate($request, $request->rules(), $request->messages());

        try {

            // get login response
            $response = ($request->get('isFB') == 0) ? $this->_userRepository->login($request) : $this->_fbUserRepository->login($request);

            if ($response) {
                $this->_response['status'] = 200;
                $this->_response['description'] = "Login successfully";
            } else {
                $this->_response['status'] = -1;
                $this->_response['description'] = "Invalid Credentials";
            }

            $this->_response['data'] = $response;
            return response()->json($this->_response);

        } catch(\Exception $ex){
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
