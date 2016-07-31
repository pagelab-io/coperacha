<?php

namespace App\Models;

use App\Http\Requests\PLRequest;

interface IPLPayment {

    public function sendPayment(PLRequest $request);
}