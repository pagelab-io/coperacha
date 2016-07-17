<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:40 PM
 */

namespace App\Repositories;


use Illuminate\Container\Container as App;
use App\Models\Moneybox;
use App\Models\Participant;
use App\Models\Person;

class ParticipantRepository extends BaseRepository{

    //region attributes

    /**
     * @var Participant
     */
    private $_participant = null;

    //endregion

    //region Static
    //endregion

    public function __construct(App $app, Participant $participant){
        parent::__construct($app);
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

    /**
     * Create a participant for the selected moneybox
     *
     * @param Person $person
     * @param Moneybox $moneybox
     * @return Participant
     * @throws \Exception
     */
    public function create(Person $person, Moneybox $moneybox)
    {
        \Log::info("=== Participant create ===");
        $this->_participant->person_id = $person->id;
        $this->_participant->moneybox_id = $moneybox->id;
        if (!$this->_participant->save()) throw new \Exception("Unable to create Person", -1);

        \Log::info("=== Participant created successfully : " . $this->_participant . " ===");
        return $this->_participant;
    }

    //endregion

    //region Private Methods
    //endregion
}