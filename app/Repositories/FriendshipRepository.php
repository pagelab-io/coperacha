<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:28 PM
 */

namespace App\Repositories;


use App\Models\Friendship;

class FriendshipRepository extends BaseRepository
{

    //region attributes

    /**
     * @var Friendship
     */
    private $_friendship = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Friendship $friendship)
    {
        $this->_friendship = $friendship;
    }

    //region Methods

    /**
     * return namespace for Friendship model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Friendship';
    }

    //endregion

    //region Private Methods
    //endregion
}