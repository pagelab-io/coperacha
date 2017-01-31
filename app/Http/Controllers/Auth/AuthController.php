<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Repositories\FbUserRepository;
use App\Repositories\UserRepository;
use App\Utilities\PLMessageManager;
use Illuminate\Contracts\Logging\Log;

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

        try {
            $this->validate($request, $request->rules(), $request->messages());
            $response = ($request->get('isFB') == 0) ? $this->_userRepository->login($request) : $this->_fbUserRepository->login($request);
            $this->setResponse($response);
            return response()->json($this->getResponse());
        } catch(\Exception $ex) {
            return response()->json(PLMessageManager::managerException($ex));
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        \Auth::logout();
        return redirect()->guest('/');
        /*
        try {
            // get login response
            $response = $this->_userRepository->logout();
            $this->setResponse($response);
            return response()->json($this->getResponse());

        } catch(\Exception $ex){
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }*/
    }

    /**
     * Update tracking
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeTracking(PLRequest $request)
    {
        $response = new PLResponse();
        try {
            $user = $this->_userRepository->byUsername($request->get('user')['username']);
            $this->_userRepository->updateTracking($user, $request->get('tracking'));
            $response->description = "tracking updated successfully";
            $this->setResponse($response);
            return response()->json($this->getResponse());

        } catch(\Exception $ex) {
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
