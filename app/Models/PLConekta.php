<?php

namespace App\Models;

use Carbon\Carbon;
use App\Http\Requests\PLRequest;

abstract class PLConekta {

    /**
     * @var String
     */
    protected $api_key;

    /**
     * @var
     */
    protected $charge;

    abstract public function createCharge(PLRequest $request);

    protected function toCents($pesos)
    {
        return $pesos * 100;
    }

    protected function generate_uid()
    {
        $date = new Carbon();
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'.$date->toDateTimeString();
        $characters = str_replace(array(':','-'), 'z', $characters);
        return substr(str_shuffle(trim($characters)), 0, 10);
    }

}