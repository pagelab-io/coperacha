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
use Illuminate\Http\Request;

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
     * Show the register page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request) {
        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        return view('user.create')
            ->with('months', $months)
            ->with('pageTitle','Registro');
    }
    
    /**
     * Show the profile page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProfilePage(Request $request) {
        $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo','Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

        return view('user.profile')
            ->with('months', $months)
            ->with('pageTitle','Mi cuenta');
    }

    /**
     * Show the password page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPasswordPage(Request $request) {

        return view('user.password')
            ->with('pageTitle','Contraseña');
    }

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
        $this->validate($request, $request->rules(), $request->messages());

        try {
            $this->setResponse($this->_userRepository->changePassword($request));
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