<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 12/06/2016
 * Time: 12:29 PM
 */

namespace App\Repositories;

use App\Entities\Invitation;
use App\Entities\MemberSetting;
use App\Entities\Participant;
use App\Entities\Payment;
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
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;
use Illuminate\Support\Facades\Mail;

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

    public function search(PLRequest $request)
    {

        $filters = array();

        if($request->exists('name') && $request->get('name') != ''){
            $filter = array('name', 'LIKE', '%'. $request->get('name') .'%');
            array_push($filters, $filter);
        }

        if($request->exists('status') && $request->get('status') != ''){
            $filter = array('active', '=', $request->get('status'));
            array_push($filters, $filter);
        }

        return Moneybox::where($filters)->get();
    }

    public function moneyboxStadistics(){

        $currentDate = new Carbon();
        $initDate = Carbon::createFromDate($currentDate->year,01,01);
        $endDate  = Carbon::createFromDate($currentDate->year,01,01);;
        $endDate->addYear();

        $moneyboxes = Moneybox::where(
            array(
                    array('created_at' ,'>', $initDate->format('Y-m-d')),
                    array('created_at' ,'<', $endDate->format('Y-m-d'))
            ))->get();


        if (count($moneyboxes) > 0) {

            // durability
            $durability_sum = 0;
            $collected_amount = 0;
            $goal_amount = 0;

            foreach ($moneyboxes as $moneybox) {
                $created_at = explode(' ',$moneybox->created_at);
                $init = PLDateTime::toCarbon($created_at[0]);
                $end  = PLDateTime::toCarbon($moneybox->end_date);
                $durability_sum += $init->diffInDays($end);
                $collected_amount += $moneybox->collected_amount;
                $goal_amount += $moneybox->goal_amount;
            }


            // today, yesterday and month moneyboxes
            $todayMoneyboxes = Moneybox::where('created_at', 'like' ,'%'.Carbon::today()->format('Y-m-d').'%')->count();
            $yesterdayMoneyboxes = Moneybox::where('created_at', 'like' ,'%'.Carbon::yesterday()->format('Y-m-d').'%')->count();

            $month = Carbon::today()->format('m');
            $monthMoneyboxes = Moneybox::where(array(
                array('created_at', '>=', Carbon::createFromDate($currentDate->year,$month,01)),
                array('created_at', '<', Carbon::createFromDate($currentDate->year,$month,01)->addMonth())
            ))->count();

            // today, yesterday and month payments

            $todayPayments = Payment::where(array(
                array('created_at', 'like' ,'%'.Carbon::today()->format('Y-m-d').'%'),
                array('status', 'PAYED')
            ))->sum('amount');

            $yesterdayPayments = Payment::where(array(
                array('created_at', 'like' ,'%'.Carbon::yesterday()->format('Y-m-d').'%'),
                array('status', 'PAYED')
            ))->sum('amount');

            $monthPayments = Payment::where(array(
                array('status', 'PAYED'),
                array('created_at', '>=', Carbon::createFromDate($currentDate->year,$month,01)),
                array('created_at', '<', Carbon::createFromDate($currentDate->year,$month,01)->addMonth())
            ))->sum('amount');

            return array(
                'moneyboxes' => array(
                    'Por Día' => count($moneyboxes)/365,
                    'Por Semana' => count($moneyboxes)/52,
                    'Por Mes' => count($moneyboxes)/12,
                    'Por Año' => count($moneyboxes)
                ),
                'durability' => array(
                    'Alcancías del día' => $todayMoneyboxes,
                    'Alcancías de ayer' => $yesterdayMoneyboxes,
                    'Alcancías en el mes' => $monthMoneyboxes,
                    'Duración promedio (días)' => number_format($durability_sum/count($moneyboxes), 2),
                    'Monto Recaudado (promedio)' => "$ ".number_format($collected_amount/count($moneyboxes), 2),
                    'Monto Recaudado del día' => "$ ".number_format($todayPayments, 2),
                    'Monto Recaudado ayer' => "$ ".number_format($yesterdayPayments, 2),
                    'Monto Recaudado del mes' => "$ ".number_format($monthPayments, 2)
                )
            );

        } else {
            return array(
                'moneyboxes' => array(
                    'Por Día' => 0,
                    'Por Semana' => 0,
                    'Por Mes' => 0,
                    'Por Año' => 0
                ),
                'durability' => array(
                    'Alcancías del día' => 0,
                    'Alcancías de ayer' => 0,
                    'Alcancías en el mes' => 0,
                    'Duración promedio (días)' => 0,
                    'Monto Recaudado (promedio)' => 0,
                    'Monto Recaudado del día' => 0,
                    'Monto Recaudado ayer' => 0,
                    'Monto Recaudado del mes' => 0
                )
            );
        }

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

        $firstMoneybox = $this->firstMoneybox($request, $person);
        \Log::info("is first moneybox ? : ");
        \Log::info($firstMoneybox ? "true":"false");

        \Log::info("Executing transaction : TxCreateMoneybox");
        $this->_moneybox = $this->_txCreateMoneybox->executeTx($request, array('firstMoneybox' =>  $firstMoneybox));
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
        $response->description = 'Listing all moneybox successfully';
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
        $moneyboxes = Moneybox::where('active', 1)
            ->with('files')
            ->with('participants')
            ->where("person_id", $request->get('person_id'))->get();

        if (count($moneyboxes) > 0) {
            foreach ($moneyboxes as $m) {

                if (count($m->files) > 0) {
                    $m->lastfile = $m->files->last();
                }

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

                $personMoneyboxes = Participant::where(array(
                    array('person_id', $person->id),
                    array('active', 1)
                ))->get();
                if (count($personMoneyboxes) > 0) {
                    foreach ($personMoneyboxes as $pm) {
                        $moneybox = $this->byId($pm->moneybox_id);
                        if ($moneybox->active != 1)
                            continue;
                        $moneybox->participants;
                        if (count($moneybox->files) > 0) {
                            $moneybox->lastfile = $moneybox->files->last();
                        }
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
                $participantsnumber = Participant::where(array(
                    array('moneybox_id', $moneybox->id),
                    array('active', 1)
                ))->count();
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

    public function getParticipants($moneybox_id)
    {
        \Log::info("=== Getting all participants ===");
        $moneybox = null;
        $response = new PLResponse();
        try {$moneybox = $this->byId($moneybox_id); }
        catch(\Exception $ex) { throw new \Exception("Moneybox does not exist", -1, $ex); }

        $participants = Participant::where(array(
            array('moneybox_id', $moneybox->id),
            array('active', 1)
        ))->get();
        if(count($participants) > 0 ){

            foreach ($participants as $participant) {
                $payments = Payment::where(array(
                    array("person_id", $participant->person_id),
                    array("moneybox_id", $participant->moneybox_id),
                    array("status", PLConstants::PAYMENT_PAYED)
                ))->get();
                $settings = MemberSetting::where(array(
                    array("owner_id", $participant->id),
                    array("owner", "participant")
                ))->get();
                $payment = 0;
                foreach ($payments as $p) {
                    $payment += $p->amount;
                }
                $participant->settings = $settings;
                $participant->person;
                $participant->amount = $payment;
            }

            $response->data = $participants;
            $response->description = 'participants obteined successfully';
        } else {
            $response->data = [];
            $response->status = -1;
            $response->description = 'this moneybox not has participants';
        }

        return $response;
    }

    /**
     * Check if a person not has moneyboxes
     * @param PLRequest $request
     * @return bool
     */
    private function firstMoneybox(PLRequest $request)
    {
        return count($this->myMoneyboxes($request)) == 0 ? true : false;
    }

    /**
     * Send the invitation emails
     * @param PLRequest $request
     * @return PLResponse
     */
    public function sendInvitations(PLRequest $request)
    {
        $response = new PLResponse();
        $moneybox_data = $this->getByURL($request->get('url'));
        $moneybox = $moneybox_data['moneybox'];
        $emailsS = preg_replace('/\s+/', '', $request->get('emails'));
        $emails = preg_split("/[\s,;:]+/", $emailsS);

        if ($this->validateInvitations($emails)) {
            \Log::info("=== Creando invitaciones ===");
            foreach ($emails as $email) {
                $data = ['moneybox' => $moneybox];
                $record = Invitation::create([
                    'email' => trim($email),
                    'status' => 0,
                    'moneybox_id' => $moneybox->id]);
                if ($record) {
                    Mail::send('emails.invitation', $data, function ($message) use ($email) {
                        $message->from('hola@coperacha.com.mx', 'Coperacha.com.mx');
                        $message->to($email, 'Invitado ' . $email);
                        $message->bcc(['sanchezz985@gmail.com,francisco.javier.p.ramos@gmail.com']);
                        $message->subject('Mensaje de Invitación');
                    });
                }
            }
            $response->data = [];
            $response->description = 'emails sent successfully';
            return $response;
        } else {
            $response->data = [];
            $response->status = -1;
            $response->description = 'one or more emails not have the correct format';
            return $response;
        }
    }

    //endregion

    //region Private Methods

    /**
     * Validate Invitations emails
     * @param $emails
     * @return bool
     */
    private function validateInvitations($emails)
    {
        \Log::info("=== Validando los correos electronicos ===");
        $valid = true;
        foreach ($emails as $email) {
            $validator = Validator::make(['mail' => trim($email)], ['mail' => 'email' ]);
            if (!$validator->passes()) {
                $valid = false;
                break;
            }
        }
        return $valid;
    }
    //endregion
}