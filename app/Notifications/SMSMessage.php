<?php 

namespace App\Notifications;

class SMSMessage {

    public string $message = '';
    public $destinations = '';

    /**
     * @param string $message
     * @return SMSMessage
     */
    public function message(string $message = null)
    {
        if(!$message) return $this->message;
        $this->message = $message;
        return $this;
    }
    /**
     * @param mixed $destinations
     * @return SMSMessage
     */
    public function destinations($destinations = null)
    {
        if(!$destinations) return $this->destinations;
        $this->destinations = $destinations;
        return $this;
    }
}