<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Repositories\UserRepository;

class PasswordController extends PLController
{

    //region attributes

    /**
     * @var UserRepository
     */
    private $_userRepository;
    //endregion

    //region Static methods
    //endregion

    public function __construct(UserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
    }

    //region Methods

    public function passwordRecovery(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());

        try {
            $this->setResponse($this->_userRepository->passwordRecovery($request));
            return response()->json($this->getResponse());

        } catch(\Exception $ex) {
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
