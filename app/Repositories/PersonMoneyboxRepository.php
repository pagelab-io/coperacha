<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:40 PM
 */

namespace App\Repositories;


use App\Models\PersonMoneybox;

class PersonMoneyboxRepository extends BaseRepository{

    //region attributes

    /**
     * @var PersonMoneybox
     */
    private $_personMoneybox = null;

    //endregion

    //region Static
    //endregion

    public function __construct(PersonMoneybox $personMoneybox){
        $this->_personMoneybox = $personMoneybox;
    }

    //region Methods

    /**
     * return namaspace for PersonMoneybox Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\PersonMoneybox';
    }

    //endregion

    //region Private Methods
    //endregion
}