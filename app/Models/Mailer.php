<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 29/08/2016
 * Time: 08:27 PM
 */

namespace App\Models;

use Illuminate\Support\Facades\Mail;

class Mailer {

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
        \Log::info("sending email ...");
        Mail::send($key, $data, function ($message) use ($options){
            $message->from('no-reply@pagelab.io', 'Coperacha.com.mx team');
            $message->to($options['to']);
            $message->bcc($options['bcc']);
            $message->subject($options['title']);
        });
        \Log::info("email sent successfully");
    }

} 