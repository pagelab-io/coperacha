<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:29 PM
 */

namespace App\Repositories;

use App\Entities\MemberSetting;
use App\Entities\Participant;
use App\Entities\Person;
use App\Http\Responses\PLResponse;
use App\Models\Mailer;
use App\Transactions\TxCreateMoneybox;
use App\Transactions\TxUpdateMoneybox;
use App\Utilities\PLConstants;
use App\Utilities\PLDateTime;
use Illuminate\Container\Container as App;
use App\Http\Requests\PLRequest;
use App\Entities\Moneybox;
use Carbon\Carbon;
use Mockery\CountValidator\Exception;

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
     * @var TxCreateMoneybox
     */
    private $_txCreateMoneybox;

    /**
     * @var TxUpdateMoneybox
     */
    private $_txUpdateMoneybox;

    /**
     * @var Mailer
     */
    private $_mailer;

    //endregion

    //region Static
    //endregion

    public function __construct(
        App $app,
        Moneybox $moneybox,
        PersonRepository $personRepository,
        CategoryRepository $categoryRepository,
        MemberSettingRepository $memberSettingRepository,
        TxCreateMoneybox $txCreateMoneybox,
        TxUpdateMoneybox $txUpdateMoneybox,
        Mailer $mailer)
    {
        parent::__construct($app);
        $this->_moneybox = $moneybox;
        $this->_personRepository = $personRepository;
        $this->_categoryRepository = $categoryRepository;
        $this->_memberSettingRepository = $memberSettingRepository;
        $this->_txCreateMoneybox = $txCreateMoneybox;
        $this->_txUpdateMoneybox = $txUpdateMoneybox;
        $this->_mailer = $mailer;
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

        // check for creation date
        $today = new Carbon();
        $moneybox_enddate = PLDateTime::toCarbon($request->get('end_date'));
        if($today->gt($moneybox_enddate)) throw new Exception("Incorrect End Date", -1);

        // check for category
        try {$category = $this->_categoryRepository->byId($request->get('category_id'));}
        catch(\Exception $ex){ throw new \Exception("Category does not exist", -1, $ex);}
        \Log::info("Category : ".$category);

        // check for person
        try{ $person = $this->_personRepository->byId($request->get('person_id'));
        }catch(\Exception $ex){ throw new \Exception("Person does not exist", -1, $ex);}
        \Log::info("Person : ".$person);

        \Log::info("Executing transaction : TxCreateMoneybox");
        $this->_moneybox = $this->_txCreateMoneybox->executeTx($request);
        \Log::info("End transaction : TxCreateMoneybox");

        // response
        $response               = new PLResponse();
        $response->description  = 'Moneybox was created successfully';
        $response->data         = $this->_moneybox;

        try{
            // send email
            $data = array(
                'moneybox'  => $this->_moneybox,
                'person'    => $person
            );
            $user = $person->user;
            $options = array(
                'to' => $user->email,
                'bcc' => explode(',', PLConstants::EMAIL_BCC),
                'title' => 'Tu alcancía fue creada'
            );
            $this->_mailer->send(PLConstants::EMAIL_NEW_MONEYBOX, $data, $options);
        }catch(\Exception $ex) {
            \Log::info("Error sending email");
            \Log::info($ex->getTraceAsString());
        }

        return $response;
    }

    /**
     * @param PLRequest $request
     * @return PLResponse
     * @throws \Exception
     */
    public function getAll(PLRequest $request)
    {
        \Log::info("Searching all moneybox for person :: ".$request->get("person_id"));
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
        $moneyboxes = Moneybox::where("person_id", $request->get('person_id'))->get();
        if (count($moneyboxes) > 0) {
            foreach ($moneyboxes as $m) {
                $m->participants;
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
                        $moneybox->participants;
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
    public function updateMoneybox(PLRequest $request)
    {

        $category = null;
        $moneybox = null;

        try {$moneybox = $this->byId($request->get('moneybox_id')); }
        catch(\Exception $ex) { throw new \Exception("Moneybox does not exist", -1, $ex); }
        \Log::info("Moneybox : ".$moneybox);

        // check for category existence
        if ($request->exists('category_id')) {
            try { $category = $this->_categoryRepository->byId($request->get('category_id')); }
            catch(\Exception $ex) { throw new \Exception("Category does not exist", -1, $ex); }
            \Log::info("Category : ".$category);
        }

        // check dates

        $response = $this->_txUpdateMoneybox->executeTx($request, array('moneybox' => $moneybox, 'category' => $category));

        if ($response->status == '200') {
            $response->description = 'Moneybox was updated successfully';
        }

        return $response;

    }

    /**
     * Get's an array with the next info
     * ['moneybox'] - the selected moneybox by url
     * ['person'] - the moneybox's creator
     * ['participantsnumber'] - number of participants in this moneybox
     * ['settings'] - the moneybox's settings when was created
     *
     * @param $url
     * @return array
     * @throws \Exception
     */
    public function getByURL($url)
    {
        try {
            $person = null;
            $settings = null;
            $moneybox = Moneybox::where("url", $url)->firstOrFail();
            $participantsnumber = 0;
            $result = array();
            if ($moneybox) {
                $person = Person::where("id", $moneybox->person_id)->firstOrFail();
                $participantsnumber = Participant::where('moneybox_id', $moneybox->id)->count();
                $settings = MemberSetting::where(["owner_id" => $moneybox->id, "owner" => "moneybox"])->get();
            }
            $result['moneybox'] = $moneybox;
            $result['person'] = $person;
            $result['partiticipantsnumber'] = $participantsnumber;
            $result['settings'] = $settings;
        } catch(\Exception $ex){
            throw $ex;
        }
        return $result;
    }

    //endregion

    //region Private Methods
    //endregion
}