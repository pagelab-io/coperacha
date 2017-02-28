<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 29/08/2016
 * Time: 08:27 PM
 */

namespace App\Models;

use App\Utilities\PLCustomLog;
use Illuminate\Support\Facades\Mail;

class Mailer {

    /**
     * @var PLCustomLog
     */
    public $log;

    public function __construct()
    {
        $this->log = new PLCustomLog("Mailer");
    }

    /**
     * Send email
     * key - the string where the template exist, example : $key = emails.welcome
     * options - variables that are nedeed by the template
     *
     * @param $key
     * @param array $data
     * @param array $options
     */
    public function send($key, $data = array(), $options = array())
    {
        $this->log->info("Sending ".$key." email");
        Mail::send($key, $data, function ($message) use ($options){
            $message->from( isset($options['from']) ? $options['from'] : 'hola@coperacha.com.mx' , 'Coperacha.com.mx');
            $message->to($options['to']);
            $message->bcc($options['bcc']);
            $message->subject($options['title']);
        });
        $this->log->info("email sent successfully");
    }

} 