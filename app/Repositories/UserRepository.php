<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:04 PM
 */

namespace App\Repositories;

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

    public function login()
    {
        return true;
    }

    //endregion

    //region Private Methods
    //endregion

}