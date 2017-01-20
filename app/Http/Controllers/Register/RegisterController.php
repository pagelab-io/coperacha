<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\PLController;
use \App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Models\Register;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Register
 */
class RegisterController extends PLController{

    //region attributes

    /**
     * @var Register
     */
    private $_register;

    //endregion

    //region Static methods
    //endregion

    public function __construct(Register $register){
        $this->_register = $register;
    }

    //region Methods
    
    /**
     * register method
     *
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(PLRequest $request)
    {
        // request validation
        $this->validate($request,$request->rules(), $request->messages());
       try{
            $this->setResponse($this->_register->userRegister($request));
            return response()->json($this->getResponse());
       }catch (\Exception $ex){
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
