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

class FbUserRepository extends BaseRepository{

    //region attributes

    /**
     * @var FbUser
     */
    private $_fbUser = null;

    //endregion

    //region Static
    //endregion

    public function __construct(FbUser $fbUser){
        $this->_fbUser = $fbUser;
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
     * @return bool
     */
    public function login(PLRequest $request)
    {
        return true;
    }
    //endregion

    //region Private Methods
    //endregion

}