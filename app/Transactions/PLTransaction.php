<?php

namespace App\Transactions;


use App\Http\Requests\PLRequest;

abstract class PLTransaction {

    abstract function executeTx(PLRequest $request, $params = array());

} 