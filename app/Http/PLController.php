<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 19/06/2016
 * Time: 12:50 AM
 */

namespace App\Http;


use App\Http\Controllers\Controller;

/**
 * PageLab Controller
 * Class PLController
 * @package App\Http
 */
class PLController extends Controller {

    //region attributes

    /**
     * response for each service
     * @var array
     */
    protected $_response = [
        'status' => 200,
        'description' => '',
        'data' => null
    ];

    protected $_className = '';

    //endregion

    //region Static Methods
    //endregion

    public function __constructor()
    {
        $this->_className = "";
    }

    //region Private Methods
    //endregion

    //region Methods
    public function printRequest(PLRequest $request)
    {
        \Log::info(
            "\n=========== Request =========== \n".
            "Uri: ".$request->getUri()."\n".
            "ClientIp: ".$request->getClientIp()."\n".
            "SessionId: ".$request->getSession()->getId()."\n".
            "content: ".$request->getContent().
            "\n=========== end Request =========== \n"
        );
    }

    public function printResponse($response, $sessionId){
        \Log::info(
            "\n=========== Response =========== \n".
            "SessionId: ".$sessionId."\n".
            "Response: ".response()->json($response)."\n".
            "\n=========== end Response =========== \n"
        );
    }
    //endregion

} 