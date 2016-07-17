<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 19/06/2016
 * Time: 12:50 AM
 */

namespace App\Http\Controllers;

use App\Http\Responses\PLResponse;

class PLController extends Controller{

    //region attributes

    /**
     * @var PLResponse
     */
    private $_response;

    //endregion

    //region Static Methods
    //endregion

    public function __construct(PLResponse $response)
    {
        $this->setResponse($response);
    }

    //region Private Methods
    //endregion

    //region Methods

    public function getResponse()
    {
        return $this->_response;
    }

    public function setResponse(PLResponse $response)
    {
        $this->_response = $response;
    }

    //endregion

}