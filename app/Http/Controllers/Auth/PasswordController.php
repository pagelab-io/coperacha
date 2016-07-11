<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
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

            if ($this->_userRepository->passwordRecovery($request)) {
                $this->_response['description'] = "Password recovered successfully";
                $this->_response['data'] = true;
            }
            return response()->json($this->_response);

        } catch(\Exception $ex) {
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
