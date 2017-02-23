<?php
/**
 * Created by Emmanuel Sánchez Luna.
 * Github user: sanchezz985
 * Date: 28/01/2017
 * Time: 16:06
 */

namespace App\Utilities;
use App\Http\Responses\PLResponse;
use Illuminate\Validation\ValidationException;


/**
 * Class responsible for the handling of the responses
 * Class PLMessageManager
 * @package App\Utilities
 */
class PLMessageManager
{

    /**
     * Manage a Response when an exception is throw
     * @param \Exception $ex
     * @return PLResponse
     */
    public static function managerException(\Exception $ex)
    {
        $response = new PLResponse();

        if ($ex instanceof ValidationException) {
            $response->status = $ex->getCode();
            $response->description = $ex->getResponse();
            $response->data = $ex->getMessage();
        } else {
            $response->status = $ex->getCode();
            $response->description = $ex->getMessage();
            $response->data = $ex->getTraceAsString();
        }

        return $response;
    }

}