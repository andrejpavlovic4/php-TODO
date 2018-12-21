<?php

namespace App;

class Flash
{

    /**
     * Success message type
     */
    const SUCCESS = 'success';

    /**
     * Information message type
     */
    const INFO = 'info';

    /**
     * Warning message type
     */
    const WARNING = 'warning';

    /**
     * Add a message
     */
    //public static function addMessage($message)
    public static function addMessage($message, $type = 'success')
    {
        if (! isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }

        $_SESSION['flash_notifications'][] = [
            'body' => $message,
            'type' => $type
        ];
    }

    /**
     * Get all the messages
     */
    public static function getMessages()
    {
        if (isset($_SESSION['flash_notifications'])) {
            //return $_SESSION['flash_notifications'];
            $messages = $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);

            return $messages;
        }
    }
}
