<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:40 PM
 */

namespace App\Repositories;

use App\Entities\Participant;

class ParticipantRepository extends BaseRepository{

    //region attributes


    //endregion

    //region Static
    //endregion

    public function __construct(){
    }

    //region Methods

    /**
     * return namaspace for Member Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Participant';
    }


    public function isParticipant($person_id, $moneybox_id)
    {
        $count = Participant::where(['person_id'=>$person_id, 'moneybox_id' => $moneybox_id])->count();
        return ($count > 0) ? true:false;
    }

    //endregion

    //region Private Methods
    //endregion
}