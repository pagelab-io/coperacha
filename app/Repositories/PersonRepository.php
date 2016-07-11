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

class PersonRepository extends BaseRepository
{

    //region attributes

    /**
     * @var Person
     */
    private $_person = null;

    //endregion

    //region Static
    //endregion

    public function __construct(Person $person, App $app)
    {
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

        \Log::info("=== Person created successfully : " . $this->_person . " ===");
        return $this->_person;
    }

    /**
     * Update the specified person
     *
     * @param PLRequest $request
     * @return Person
     * @throws \Exception
     */
    public function update(PLRequest $request)
    {

        try {
            $this->_person = $this->byId($request->get('person_id'));
            \Log::info("=== Person update ===");

            if ($request->exists('name')) $this->_person->name = $request->get('name');
            if ($request->exists('lastname')) $this->_person->lastname = $request->get('lastname');
            if ($request->exists('birthday')) $this->_person->birthday = $request->get('birthday');
            if ($request->exists('gender')) $this->_person->gender = $request->get('gender');
            if ($request->exists('city')) $this->_person->city = $request->get('city');
            if ($request->exists('country')) $this->_person->country = $request->get('country');
            if (!$this->_person->save()) throw new \Exception("Unable to update Person", -1);

            \Log::info("=== Person updated successfully : " . $this->_person . " ===");

        } catch(\Exception $ex) {
            throw new \Exception("Person does not exist", -1, $ex);
        }

        return $this->_person;
    }

    /**
     * Set the default values for person
     */
    public function setDefault()
    {
        $this->_person->birthday = '0000-00-00';
        $this->_person->gender = 'H';
        $this->_person->city = '';
        $this->_person->country = '';
    }

    //region Private Methods
    //endregion
}