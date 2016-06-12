<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:17 PM
 */

namespace App\Repositories;

use App\Models\Person;

class PersonRepository extends BaseRepository{

    //region attributes

    /**
     * @var Person
     */
    private $_person = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Person $person){
        $this->_person = $person;
    }

    //region Methods
    /**
     * return namespace for Person Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Person';
    }
    //endregion

    //region Private Methods
    //endregion
}