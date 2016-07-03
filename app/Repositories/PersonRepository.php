<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:17 PM
 */

namespace App\Repositories;

use App\Http\Requests\PLRequest;
use App\Models\Person;
use Illuminate\Container\Container as App;

class PersonRepository extends BaseRepository{

    //region attributes

    /**
     * @var Person
     */
    private $_person = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Person $person, App $app){
        parent::__construct($app);
        $this->_person = $person;
        $this->setDefault();
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

    /**
     * Create a new person in DB
     *
     * @param PLRequest $request
     * @return Person
     * @throws \Exception
     */
    public function create(PLRequest $request)
    {
        \Log::info("=== Person create ===");
        $this->_person->name = $request->get('name');
        $this->_person->lastname = $request->get('lastname');

        if (!$this->_person->save()) throw new \Exception("Unable to create Person", -1);

        \Log::info("=== Person created successfully : ".$this->_person." ===");
        return $this->_person;
    }

    /**
     * Set the default values for person
     */
    public function setDefault()
    {
        $this->_person->name = '';
        $this->_person->lastname = '';
        $this->_person->birthday = '0000-00-00';
        $this->_person->gender = 'H';
        $this->_person->city = '';
        $this->_person->country = '';
    }

    //region Private Methods
    //endregion
}