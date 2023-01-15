<?php

namespace App\Notifications;

require (__DIR__.'../../../lib/Zenoph/Notify/AutoLoader.php');

use Zenoph\Notify\Enums\AuthModel;
use Zenoph\Notify\Request\NotifyRequest;
use Zenoph\Notify\Request\SMSRequest;
use Zenoph\Notify\Enums\TextMessageType;

use Illuminate\Notifications\Notification;
use stdClass;

class SMSChannel 
{
    private $message;

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  mixed $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {

        if (method_exists($notifiable, 'routeNotificationForLog')) {
            $id = $notifiable->routeNotificationForSMS($notifiable);
        } else {
            $id = $notifiable->getKey();
        }
        if(method_exists($notification, 'toSMS')){
            return $this->sendSMS($notifiable, $notification);
        }
        return false;
    }
     /**
     * Send the given sms.
     *
     * @param  mixed  $notifiable
     * @param  mixed $notification
     * @return object
     */
    private function sendSMS($notifiable, Notification $notification)
    {
        $result = new stdClass();
        $sms = $notification->toSMS($notifiable);
        if(!$sms) return false;
        try {
            NotifyRequest::setHost(env('SMSONLINE_API_HOST', 'api.smsonlinegh.com'));

            if(env('APP_ENV') !== 'local'){
                NotifyRequest::useSecureConnection(true);
            }
            
            // initialise request
            $smsReq = new SMSRequest();
            $smsReq->setAuthModel(AuthModel::API_KEY);
            $smsReq->setAuthApiKey(env('SMSONLINE_API_KEY'));
            
            $smsReq->setSender(env('SMSONLINE_SENDER_ID', 'SYMANUS'));    // message sender Id must be requested from account to be used
            $smsReq->setMessage($sms->message);     // must be single quoted string
            $smsReq->setMessageType(TextMessageType::TEXT);
            
            // add message destinations. 
            if(gettype($sms->destinations) === 'string') 
                $smsReq->adddestination($sms->destinations);
            
            if(gettype($sms->destinations) === 'array')
                 $result->destination_count =$smsReq->addDestinationsFromCollection($sms->destinations);
            
                 // submit must be after the loop
            $msgResp = $smsReq->submit();
            if($msgResp->getHttpStatusCode()){
                $result->status = true;
                $result->message = "SMS sent successfully.";
                $result->sms = $sms;
            }
            else {
                $result->status = false;
                $result->message = "Message couldn't be sent!";
            }
        } 
        
        catch (\Exception $ex) {
            $result->status = false;
            $result->message =  $ex->getMessage();
        }
    }
}
