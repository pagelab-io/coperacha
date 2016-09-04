<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Entities\Invitation;
use App\Entities\Moneybox;
use App\Entities\File;
use App\Http\Requests\PLRequest;
use App\Repositories\MoneyboxRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
     * HomeController constructor.
     * @param SettingRepository $settingRepository
     * @param MoneyboxRepository $moneyboxRepository
     */
    public function __construct(SettingRepository $settingRepository, MoneyboxRepository $moneyboxRepository, UserRepository $userRepository)
    {
        $this->_settingRepository = $settingRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
        $this->_userRepository = $userRepository;
    }

    /**
     * Home View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHomePage()
    {
        return view('index', ['pageTitle' => '']);
    }


    /**
     * Contact View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getContactPage()
    {
        return view('pages.contact', ['pageTitle' => 'Contacto']);
    }

    /**
     * About View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAboutPage()
    {
        return view('pages.about', ['pageTitle' => '¿Por qué organizar la recaudación con Coperacha?']);
    }


    /**
     * Faqs View
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getFaqsPage()
    {
        return view('pages.faqs', ['pageTitle' => 'Preguntas Frecuentes']);
    }

    /**
     * @param Request $request
     * @param $url
     * @throws \Exception
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateMoneyboxPage(Request $request, $url){

        $moneybox = null;
        $moneyboxSettings   = null;
        $privacyoption      = 0;
        $amountoption       = 0;
        $amount_id          = 0;
        $privacy_id         = 0;
        if ($url != "") {
            $variables          = $this->_moneyboxRepository->getByURL($url);
            $moneybox           = $variables['moneybox'];
            $moneyboxSettings   = $variables['settings'];
            $amountoption       = $moneyboxSettings[0];
            $privacyoption      = $moneyboxSettings[1];
        }
        $categories = Category::all();
        $request->merge(array('path' => '/moneybox'));
        $response = $this->_settingRepository->childsOf($request);
        \Log::info($response->data);
        return view('moneybox.create')
            ->with('categories', $categories)
            ->with('settings', $response->data)
            ->with('moneybox', $moneybox)
            ->with('moneyboxSettings', $moneyboxSettings)
            ->with('privacyoption', $privacyoption)
            ->with('amountoption', $amountoption)
            ->with('pageTitle','Crear mi alcancía 1/2');
    }

    /**
     * @param PLRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateMoneyboxPage2(PLRequest $request){

        $request->merge(array('path' => '/moneybox'));
        $response = $this->_settingRepository->childsOf($request);
        return view('moneybox.step-2')
            ->with('settings', $response->data)
            ->with('pageTitle','Crear mi alcancía 2/2');
    }

    /**
     * @param PLRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboardPage(PLRequest $request){
        \Log::info(\Auth::user());
        \Log::info(\Auth::user()->person->id);
        $request->merge(array('person_id' => \Auth::user()->person->id));
        $response = $this->_moneyboxRepository->getAll($request);
        return view('moneybox.dashboard')
            ->with('moneyboxes', $response->data)
            ->with('pageTitle','Mis Alcancías');
    }

    /**
     * @param $url
     * @internal param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetailPage($url){

        $variables = $this->_moneyboxRepository->getByURL($url);
        $moneybox = $variables['moneybox'];
        $person = $variables['person'];
        $partiticipantsnumber = $variables['partiticipantsnumber'];

        return view('moneybox.detail')
            ->with('moneybox', $moneybox)
            ->with('person', $person)
            ->with('partiticipantsnumber', $partiticipantsnumber)
            ->with('pageTitle',$moneybox->name);
    }

    /**
     * @param $moneyboxurl
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     * @internal param Request $request
     */
    public function getRequestPage($moneyboxurl)
    {
        // get moneybox with it's settings
        $variables = $this->_moneyboxRepository->getByURL($moneyboxurl);
        $moneybox = $variables['moneybox'];
        return view('moneybox.request')
            ->with('pageTitle','Solicitud de Dinero')
            ->with('moneybox',$moneybox);
    }

    /**
     * @param $moneyboxurl
     * @internal param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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

        return view('moneybox.join')
            ->with('moneybox', $moneybox)
            ->with('moneyboxSettings', $moneyboxSettings)
            ->with('settings', $settings->data)
            ->with('pageTitle','Participa');
    }

    /**
     * @param $url
     * @throws \Exception
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSummaryPage($url){

        // get moneybox with it's settings
        $variables  = $this->_moneyboxRepository->getByURL($url);
        $moneybox   = $variables['moneybox'];
        $moneyboxSetttings = $variables['settings'];
        $user       = '';
        $amount     = 0;
        $comision   = 0;
        if (\Session::has('tmp_participant')){
            $session = \Session::get('tmp_participant');
            $user       = $this->_userRepository->byEmail($session['email']);
            $amount     = $session['amount'];
            $comision   = $amount*.05;
        }

        return view('moneybox.summary')
            ->with('moneybox', $moneybox)
            ->with('moneyboxSettings', $moneyboxSetttings)
            ->with('participant', $user)
            ->with('amount', $amount)
            ->with('comision', $comision)
            ->with('pageTitle','Resumen de tu participación antes del pago');
    }

    /**
     * Send mail contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMailRequest(Request $request) {
        $moneybox = Moneybox::find($request->get('moneybox_id'));
        
        if (!$moneybox) {
            throw new EntityNotFoundException('La alcancía no existe.', -1);
        }

        if (!$request->hasFile('file')) {
            throw new Exception('El archivo es es requerido.');
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
        $extension = $request->file('file')->getClientOriginalExtension();
        $filename = $request->file('file')->getClientOriginalName();
        $mine = $request->file('file')->getClientMimeType();
        $size = $request->file('file')->getSize();
        $name =  uniqid() . '_' . $filename;

        if ($stored = Storage::disk('public')->put($name, $request->file('file'))) {
            $file = File::create(['name' => $name, 'size' => $size, 'path' => 'public', 'extension' => $extension]);
            $file->user_id = Auth::user()->id;
            $file->metadata = $mine;
            $file->owner = 'Order';
            $file->owner_id = $order->id;
            $file->save();
        }

        $data = [
            'moneybox' => $moneybox,
            'order' => $order,
            'file' => $file
        ];

        if (true == $withMail) {

            Mail::send('emails.request', $data, function ($message) use ($user, $file) {

                $pdf = Storage::disk('public')->get($file->name);
                $message->from($user->email, $user->username);
                //$message->to('coperachamexico@gmail.com');
                $message->to(['perezatanaciod@gmail.com']); // 'sanchezz985@gmail.com',
                $message->subject('Solicitud de Retiro');
                $message->attach($pdf, ['display' => $pdf->name, 'mime' => $pdf->metadata]);
            });
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

        Mail::send('emails.contact', $data, function ($message) use($request){
            $message->from($request->get('email'), 'Coperacha');
            $message->to('coperachamexico@gmail.com');
            $message->bcc(['sanchezz985@gmail.com','perezatanaciod@gmail.com']);
            $message->subject('Mensaje de Contacto');
        });

        return response()->json(['success' => true, 'data' => $data]);
    }

    /**
     * Send mail contact
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postMailInvitation(Request $request)
    {
        $moneybox = Moneybox::byUrl($request->get('url'))->first();

        if (!$moneybox) {
            throw new EntityNotFoundException('No existe la alcancía');
        }

        $emails = explode(',', $request->get('emails'));

        foreach ($emails as $email) {
            $data = [
                'moneybox' => $moneybox
            ];

            $record = Invitation::create(['email' => trim($email), 'status' => 0, 'moneybox_id' => $moneybox->id]);

            if ($record) {
                Mail::send('emails.invitation', $data, function ($message) use ($email) {
                    $message->from('contacto@coperacha.com.mx', 'Coperacha');
                    $message->to($email, 'Invitado');
                    $message->bcc(['perezatanaciod@gmail.com']);
                    $message->subject('Mensaje de Invitación');
                });
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

                Mail::send('emails.pendinginvitation', $data, function ($message) use ($invitation) {
                    $message->from('contacto@coperacha.com.mx', 'Coperacha');
                    $message->to($invitation->email, 'Invitado');
                    $message->bcc(['perezatanaciod@gmail.com']);
                    $message->subject('Mensaje de Invitación');
                });
            }
        }

        return response()->json(['success' => true, 'data' => $attends]);
    }

}
