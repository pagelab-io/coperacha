<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:04 PM
 */

namespace App\Repositories;

use Illuminate\Container\Container as App;
use App\Http\Responses\PLResponse;
use App\Transactions\TxUpdateUser;
use App\Http\Requests\PLRequest;
use App\Entities\Person;
use App\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Mockery\CountValidator\Exception;

class UserRepository extends BaseRepository{

    //region attributes

    /**
     *
     * @var User
     */
    private $_user;

    /**
     * @var TxUpdateUser
     */
    private $_txUpdateUser;

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    //endregion

    //region Static
    //endregion

    public function __construct(App $app, User $user, PersonRepository $personRepository, TxUpdateUser $txUpdateUser)
    {
        parent::__construct($app);
        $this->_user = $user;
        $this->_personRepository = $personRepository;
        $this->_txUpdateUser = $txUpdateUser;
    }

    //region Methods

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    public function model()
    {
        return 'App\Entities\User';
    }

    /**
     * Create a new User in DB
     *
     * @param PLRequest $request
     * @param Person $person
     * @return User
     * @throws \Exception
     */
    public function create(PLRequest $request, Person $person)
    {
        \Log::info("=== User create ===");

        if(!$person) throw new \Exception("Person cannot be null", -1);

        // if person
        $this->_user->person_id = $person->id;
        $this->_user->email = $request->get('email');
        $this->_user->password = ($request->exists('password')) ? bcrypt($request->get('password')) : "";
        $this->_user->username = ($request->exists('username')) ? $request->get('username') : "";

        try{

            $saved = $this->_user->save();
            if(!$saved){
                \Log::info(($person->delete()) ? "user deleted successfully" : "cannot delete user");
                throw new \Exception("Unable to create User");
            }

        }catch (\Exception $ex){
            \Log::info(($person->delete()) ? "user deleted successfully" : "cannot delete user");
            throw $ex;
        }

        \Log::info("=== User created successfully : ".$this->_user." ===");
        return $this->_user;
    }

    /**
     * Update the specified user
     *
     * @param Request $request
     * @return PLResponse
     * @throws \Exception
     */
    public function updateProfile(Request $request)
    {
        $user = null;
        $person = null;

        try {
            $user = $this->byId($request->get('user_id'));
            $person = $user->person;
        }
        catch(\Exception $ex) {
            throw new \Exception("User does not exist", -1, $ex);
        }

        $updateResponse = $this->_txUpdateUser->executeTx($request, [
            'user' => $user,
            'person' => $person
        ]);

        $response = new PLResponse();
        $response->description = 'User was updated successfully';
        $response->data = $updateResponse;

        return $response;
    }

    /**
     * Make a new random password for specific user
     *
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
    public function passwordRecovery(PLRequest $request)
    {
        \Log::info("--- Password Recovery --- ");

        $response = null;

        if ($this->userExist($request->get('email'))) {
            \Log::info("--- generating new password  --- ");
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $newPassword = substr(str_shuffle($characters), 0, 6);
            $this->_user = $this->byEmail(trim($request->get('email')));
            \Log::info("--- freshPassword :: " .$newPassword." ---");
            $this->_user->password = bcrypt($newPassword);
            $this->_user->tracking = 2;
            if (!$this->_user->save()) throw new \Exception("Unable to update User", -1);

            $response = new PLResponse();
            $response->description = 'Password recovered successfully';
            $response->data = true;

        } else {
            throw new \Exception("User does not exist", -1);
        }

        return $response;
    }

    /**
     * Get user by email
     * @param $email
     * @return mixed
     */
    public function byEmail($email)
    {
        return User::where("email", $email)->firstOrFail();
    }

    /**
     * Change the password for specific user
     *
     * @param int $userid
     * @param string $pass
     * @param string $new
     * @param string $confirm
     * @return boolean
     * @throws \Exception
     */
    public function changePassword($userid, $pass, $new, $confirm)
    {
        // Find the user
        $this->_user = $this->byId($userid);

        if ($this->_user->getHasPasswordAttribute()) {

            if (!Hash::check($pass, $this->_user->password)) {
                throw new \Exception("Incorrect password", -1);
            }
        }

        if ($new != $confirm) {
            throw new \Exception("Passwords not are equals", -1);
        }

        // Update new password
        $this->_user->password = Hash::make($new);
        $this->_user->update();

        return true;
    }

    /**
     * Search for user into the DB by email or username
     *
     * @param string $email
     * @param string $username
     * @return bool
     * @throws \Exception
     */
    public function userExist($email = "" , $username = "")
    {
        $count = 0;
        try {

            if (trim($email) != "" && trim($username) != "") {
                $count = User::where('email', $email)->orwhere('username', $username)->count();
            } else if (trim($email) != "") {
                $count = User::where('email', $email)->count();
            } else if (trim($username) != "") {
                $count = User::where('username', $username)->count();
            }

        } catch(\Exception $ex) {
            throw $ex;
        }

        return ($count >= 1) ? true : false;
    }

    /**
     * email login
     *
     * @param PLRequest $request
     * @return PLResponse
     */
    public function login(PLRequest $request)
    {
        \Log::info("=== llegando a login, intentanto validar credenciales ===");
        $auth       = \Auth::attempt(['email' => trim($request->get('email')), 'password' => trim($request->get('password'))]);
        $response   = new PLResponse();
        $user       = null;


        if ($auth) {
            $user = $this->byEmail($request->get('email'));
            \Log::info("=== Auteticación exitosa ===");
            if ($user->tracking == 0) {
                $this->updateTracking($user, 1);
                $user->first_access = 1;
            } else {
                $user->first_access = 0;
            }
            $response->description = 'Login successfully';
            $response->data = $user;
        } else {
            \Log::info("=== Credenciales inválidas ===");
            $response->status = -1;
            $response->description = 'Invalid Credentials';
            $response->data = null;
        }

        return $response;
    }

    /**
     * @param User $user
     * @param $tracking
     * @return User
     */
    public function updateTracking(User $user, $tracking)
    {
        \Log::info("Updatint tracking ...");
        $user->tracking = $tracking;
        if (!$user->save()) throw new Exception("Unable to update user", -1);
        return $user;
    }

    /**
     * Get the user profile
     *
     * @param int $userId
     * @throws \Exception
     * @return mixed
     */
    public function getProfile($userId)
    {
        $user = null;

        try {
            $user = $this->byId($userId);
            $user->person;
            $user->fbuser;

        } catch(\Exception $ex) {
            throw new \Exception("User does not exist", -1, $ex);
        }

        return $user;
    }

    public function logout()
    {
        $response = new PLResponse();
        try {
            \Auth::logout();
            $response->data = true;
            $response->description = "Logout successfully";
        } catch(\Exception $ex) {
            throw new \Exception("Error in logout", -1, $ex);
        }

        return $response;

    }

    //endregion

    //region Private Methods
    //endregion

}