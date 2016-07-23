<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\PLController;
use \App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Models\Register;
use Illuminate\Support\Facades\Mail;

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

        // validate the request
        $this->validate($request,$request->rules(),$request->messages());

        // execute register
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

    public function emailTest()
    {
        \Log::info("Enviando email ...");
        Mail::send('emails.test', [] , function ($m){
            $m->from('no-reply@pagelab.io', 'PageLab');
            $m->to('super_puma_05@hotmail.com', "Emmanuel", 'sanchezz985@gmail.com', 'Emmanuel')->subject('Prueba !');
        });
        \Log::info("email enviado");
        \Log::info("");
    }

    //endregion

    //region Private Methods
    //endregion
}
