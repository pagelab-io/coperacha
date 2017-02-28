<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:25 PM
 */

namespace App\Repositories;


use App\Http\Requests\PLRequest;
use App\Entities\FbUser;
use App\Http\Responses\PLResponse;
use App\Utilities\PLCustomLog;

class FbUserRepository extends BaseRepository{

    //region attributes

    /**
     * @var PLCustomLog
     */
    public $log;

    /**
     * @var FbUser
     */
    private $_fbUser;

    /**
     * @var UserRepository
     */
    private $_userRepository;
    //endregion

    //region Static
    //endregion

    public function __construct(FbUser $fbUser, UserRepository $userRepository){
        $this->_fbUser = $fbUser;
        $this->_userRepository = $userRepository;
        $this->log = new PLCustomLog("FbUserRepository");
    }

    //region Methods
    /**
     * return namespace for FbUser Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\FbUser';
    }

    /**
     * Facebook login
     *
     * @param PLRequest $request
     * @throws \Exception
     * @return PLResponse
     */
    public function login(PLRequest $request)
    {
        $this->log->info("login by Facebook");
        $count      = \DB::table('users')
                        ->join('fbusers', 'users.id', '=', 'fbusers.user_id')
                        ->select('*')
                        ->where([
                            'email'=>$request->get('email'),
                            'fb_uid'=>$request->get('facebook_uid'),
                        ])
                        ->count();

        $response   = new PLResponse();
        $user       = null;
        $fbUser     = null;

        if ($count == 1) {

            $user = $this->_userRepository->byEmail($request->get('email'));
            \Auth::login($user);
            $this->log->info("correct credentials");
            $fbUser = $this->byUID($request->get('facebook_uid'));

            if ($user->tracking == 0) {
                $user->tracking = 1;
                if (!$user->save()) throw new \Exception("Unable to update user", -1);
                $user->first_access = 1;
            } else {
                $user->first_access = 0;
            }
            $user->fbUser = $fbUser;
            $response->description = 'Login successfully';
            $response->data = $user;

        } else {
            $this->log->info("invalid credentials");
            $response->status = -1;
            $response->description = 'Invalid Credentials';
            $response->data = null;
        }

        return $response;
    }

    /**
     * get a fbUser by facebook_uid
     * @param $fb_uid
     * @return mixed
     */
    public function byUID($fb_uid)
    {
        return FBUser::where("fb_uid", $fb_uid)->firstOrFail();
    }

    //endregion

    //region Private Methods
    //endregion

}