<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:29 PM
 */

namespace App\Repositories;

use Illuminate\Container\Container as App;
use App\Http\Requests\PLRequest;
use App\Models\Moneybox;

class MoneyboxRepository extends BaseRepository{

    //region attributes

    /**
     * @var Moneybox
     */
    private $_moneybox;

    /**
     * @var CategoryRepository
     */
    private $_categoryRepository;

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    //endregion

    //region Static
    //endregion

    public function __construct(Moneybox $moneybox, PersonRepository $personRepository, CategoryRepository $categoryRepository, App $app){
        parent::__construct($app);
        $this->_moneybox = $moneybox;
        $this->_personRepository = $personRepository;
        $this->_categoryRepository = $categoryRepository;
    }

    //region Methods
    /**
     * return namespace for Moneybox Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Models\Moneybox';
    }

    /**
     * Create a new moneybox
     *
     * @param PLRequest $request
     * @return Moneybox
     * @throws \Exception
     */
    public function create(PLRequest $request)
    {

        $category = null;
        $person   = null;

        // check for category
        try {$category = $this->_categoryRepository->byId($request->get('category_id'));}
        catch(\Exception $ex){ throw new \Exception("Category does not exist", -1, $ex);}
        \Log::info("Category : ".$category);

        // check for person
        try{ $person = $this->_personRepository->byId($request->get('owner_id'));
        }catch(\Exception $ex){ throw new \Exception("Person does not exist", -1, $ex);}
        \Log::info("Person : ".$person);

        \Log::info("=== Creating moneybox ===");
        $this->_moneybox->category_id = $category->id;
        $this->_moneybox->name = $request->get('name');
        $this->_moneybox->goal_amount = $request->get('goal_amount');
        $this->_moneybox->owner = $person->id;
        $this->_moneybox->end_date = $request->get('end_date');
        $this->_moneybox->description = ($request->exists('description')) ? $request->get('description') : '';
        if (!$this->_moneybox->save()) throw new \Exception("Unable to create Moneybox", -1);
        \Log::info("=== Moneybox created successfully : === \n".$this->_moneybox);

        return $this->_moneybox;
    }

    /**
     * Set the default values for person
     */
    public function setDefault()
    {
        $this->_moneybox->collected_amount = '0.0';
        $this->_moneybox->description = '';
        $this->_moneybox->active =1;
    }

    /**
     * Delete the moneybox
     * @throws \Exception
     */
    public function delete()
    {
        $this->_moneybox->delete();
    }

    //endregion

    //region Private Methods
    //endregion
}