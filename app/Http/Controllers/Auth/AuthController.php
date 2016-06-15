<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;

class AuthController extends Controller
{

    //region attributes

    /**
     * @var UserRepository
     */
    private $_userRepository = null;

    private $_response = ['status' => 0,'description' => null,'data' => null];

    //endregion

    //region Static methods
    //endregion

    public function __construct(UserRepository $userRepository)
    {
        $this->_userRepository = $userRepository;
    }

    //region Methods

    public function login()
    {

        if ($this->_userRepository->login()) {
            $this->_response['status'] = 0;
            $this->_response['description'] = 'login exitoso';
            $this->_response['data'] = true;
        } else{
            $this->_response['status'] = -1;
            $this->_response['description'] = 'Usuario y/o contraseña inválidos';
            $this->_response['data'] = false;
        }

        return response()->json($this->_response);
    }

    //endregion

    //region Private Methods
    //endregion


}
