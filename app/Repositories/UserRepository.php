<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:04 PM
 */

namespace App\Repositories;

use App\Http\Requests\PLRequest;
use App\Models\Person;
use App\Models\User;

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

    public function __construct(User $user)
    {
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
        return 'App\Models\User';
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
        $this->_user->password = md5($request->get('password'));
        $this->_user->username = $request->get('email'); // for first time we add the email into the username

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
     * Set the default values for user
     */
    public function setDefault()
    {
        $this->_user->firstaccess = 0;
        $this->_user->username = "";
    }

    //endregion

    //region Private Methods
    //endregion

}