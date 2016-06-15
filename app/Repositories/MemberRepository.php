<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:40 PM
 */

namespace App\Repositories;


use App\Models\Member;

class MemberRepository extends BaseRepository{

    //region attributes

    /**
     * @var Member
     */
    private $_member = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Member $member){
        $this->_member = $member;
    }

    //region Methods

    /**
     * return namaspace for Member Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Member';
    }

    //endregion

    //region Private Methods
    //endregion
}