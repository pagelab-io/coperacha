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
            $this->_response['data'] = $this->_userRepository->getProfile($request);
            $this->_response['description'] = "Profile obtained successfully";
            return response()->json($this->_response);
        } catch(\Exception $ex) {
            $this->_response['status'] = $ex->getCode();
            $this->_response['description'] = $ex->getMessage();
            $this->_response['data'] = $ex->getTraceAsString();
            return response()->json($this->_response);
        }

    }

    public function updateProfile(PLRequest $request)
    {
        $this->validate($request, $request->rules(), $request->messages());
        $response = [];
        try {

            $person = $this->_personRepository->update($request);
            $user = $this->_userRepository->update($request);

            if ($person instanceof Person && $user instanceof User) {
                $response['person'] = $person;
                $response['user'] = $user;
            }

            $this->_response['description'] = "User was updated successfully";
            $this->_response['data'] = $response;
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