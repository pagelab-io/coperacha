<?php
/**
 * Created by Emmanuel Sánchez Luna.
 * Github user: sanchezz985
 * Date: 27/01/2017
 * Time: 23:15
 */

namespace App\Utilities;

use Illuminate\Support\Facades\Log;

/**
 * Class for logging with the className or file where log is used.
 * Class PLCustomLog
 */
class PLCustomLog
{

    /**
     * @var String
     */
    private $_className;

    /**
     * PLCustomLog constructor.
     * @param $classname
     */
    public function __construct($classname)
    {
        $this->_className = $classname;
    }

    /**
     * Print message in laravel.log
     * @param $message
     */
    public function info($message)
    {
        Log::info("[".$this->_className."] ".$message);
    }

}
