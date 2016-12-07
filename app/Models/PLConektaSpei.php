<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 31/07/2016
 * Time: 03:08 PM
 */

namespace App\Models;

use App\Http\Requests\PLRequest;
use App\Repositories\MoneyboxRepository;
use App\Repositories\PersonRepository;

class PLConektaSpei extends PLConekta implements IPLPayment{

    /**
     * @var PersonRepository
     */
    private $_personRepository;

    /**
     * @var MoneyboxRepository
     */
    private $_moneyboxRepository;

    public function __construct(PersonRepository $personRepository, MoneyboxRepository $moneyboxRepository)
    {
        $this->_personRepository = $personRepository;
        $this->_moneyboxRepository = $moneyboxRepository;
        $this->api_key = (env('APP_ENV') == 'local') ? env('LOCAL.CONECKTA_API_KEY') : env('PRODUCTION.CONECKTA_API_KEY');
    }

    /**
     * Return a new charge for OXXO payment
     *
     * @param PLRequest $request
     * @return mixed
     * @throws \Exception
     */
    public function createCharge(PLRequest $request)
    {
        \Conekta::setApiKey($this->api_key);
        $person = null;
        $person = null;
        $charge = null;

        \Log::info("=== Creating spei charge ===");

        \Log::info("=== Searching person ===");
        try{$person = $this->_personRepository->byId($request->get('person_id')); }
        catch(\Exception $ex){ throw new \Exception("Unable to find person", -1); }
        \Log::info("=== Person : ".$person."===");

        \Log::info("=== Searching moneybox ===");
        try{$moneybox = $this->_moneyboxRepository->byId($request->get('moneybox_id')); }
        catch(\Exception $ex){ throw new \Exception("Unable to find moneybox", -1); }
        \Log::info("=== Moneybox : ".$moneybox."===");

        try {

            \Log::info("=== creating charge by $ ".$request->get('amount')." ===");

            $this->charge = \Conekta_Charge::create(array(
                'description'=> 'Nueva Coperacha',
                'reference_id'=> $this->generate_uid(),
                'amount'=> $this->toCents($request->get('amount')),
                'currency'=>'MXN',
                'bank'=> array(
                    'type'=> 'spei'
                ),
                'details'=> array(
                    'name'=> $person->name." ".$person->lastname,
                    'phone'=> $person->phone,
                    'email'=> $person->user->email,
                    'line_items'=> array(
                        array(
                            'name'=> 'Participación en alcancía - '.$moneybox->name,
                            'description'=> 'Participacion en alcancía',
                            'unit_price'=> $this->toCents($request->get('amount')),
                            'quantity'=> 1,
                        )
                    ),
                )
            ));

        } catch(\Exception $ex) {
            \Log::info("=== Unexpected error in Conekta API call ===");
            throw $ex;
        }

        return $this->charge;
    }

    public function sendPayment(PLRequest $request)
    {
        $charge = json_decode($this->createCharge($request), true);
        return $charge;
    }
}