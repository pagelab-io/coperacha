<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Entities\CountryCode;
use App\Entities\Invitation;
use App\Entities\Moneybox;
use App\Entities\File;
use App\Http\Requests\PLRequest;
use App\Models\Mailer;
use App\Repositories\MoneyboxRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use App\Utilities\PLConstants;
use App\Wordpress\model\Post;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Mockery\CountValidator\Exception;

class HomeController extends Controller
{
    /**
     * @var SettingRepository
     */
    private $_settingRepository;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    /**
     * @var UserRepository
     */
    private $_userRepository;

    /**
     * @var Mailer
     */
    private $_mailer;

    /**
     * HomeController constructor.
     * @param SettingRepository $settingRepository
     * @param MoneyboxRepository $moneyboxRepository
     * @param UserRepository $userRepository
     * @param Mailer $mailer
     */
    public function __construct(
        SettingRepository $settingRepository,
        MoneyboxRepository $moneyboxRepository,
        UserRepository $userRepository,
        Mailer $mailer)
    {
        $this->_settingRepository = $settingRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
        $this->_userRepository = $userRepository;
        $this->_mailer = $mailer;
    }

    /**
     * Home View
     *
     * @return Factory|\Illuminate\View\View
     */
    public function getHomePage()
    {
        $categories = Category::where('id', 1)
            ->orWhere('id',2)
            ->orWhere('id',3)
            ->orWhere('id',4)
            ->orWhere('id',6)
            ->get();

        // Poner el id del post correspondiente a (testimonios)
        $testimonial = Post::find(62);

        if ($testimonial) {
            $testimonials = $testimonial->getChildrens();
        } else {
            $testimonials = new Collection();
            $post = new Post();
            $post->post_title = "Demo 1";
            $post->post_content = "Text demo";
            $testimonials->push($post);
        }

        return view('index', [
            'pageTitle' => '',
            'categories' => $categories,
            'testimonials' => $testimonials
        ]);
    }

    /**
     * Contact View
     *
     * @return Factory|\Illuminate\View\View
     */
    public function getContactPage()
    {
        return view('pages.contact', ['pageTitle' => 'Contacto']);
    }

    /**
     * About View
     *
     * @return Factory|\Illuminate\View\View
     */
    public function getAboutPage()
    {
        return view('pages.about', ['pageTitle' => '¿Por qué organizar la recaudación con Coperacha?']);
    }

    /**
     * Faqs View
     *
     * @return Factory|\Illuminate\View\View
     */
    public function getFaqsPage()
    {
        $faq = Post::find(2);
        $childrens = $faq->getChildrens();

        return view('pages.faqs', [
            'pageTitle' => 'Preguntas Frecuentes',
            'faq'       => $faq,
            'childrens' => $childrens
        ]);
    }

    /**
     * Pricing View
     *
     * @return Factory|\Illuminate\View\View
     */
    public function getPricingPage(){
        return view('pages.pricing')
            ->with('pageTitle','Precios');
    }

    /**
     * @param Request $request
     * @param string $url
     * @param string $moneybox_name
     * @param string $moneybox_creator
     * @param string $moneybox_category
     * @throws \Exception
     * @return Factory|\Illuminate\View\View
     */
    public function getCreateMoneyboxPage(Request $request, $url = '', $moneybox_name = '', $moneybox_creator = '', $moneybox_category = '') {
        $moneybox = null;
        $moneyboxSettings   = null;
        $privacyoption      = 0;
        $amountoption       = 0;
        $title              = "";
        if ($url != "" && $url != 'create') {
            $variables          = $this->_moneyboxRepository->getByURL($url);
            $moneybox           = $variables['moneybox'];
            $moneyboxSettings   = $variables['settings'];
            $amountoption       = $moneyboxSettings[0];
            $privacyoption      = $moneyboxSettings[1];
            $title              = "Modificar alcancía";

            if (count($moneybox->files) > 0) {
                $lastfile = $moneybox->files->last();
                $moneybox->image = $lastfile->name;
            }
        } else {
            $title = "Crear mi alcancía 1/2";
        }
        $request->merge(array('path' => '/moneybox'));
        $response = $this->_settingRepository->childsOf($request);
        $categories = Category::all();
        $categories1 = [];
        $categories2 = [];
        foreach($categories as $i => $category){
            array_push($categories1, $category);
            if ($i == 6) break;
        }

        foreach($categories as $i => $category){
            if ($i > 6)
                array_push($categories2, $category);
        }
        \Log::info($response->data);

        return view('moneybox.create')
            ->with('categories1', $categories1)
            ->with('categories2', $categories2)
            ->with('settings', $response->data)
            ->with('moneybox', $moneybox)
            ->with('moneyboxSettings', $moneyboxSettings)
            ->with('privacyoption', $privacyoption)
            ->with('amountoption', $amountoption)
            ->with('pageTitle',$title)
            ->with('name', $moneybox_name)
            ->with('creator', $moneybox_creator)
            ->with('categorySelected', $moneybox_category);
    }

    /**
     *
     * @param PLRequest $request
     * @return Factory|\Illuminate\View\View
     */
    public function getDashboardPage(PLRequest $request){
        $request->merge(array('person_id' => \Auth::user()->person->id));
        $response = $this->_moneyboxRepository->getAll($request);
        $my_moneyboxes = $response->data['my_moneyboxes'];
        $moneyboxes_participation = $response->data['moneyboxes_participation'];
        foreach($my_moneyboxes as $moneybox){
            $participants = $moneybox->participants;
            $moneybox->participant_number = 0;
            foreach ($participants as $participant){
                if ($participant->active == 1)
                    $moneybox->participant_number++;
            }
        }
        foreach($moneyboxes_participation as $moneybox){
            $participants = $moneybox->participants;
            $moneybox->participant_number = 0;
            foreach ($participants as $participant){
                if ($participant->active == 1)
                    $moneybox->participant_number++;
            }
        }
        return view('moneybox.dashboard')
            ->with('moneyboxes', $response->data)
            ->with('pageTitle','Mis Alcancías');

    }

    /**
     * @param $url
     * @internal param Request $request
     * @return Factory|\Illuminate\View\View
     */
    public function getDetailPage($url, $created = ''){
        $variables = $this->_moneyboxRepository->getByURL($url);
        $moneybox = $variables['moneybox'];
        $person = $variables['person'];
	
	    $settings = $variables["settings"];
        $partiticipantsnumber = $variables['partiticipantsnumber'];

        if (count($moneybox->files) > 0) {
            $moneybox->lastfile = $moneybox->files->last();
        }

        $creatednow = ($created == 1) ? 1 : 0;

        if ($moneybox->active == 1) {
            return view('moneybox.detail')
                ->with('moneybox', $moneybox)
                ->with('settings', $settings)
                ->with('person', $person)
                ->with('partiticipantsnumber', $partiticipantsnumber)
                ->with('pageTitle',$moneybox->name)
                ->with('created', $creatednow);
        } else {
            return redirect('/');
        }

    }

    /**
     *
     * @param $moneyboxurl
     * @return Factory|\Illuminate\View\View
     * @throws \Exception
     * @internal param Request $request
     */
    public function getRequestPage($moneyboxurl)
    {
        // get moneybox with it's settings
        $variables = $this->_moneyboxRepository->getByURL($moneyboxurl);
        $moneybox = $variables['moneybox'];
        $codes = CountryCode::getCodes();
        return view('moneybox.request')
            ->with('pageTitle','Solicitud de Dinero')
            ->with('moneybox',$moneybox)
            ->with('codes',$codes);
    }

    /**
     * @param $moneyboxurl
     * @internal param Request $request
     * @return Factory|\Illuminate\View\View
     */
    public function getJoinPage($moneyboxurl){
        // get moneybox with it's settings
        $variables = $this->_moneyboxRepository->getByURL($moneyboxurl);
        $moneybox = $variables['moneybox'];
        $moneyboxSettings = $variables['settings'];

        // get settings for participants
        $request = new PLRequest();
        $request->merge(array('path' => '/participant'));
        $settings = $this->_settingRepository->childsOf($request);

        $codes = CountryCode::getCodes();

        return view('moneybox.join')
            ->with('moneybox', $moneybox)
            ->with('moneyboxSettings', $moneyboxSettings)
            ->with('settings', $settings->data)
            ->with('codes', $codes)
            ->with('pageTitle','Participa');
    }

    /**
     * @param $url
     * @throws \Exception
     * @return Factory|\Illuminate\View\View
     */
    public function getSummaryPage($url) {
        // get moneybox with it's settings
        $variables  = $this->_moneyboxRepository->getByURL($url);
        $moneybox   = $variables['moneybox'];
        $moneyboxSetttings = $variables['settings'];
        $user       = '';
        $amount     = 0;

        if (\Session::has('tmp_participant')){
            $session = \Session::get('tmp_participant');
            $user       = $this->_userRepository->byEmail($session['email']);
            $amount     = $session['amount'];
        } else {
            return redirect("/");
        }

        return view('moneybox.summary')
            ->with('moneybox', $moneybox)
            ->with('moneyboxSettings', $moneyboxSetttings)
            ->with('participant', $user)
            ->with('amount', $amount)
            ->with('pageTitle','Resumen de tu participación antes del pago');

    }

    /**
     * Send request email
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMailRequest(Request $request) {
        $moneybox = Moneybox::find($request->get('moneybox_id'));

        if (!$moneybox) {
            throw new EntityNotFoundException('La alcancía no existe.', -1);
        }
        /// Vars
        $withMail = true;
        $data = $request->all();
        $order = $moneybox->order();
        $order = $order->create($data);
        $user = $moneybox->person->user;
        if (!$order) {
            throw new Exception('No se pudo crear la orden de retiro');
        }

        // Extract file info
        $data = [
            'moneybox' => $moneybox,
            'order' => $order
        ];

        if (true == $withMail) {
            $options = array(
                'from' => [$user->email => $user->person->fullName()],
                'to' => ['coperachamexico@gmail.com' => 'Coperacha.com.mx'],
                'bcc' => explode(',', PLConstants::EMAIL_BCC),
                'title' => 'Solicitud de Retiro'
            );
            $this->_mailer->send(PLConstants::EMAIL_REQUEST, $data, $options);
        }
        return response()->json(['success' => true, 'data' => $order]);
    }

    /**
     * Send mail contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMailContact(Request $request) {
        $data = [
            'name'    => $request->get('name'),
            'email'   => $request->get('email'),
            'content' => $request->get('content'),
        ];
        $options = array(
            'from' => [$request->get('email') => 'Contacto'],
            'to' => ['coperachamexico@gmail.com' => 'Coperacha.com.mx'],
            'bcc' => explode(',', PLConstants::EMAIL_BCC),
            'title' => 'Mensaje de Contacto'
        );
        $this->_mailer->send(PLConstants::EMAIL_CONTACT, $data, $options);
        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Send mail contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMailThanks(Request $request) {
        \Log::info("Llegando a envío de agradecimientos ...");
        $url = $request->get('url');
        \Log::info($url);
        $moneybox = Moneybox::byUrl($url)->with('participants')->first();
        if (!$moneybox) {
            throw new EntityNotFoundException('La alcancía no existe.', -1);
        }
        // Owner of the moneybox
        $owner = $moneybox->person->user;
        // Get users list
        $users = [];

        foreach ($moneybox->participants as $participant) {
            if ($participant->active == 0)
                continue;
            $person = $participant->person;
            $user = $person->user;
            if (!isset($users[$user->email])) {
                $users[$user->email] = $user;
            }
        }
        $users = array_values($users);
        $senders = [];

        // Send users list
        foreach ($users as $user) {
            if ($user->email) {
                $senders[] = $user->email;
                $data = [
                    'owner' => $owner,
                    'moneybox' => $moneybox,
                    'user' => $user
                ];
                $options = array(
                    'from' => [$owner->email => $owner->username],
                    'to' => [$user->email => $user->username],
                    'bcc' => explode(',', PLConstants::EMAIL_BCC),
                    'title' => 'Agradecimiento'
                );
                $this->_mailer->send(PLConstants::EMAIL_THANKS, $data, $options);
            }
        }
        return response()->json(['success' => true, 'data' => $senders]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postRemoveMoneybox(Request $request) {
        $url = $request->get('url');
        $moneybox = Moneybox::byUrl($url)->first();
        if (!$moneybox) {
            throw new EntityNotFoundException('La alcancía no existe.', -1);
        }

        $moneybox->active = 0;
        $moneybox->save();
        return response()->json(['success' => true, 'data' => $moneybox]);
    }

    /**
     * Send mail of invitation to collaborate to moneybox
     * Refs http://php.net/manual/es/function.preg-split.php
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMailInvitation(Request $request)
    {
        $moneybox = Moneybox::byUrl($request->get('url'))->first();

        if (!$moneybox) {
            throw new EntityNotFoundException('No existe la alcancía', -1);
        }

        $emailsS = preg_replace('/\s+/', '', $request->get('emails'));
        $emails = preg_split("/[\s,;:]+/", $emailsS);
        
        foreach ($emails as $email) {
            $validator = Validator::make(['mail' => trim($email)], [
                'mail' => 'required|email'
            ]);

            if ($validator->passes()) {
                $data = ['moneybox' => $moneybox];
                $record = Invitation::create([
                    'email' => trim($email),
                    'status' => 0,
                    'moneybox_id' => $moneybox->id]);

                if ($record) {
                    $options = array(
                        'from' => ['hola@coperacha.com.mx' => 'Coperacha.com.mx'],
                        'to' => [$email => 'Invitado ' . $email],
                        'bcc' => explode(',', PLConstants::EMAIL_BCC),
                        'title' => 'Mensaje de Invitación'
                    );
                    $this->_mailer->send(PLConstants::EMAIL_MONEYBOX_INVITATION, $data, $options);
                }
            } else {
                return response()->json(['success' => false, 'data' => $emails]);
            }
        }

        return response()->json(['success' => true, 'data' => $emails]);
    }

    /**
     * Send mail contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMailRememberInvitation(Request $request) {
        $invitations = Invitation::where('status', 0)->get();
        if (!$invitations) {
            throw new EntityNotFoundException('No existe la alcancía');
        }

        $attends = [];

        foreach ($invitations as $invitation) {
            if (!isset($attends[$invitation->email])) {
                $attends[$invitation->email] = $invitation->id;
                $data = [
                    'invitation' => $invitation,
                    'moneybox' => $invitation->moneybox
                ];
                $options = array(
                    'from' => ['hola@coperacha.com.mx' => 'Coperacha.com.mx'],
                    'to' => [$invitation->email => 'Invitado'],
                    'bcc' => explode(',', PLConstants::EMAIL_BCC),
                    'title' => 'Mensaje de Recordatorio'
                );
                $this->_mailer->send(PLConstants::EMAIL_PENDING_INVITATION, $data, $options);
            }
        }

        return response()->json(['success' => true, 'data' => $attends]);
    }
}
