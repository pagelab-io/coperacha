<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:29 PM
 */

namespace App\Repositories;

use App\Entities\Category;
use App\Entities\Person;
use App\Http\Responses\PLResponse;
use App\Transactions\TxCreateMoneybox;
use Illuminate\Container\Container as App;
use App\Http\Requests\PLRequest;
use App\Entities\Moneybox;

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

    /**
     * @var MemberSettingRepository
     */
    private $_memberSettingRepository;

    /**
     * @var ParticipantRepository
     */
    private $_participantRepository;

    /**
     * @var TxCreateMoneybox
     */
    private $_txCreateMoneybox;

    //endregion

    //region Static
    //endregion

    public function __construct(
        App $app,
        TxCreateMoneybox $txCreateMoneybox,
        Moneybox $moneybox,
        PersonRepository $personRepository,
        CategoryRepository $categoryRepository,
        MemberSettingRepository $memberSettingRepository)
    {
        parent::__construct($app);
        $this->_moneybox = $moneybox;
        $this->_txCreateMoneybox = $txCreateMoneybox;
        $this->_personRepository = $personRepository;
        $this->_categoryRepository = $categoryRepository;
        $this->_memberSettingRepository = $memberSettingRepository;
    }

    //region Methods
    /**
     * return namespace for Moneybox Model
     *
     * @return mixed
     */
    function model()
    {
        return 'App\Entities\Moneybox';
    }

    /**
     * Create a new moneybox
     *
     * @param PLRequest $request
     * @return PLResponse
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

        \Log::info("Executing transaction : TxCreateMoneybox");
        $this->_moneybox = $this->_txCreateMoneybox->executeTx($request);
        \Log::info("End transaction : TxCreateMoneybox");

        // response
        $response               = new PLResponse();
        $response->description  = 'Moneybox was created successfully';
        $response->data         = $this->_moneybox;

        return $response;
    }

    /**
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
    public function getAll(PLRequest $request)
    {
        $moneybox_list = [];
        $moneybox_list['my_moneyboxes'] = $this->myMoneyboxes($request);
        $moneybox_list['moneyboxes_participation'] = $this->moneyboxesParticipation($request);

        $response = new PLResponse();
        $response->description = 'Listing all momeybox succesfully';
        $response->data = $moneybox_list;
        return $response;
    }

    /**
     * Get the moneyboxes created by person
     * @param PLRequest $request
     * @return mixed
     */
    public function myMoneyboxes(PLRequest $request)
    {
        $moneyboxes = Moneybox::where("owner", $request->get('person_id'))->get();

        if (count($moneyboxes) > 0) {
            foreach ($moneyboxes as $m) {
                $m->settings = $this->_memberSettingRepository->getSettings('moneybox', $m->id);
            }
        }

        return $moneyboxes;
    }

    /**
     * Get the moneyboxes where a person has participated
     * @param PLRequest $request
     * @throws \Exception
     * @return array
     */
    public function moneyboxesParticipation(PLRequest $request)
    {
        $moneyboxes = [];
        try{
            $person = $this->_personRepository->byId($request->get('person_id'));
            if ($person instanceof Person) {

                $personMoneyboxes = $person->personMoneyboxes;
                if (count($personMoneyboxes) > 0) {
                    foreach ($personMoneyboxes as $pm) {
                        $moneybox = $this->byId($pm->moneybox_id);
                        array_push($moneyboxes, $moneybox);
                    }
                }
            }
            return $moneyboxes;
        }catch(\Exception $ex){
            throw new \Exception("person does not exits", -1, $ex);
        }
    }

    /**
     * Delete the moneybox
     * @throws \Exception
     */
    public function delete()
    {
        $this->_moneybox->delete();
    }

    /**
     * Update the selected Moneybox
     *
     * @param PLRequest $request
     * @return Moneybox|mixed
     * @throws \Exception
     */
    public function update(PLRequest $request)
    {

        try {

            $this->_moneybox = $this->byId($request->get('moneybox_id'));
            \Log::info("=== Moneybox update ===");

            // check for category existence
            if ($request->exists('category_id')) {
                try {
                    $category = $this->_categoryRepository->byId($request->get('category_id'));
                    if($category instanceof Category) $this->_moneybox->category_id = $request->get("category_id");
                }
                catch(\Exception $ex) {throw new \Exception("Category does not exist", -1, $ex);}
            }

            if ($request->exists('name')) $this->_moneybox->name = $request->get('name');
            if ($request->exists('goal_amount')) $this->_moneybox->goal_amount = $request->get('goal_amount');
            if ($request->exists('end_date')) $this->_moneybox->end_date = $request->get('end_date');
            if ($request->exists('description')) $this->_moneybox->description = $request->get('description');
            if (!$this->_moneybox->save()) throw new \Exception("Unable to update Moneybox", -1);

            \Log::info("=== Moneybox updated successfully : " . $this->_moneybox . " ===");

        } catch(\Exception $ex) {
            throw new \Exception("Moneybox does not exist", -1, $ex);
        }

        return $this->_moneybox;

    }

    //endregion

    //region Private Methods
    //endregion
}