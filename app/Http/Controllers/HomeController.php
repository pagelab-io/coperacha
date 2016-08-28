<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Repositories\MoneyboxRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateMoneyboxPage(Request $request){
        $categories = Category::all();
        $request->merge(array('path' => '/moneybox'));
        $response = $this->_settingRepository->childsOf($request);
        \Log::info($response->data);
        return view('moneybox.create')
            ->with('categories', $categories)
            ->with('settings', $response->data)
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRequestPage(Request $request){

        return view('moneybox.request')
            ->with('pageTitle','Solicitud de Dinero');
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
    public function postMailContact(Request $request) {

        $data = [
            'name'    => $request->get('name'),
            'email'   => $request->get('email'),
            'content' => $request->get('content'),
        ];

        Mail::send('emails.contact', $data, function ($message) {
            $message->from('contacto@coperacha.com.mx', 'Coperacha');
            $message->to('perezatanaciod@gmail.com', 'Daniel');
            $message->cc('sanchezz985@gmail.com', 'Emmanuel');
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
    public function getMailContact(Request $request) {

        return view('emails.contact')
            ->with('name', 'Daniel')
            ->with('email', 'daniel@pagelab.io')
            ->with('content', 'The Laravel framework has a few system requirements. Of course, all of these requirements are satisfied by the Laravel Homestead virtual machine, so it\'s highly recommended that you use Homestead as your local Laravel development environment.');
    }

    /**
     * JUST FOR TEST - DELETE IN A FUTURE
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTestPage()
    {
        return view('pages.test', ['pageTitle' => 'Bienvenido']);
    }
}
