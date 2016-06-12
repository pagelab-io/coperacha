<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 01:28 PM
 */

namespace App\Repositories;


use App\Models\PersonRelationship;

class PersonRelationshipRepository extends BaseRepository
{

    //region attributes

    /**
     * @var PersonRelationship
     */
    private $_personRelationship = null;

    //endregion

    //region Static
    //endregion

    public function __construct(PersonRelationship $personRelationship)
    {
        $this->_personRelationship = $personRelationship;
    }

    //region Methods

    /**
     * return namespace for PersonRelationship model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\PersonRelationship';
    }

    //endregion

    //region Private Methods
    //endregion
}