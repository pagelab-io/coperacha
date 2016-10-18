<?php

namespace App\Http\Controllers;

use App\Entities\Category;
use App\Entities\CountryCode;
use App\Entities\Invitation;
use App\Entities\Moneybox;
use App\Entities\File;
use App\Http\Requests\PLRequest;
use App\Repositories\MoneyboxRepository;
use App\Repositories\SettingRepository;
use App\Repositories\UserRepository;
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
     * HomeController constructor.
     * @param SettingRepository $settingRepository
     * @param MoneyboxRepository $moneyboxRepository
     * @param UserRepository $userRepository
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

            $post1 = new Post();
            $post1->post_title = "Miguel, 24, Veracruz.";
            $post1->post_content = "\"Acabo de participar en una alcancía para el regalo de un amigo. Fácil y simple de utilizar y muy práctico.\"";

            $post2 = new Post();
            $post2->post_title = "Juan, 22, Mazatlán.";
            $post2->post_content = "\"Creo que está nueva forma de \"Coperacha online\" es una manera práctica de recaudar dinero entre amigos, sobre todo si estos se encuentran dispersos en varios lugares.\"";

            $post3 = new Post();
            $post3->post_title = "Ricardo, 33, Cancún.";
            $post3->post_content = "\"¡Lo recomiendo! Muy práctico para manejar tus gastos en grupo. Totalmente fiable y bastante sencillo.\"";

            $post4 = new Post();
            $post4->post_title = "María, 25, Querétaro.";
            $post4->post_content = "\"¡Al 100! Rápido, eficaz, seguro! Perfecto como servicio.\"";

            $post5 = new Post();
            $post5->post_title = "Sofía, 29, Ciudad de México.";
            $post5->post_content = "\"Organizé el baby shower de mi mejor amiga recaudando el dinero entre nuestras amigas de todas partes del mundo. Increíble.\"";

            $post6 = new Post();
            $post6->post_title = "Heber, 28, Veracruz.";
            $post6->post_content = "\"Pude ahorrar el dinero que me faltaba para mi viaje a Italia sin estarle quitando a mis ahorros que tenía en la casa.\"";

            $post7 = new Post();
            $post7->post_title = "Humberto, 30, Tijuana.";
            $post7->post_content = "\"Nunca nos habíamos organizado todos así de fácil. Hice una alcancía con mis amigos de la prepa y nos fuimos de vacaciones todos juntos, estuvo padrísimo!.\"";

            $post8 = new Post();
            $post8->post_title = "Andrea, 24, Puebla.";
            $post8->post_content = "\"Me encantó que no te quita nada de tiempo. Entre mis hermanos y yo, hicimos una alcancía en coperacha para el regalo de cumpleaños de mamá.\"";

            $post9 = new Post();
            $post9->post_title = "Tania, 28, León.";
            $post9->post_content = "\"¡Lo recomiendo! Muy práctico para manejar tus gastos en grupo. Totalmente fiable y bastante sencillo.\"";

            $post10 = new Post();
            $post10->post_title = "Caro, 24, Guadalajara.";
            $post10->post_content = "\"Está súper fácil pagar para juntar el dinero y así. Junté con mis amigas para nuestro viaje de graduación.\"";

            $testimonials->push($post1);
            $testimonials->push($post2);
            $testimonials->push($post3);
            $testimonials->push($post4);
            $testimonials->push($post5);
            $testimonials->push($post6);
            $testimonials->push($post7);
            $testimonials->push($post8);
            $testimonials->push($post9);
            $testimonials->push($post10);

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
     * @param $url
     * @throws \Exception
     * @return Factory|\Illuminate\View\View
     */
    public function getCreateMoneyboxPage(Request $request, $url = '') {
        $moneybox = null;
        $moneyboxSettings   = null;
        $privacyoption      = 0;
        $amountoption       = 0;
        $title              = "";
        if ($url != "") {
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
            ->with('pageTitle',$title);
    }

    /**
     *
     * @param PLRequest $request
     * @return Factory|\Illuminate\View\View
     */
    public function getDashboardPage(PLRequest $request){
        $request->merge(array('person_id' => \Auth::user()->person->id));
        $response = $this->_moneyboxRepository->getAll($request);
        return view('moneybox.dashboard')
            ->with('moneyboxes', $response->data)
            ->with('pageTitle','Mis Alcancías');

    }

    /**
     * @param $url
     * @internal param Request $request
     * @return Factory|\Illuminate\View\View
     */
    public function getDetailPage($url){
        $variables = $this->_moneyboxRepository->getByURL($url);
        $moneybox = $variables['moneybox'];
        $person = $variables['person'];
	
	    $settings = $variables["settings"];
        $partiticipantsnumber = $variables['partiticipantsnumber'];

        if (count($moneybox->files) > 0) {
            $moneybox->lastfile = $moneybox->files->last();
        }

        if ($moneybox->active == 1) {
            return view('moneybox.detail')
                ->with('moneybox', $moneybox)
                ->with('settings', $settings)
                ->with('person', $person)
                ->with('partiticipantsnumber', $partiticipantsnumber)
                ->with('pageTitle',$moneybox->name);
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
            Mail::send('emails.request', $data, function ($message) use ($user) {
                $message->from($user->email, $user->person->fullName());
                $message->to('coperachamexico@gmail.com', 'Coperacha.com.mx');
                $message->bcc(['sanchezz985@gmail.com', 'perezatanaciod@gmail.com']);
                $message->subject('Solicitud de Retiro');
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

        Mail::send('emails.contact', $data, function ($message) use($request) {
            $message->from($request->get('email'), 'Contacto');
            $message->to('coperachamexico@gmail.com');
            $message->bcc(['sanchezz985@gmail.com', 'perezatanaciod@gmail.com']);
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
    public function postMailThanks(Request $request) {
        $url = $request->get('url');
        $moneybox = Moneybox::byUrl($url)->with('participants')->first();
        if (!$moneybox) {
            throw new EntityNotFoundException('La alcancía no existe.', -1);
        }
        // Owner of the moneybox
        $owner = $moneybox->person->user;
        // Get users list
        $users = [];

        foreach ($moneybox->participants as $participant) {
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

                Mail::send('emails.thanks', $data, function ($message) use ($owner, $user) {
                    $message->from($owner->email, $owner->username);
                    $message->to($user->email, $user->username);
                    $message->bcc(['sanchezz985@gmail.com', 'perezatanaciod@gmail.com', 'coperachamexico@gmail.com']);
                    $message->subject('Agradecimiento');
                });
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

        $emails =  preg_split("/[\s,;:]+/", $request->get('emails'));
        foreach ($emails as $email) {
            $validator = Validator::make(['mail' => $email], [
                'mail' => 'required|email'
            ]);

            if ($validator->passes()) {
                $data = ['moneybox' => $moneybox];
                $record = Invitation::create([
                    'email' => trim($email),
                    'status' => 0,
                    'moneybox_id' => $moneybox->id]);

                if ($record) {

                    Mail::send('emails.invitation', $data, function ($message) use ($email) {
                        $message->from('hola@coperacha.com.mx', 'Coperacha.com.mx');
                        $message->to($email, 'Invitado ' . $email);
                        $message->bcc(['sanchezz985@gmail.com', 'perezatanaciod@gmail.com', 'coperachamexico@gmail.com']);
                        $message->subject('Mensaje de Invitación');
                    });
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

                Mail::send('emails.pendinginvitation', $data, function ($message) use ($invitation) {
                    $message->from('hola@coperacha.com.mx', 'Coperacha.com.mx');
                    $message->to($invitation->email, 'Invitado');
                    $message->bcc(['sanchezz985@gmail.com', 'perezatanaciod@gmail.com', 'coperachamexico@gmail.com']);
                    $message->subject('Mensaje de Recordatorio');
                });
            }
        }

        return response()->json(['success' => true, 'data' => $attends]);
    }
}
