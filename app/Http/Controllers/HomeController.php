<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

    /**
     * HomeController constructor.
     */
    public function __construct()
    {

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
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getCreateMoneyboxPage2(Request $request){
        $categories = Category::all();

        return view('moneybox.step-2')
            ->with('categories', $categories)
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
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'content' => $request->get('content'),
        ];

        Mail::send('emails.contact', $data, function ($message) {
            $message->from('contacto@coperacha.com.mx', 'Contacto');
            $message->to('perezatanaciod@gmail.com', 'Daniel');
            // $message->cc('sanchezz985@gmail.com', 'Emmanuel');
            $message->subject('Mensaje de Contacto');
        });

        return response()->json(['success' => true, 'data' => $data]);
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
