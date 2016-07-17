<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:04 PM
 */

namespace App\Repositories;

use Illuminate\Container\Container as App;
use App\Http\Requests\PLRequest;
use App\Entities\Person;
use App\Entities\User;

class UserRepository extends BaseRepository{

    //region attributes

    /**
     *
     * @var User
     */
    private $_user = null;

    //endregion

    //region Static
    //endregion

    public function __construct(App $app, User $user)
    {
        parent::__construct($app);
        $this->_user = $user;
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
        $this->_user->password = ($request->exists('password')) ? md5($request->get('password')) : "";
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
     * @param PLRequest $request
     * @return User
     * @throws \Exception
     */
    public function update(PLRequest $request)
    {
        try{
            $this->_user = $this->byId($request->get('user_id'));
            if ($request->exists('email')) $this->_user->email = $request->get('email');
            if ($request->exists('username')) $this->_user->username = $request->get('username');

            if ($request->exists('method') && ($request->get('method') == 'changePassword')) {
                if ($request->exists('newPassword')) $this->_user->password = md5($request->get('newPassword'));
            }

            if (!$this->_user->save()) throw new \Exception("Unable to update User", -1);
        } catch(\Exception $ex) {
            throw new \Exception("User does not exist", -1, $ex);
        }
        return $this->_user;
    }

    /**
     * Make a new random password for specific user
     * // TODO - al hacer este proceso te deberia mandar a cambiar tu contraseña en el primer login que hagas.
     *
     * @param PLRequest $request
     * @return bool
     * @throws \Exception
     */
    public function passwordRecovery(PLRequest $request)
    {
        \Log::info("--- Password Recovery --- ");

        // buscar por email
        if ($this->userExist($request->get('email'))) {
            \Log::info("--- generating new password  --- ");
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $newPassword = substr(str_shuffle($characters), 0, 6);
            $this->_user = $this->byEmail(trim($request->get('email')));
            \Log::info("--- freshPassword :: " .$newPassword." ---");
            $this->_user->password = md5($newPassword);
            if (!$this->_user->save()) throw new \Exception("Unable to update User", -1);

        } else {
            throw new \Exception("User does not exist", -1);
        }

        return true;
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
     * @param PLRequest $request
     * @return bool|\Exception
     * @throws \Exception
     */
    public function changePassword(PLRequest $request)
    {
        if (User::where(
                [
                    'password' => md5($request->get('currentPassword')),
                    'id' => $request->get('user_id')
                ])->count() <= 0) throw new \Exception("Incorrect password", -1);

        $password = $request->get('newPassword');
        $passwordConfirm = $request->get('passwordConfirm');

        if ($password != $passwordConfirm) throw new \Exception("Passwords not are equals", -1);

        return ($this->update($request) instanceof User) ? true:false;

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

        try{

            if (trim($email) != "" && trim($username) != "") {
                $count = User::where('email', $email)->orwhere('username', $username)->count();
            } else if (trim($email) != "") {
                $count = User::where('email', $email)->count();
            } else if (trim($username) != "") {
                $count = User::where('username', $username)->count();
            }

        }catch(\Exception $ex){
            throw $ex;
        }

        return ($count >= 1) ? true : false;
    }

    /**
     * email login
     *
     * @param PLRequest $request
     * @return bool
     */
    public function login(PLRequest $request)
    {
        $count = User::where(['email' => trim($request->get('email')), 'password' => md5(trim($request->get('password')))])->count();
        return ($count == 1) ? true : false;
    }

    /**
     * Get the user profile
     *
     * @param PLRequest $request
     * @throws \Exception
     * @return mixed
     */
    public function getProfile(PLRequest $request)
    {
        try{
            $user = $this->byId($request->get('user_id'));
            $user->person;
            return $user;
        } catch(\Exception $ex){
            throw new \Exception("User does not exist", -1, $ex);
        }
    }

    //endregion

    //region Private Methods
    //endregion

}