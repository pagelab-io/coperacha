<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

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
            $message->cc('sanchezz985@gmail.com', 'Emmanuel');
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
