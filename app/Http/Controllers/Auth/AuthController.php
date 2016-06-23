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

        $this->validate($request, $request->rules(), $request->messages());

        return response()->json();
    }

    //endregion

    //region Private Methods
    //endregion



}
