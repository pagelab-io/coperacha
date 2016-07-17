<?php

namespace App\Http\Responses;


class PLResponse {

    //region attributes

    /**
     * @var Integer
     */
    public $status;

    /**
     * @var String
     */
    public $description;

    /**
     * @var Object
     */
    public $data;

    //endregion

    //region Static Methods
    //endregion

    public function __construct()
    {
        $this->status = 200;
        $this->description = '';
        $this->data = null;
    }

    //region Private Methods
    //endregion

    //region Methods
    //endregion

    //region Abstract methods
    //endregion

}