<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Repositories\UserRepository;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class PasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/user/profile/';

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
    /**
     * Override
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEmail(Request $request){
        return view('auth.passwords.email', ['pageTitle' => 'Recuperar contraseña']);
    }

    /**
     * Override
     * @param Request $request
     * @param string $token
     * @param string $email
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getReset(Request $request, $token = null, $email= null){
        return view('auth.passwords.reset', [
            'pageTitle' => 'Actualizar contraseña',
            'token' => $token,
            'email' => $email
        ]);
    }

    /**
     * @param PLRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
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
