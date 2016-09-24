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
use Illuminate\Support\Facades\Auth;

class UserController extends PLController {

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
        $months = [
              '01' => 'Enero'
            , '02' => 'Febrero'
            , '03' => 'Marzo'
            , '04' => 'Abril'
            , '05' => 'Mayo'
            , '06' => 'Junio'
            , '07' => 'Julio'
            , '08' => 'Agosto'
            , '09' => 'Septiembre'
            , '10' => 'Octubre'
            , '11' => 'Noviembre'
            , '12' => 'Diciembre'];

        return view('user.profile')
            ->with('months', $months)
            ->with('user', Auth::user())
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
     * Show the password page
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getContactsPage(Request $request) {

        return view('user.contacts')
            ->with('pageTitle','Contactos');
    }

    /**
     * Get the profile for a specific user
     *
     * @param int $userid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile($userid)
    {
        /* $this->validate($request, $request->rules(), $request->messages()); */
        $response = new PLResponse();

        try {
            $user = $this->_userRepository->getProfile($userid);

            $response->description = 'Getting user profile successfully';
            $response->data = $user;
            $this->setResponse($response);

        } catch(\Exception $ex) {

            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();

            $this->setResponse($response);
        }


        return response()->json($this->getResponse());
    }

    /**
     * Update the user attributes
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        // $this->validate($request, $request->rules(), $request->messages());
        try {
            $this->setResponse($this->_userRepository->updateProfile($request));
            $response = $this->getResponse();
        } catch(\Exception $ex) {
            $response = new PLResponse();
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
        }

        return response()->json($response);
    }

    /**
     * Change password
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(Request $request)
    {
        // $this->validate($request, $request->rules(), $request->messages());
        $response = new PLResponse();
        try {

            $userid = $request->get('user_id');
            $current = $request->get('currentPassword');
            $password = $request->get('newPassword');
            $confirm = $request->get('passwordConfirm');
            $success = $this->_userRepository->changePassword($userid, $current, $password, $confirm);

            if ($success) {
                $response->status = 1;
                $response->description = 'Contraseña actualizada correctamente.';
                $response->data = $success;
                $this->setResponse($response);
            }

        } catch(\Exception $ex) {
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();

            $this->setResponse($response);
        }

        return response()->json($this->getResponse());
    }

    //endregion

    //region Private Methods
    //endregion

} 