<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 05/07/2016
 * Time: 05:23 PM
 */
namespace App\Http\Controllers\User;

use \App\Http\Controllers\PLController;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Models\Person;
use App\Models\User;
use App\Repositories\PersonRepository;
use App\Repositories\UserRepository;

class UserController extends PLController{

    //region attributes

    /**
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    //endregion

    //region Static methods
    //endregion

    public function __construct(UserRepository $userRepository, PersonRepository $personRepository)
    {
        $this->_userRepository = $userRepository;
        $this->_personRepository = $personRepository;
    }

    //region Methods

    /**
     * Get the profile for a specific user
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());
        try {
            $this->setResponse($this->_userRepository->getProfile($request));
            return response()->json($this->getResponse());
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }

    }

    /**
     * Update the user attributes
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(PLRequest $request)
    {
        \Log::info("llega a controller");
        $this->validate($request, $request->rules(), $request->messages());

        \Log::info("pasa validacion");
        try {
            $this->setResponse($this->_userRepository->updateProfile($request));
            return response()->json($this->getResponse());
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
            return response()->json($response);
        }

    }


    public function changePassword(PLRequest $request)
    {
        /*$this->validate($request, $request->rules(), $request->messages());

        try {

            if ($this->_userRepository->changePassword($request)) {
                $this->_response['data'] = true;
                $this->_response['description'] = "password changed successfully";
            } else {
                $this->_response['data'] = false;
                $this->_response['description'] = "password cannot be changed";
            }

            return response()->json($this->_response);

        } catch(\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }*/
    }

    //endregion

    //region Private Methods
    //endregion

} 