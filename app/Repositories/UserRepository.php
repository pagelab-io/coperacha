<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:04 PM
 */

namespace App\Repositories;

use App\Http\PLRequest;
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

        try{

            $saved = $this->_user->save();
            if(!$saved){
                \Log::info(($person->delete()) ? "user deleted successfully" : "cannot delete user");
                throw new \Exception("Unable to create User");
            }

        }catch (\Exception $ex){
            $person->delete();
            throw $ex;
        }


        \Log::info("=== User created successfully : ".$this->_user." ===");
        return $this->_user;
    }

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

            return ($count >= 1) ? true : false;

        }catch(\Exception $ex){
            return $ex;
        }
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