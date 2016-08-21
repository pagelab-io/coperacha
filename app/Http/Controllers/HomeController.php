<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Http\Requests\PLRequest;
use App\Http\Responses\PLResponse;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    /**
     * @var SettingRepository
     */
    private $_settingRepository;

    /**
     * HomeController constructor.
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->_settingRepository = $settingRepository;
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
        return view('moneybox.create')
            ->with('categories', $categories)
            ->with('pageTitle','Crear mi alcancía 1/2');
    }

    /**
     * @param PLRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateMoneyboxPage2(PLRequest $request){

        $request->merge(array('path' => '/moneybox'));
        $response = $this->_settingRepository->childsOf($request);
        \Log::info($response->data);
        return view('moneybox.step-2')
            ->with('settings', $response->data)
            ->with('pageTitle','Crear mi alcancía 2/2');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDashboardPage(Request $request){

        return view('moneybox.dashboard')
            ->with('pageTitle','Mis Alcancías');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDetailPage(Request $request){

        // TODO -  agregar variables con las que se inicializara la vista
        // crear metodo para la busqueda por la url (no se si ya esta)
        return view('moneybox.detail')
            ->with('pageTitle','Alcancía de prueba No. 1');
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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getJoinPage(Request $request){

        return view('moneybox.join')
            ->with('pageTitle','Participa');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSummaryPage(Request $request){

        return view('moneybox.summary')
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
            $message->from('contacto@coperacha.com.mx', 'Contacto');
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
