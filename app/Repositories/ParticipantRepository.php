<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:40 PM
 */

namespace App\Repositories;


use App\Models\Participant;

class ParticipantRepository extends BaseRepository{

    //region attributes

    /**
     * @var Participant
     */
    private $_participant = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Participant $participant){
        $this->_participant = $participant;
    }

    //region Methods

    /**
     * return namaspace for Member Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Participant';
    }

    //endregion

    //region Private Methods
    //endregion
}