<?php

namespace App;

use App\Config;

class Mail
{

    /**
     * Send a message
     */
    public static function send($to, $subject, $text, $html)
    {
        $to = $to;
        $subject = $subject;
                                   
        $headers = "From: " . "andrejpavlovic4@gmail.com" . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $message = $html;
        mail($to, $subject, $message, $headers);
                                       
    }
}
