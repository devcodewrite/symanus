<?php

namespace App\Notifications;

include_once (__DIR__.'../../../../lib/Zenoph/Notify/AutoLoader.php');

use Zenoph\Notify\Enums\AuthModel;
use Zenoph\Notify\Request\NotifyRequest;
use Zenoph\Notify\Request\SMSRequest;
use Zenoph\Notify\Enums\TextMessageType;

use Illuminate\Notifications\Notification;

class SMSChannel 
{
    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        if (method_exists($notifiable, 'routeNotificationForLog')) {
            $id = $notifiable->routeNotificationForSMS($notifiable);
        } else {
            $id = $notifiable->getKey();
        }

        $data = method_exists($notification, 'toSMS')
            ? $notification->toSMS($notifiable)
            : $notification->toArray($notifiable);
        if (empty($data)) {
            return false;
        }

        return $this->sendSMS();
    }
    private function sendSMS()
    {
        try {
            /**
             * Replace [messaging_website_domain] with the website domain on which account exists
             * 
             * Eg, if website domain is thewebsite.com, 
             * then set host as api.thewebsite.com
             * 
             * For further information, read the documentation for what you should set as the host
             */
            NotifyRequest::setHost('api.[messaging_website_domain]');
            
        
            /* By default, HTTPS connection is used to send requests. If you want to disable the use of HTTPS
             * and rather use HTTP connection, comment out the call to useSecureConnection below below this comment
             * block and pass false as argument to the function call.
             * 
             * When testing on local machine on which https connection does not work, you may encounter 
             * request submit error with status value zero (0). If you want to use HTTPS connection on local machine, 
             * then you can instruct that the Certificate Authority file (cacert.pem) which accompanies the SDK be 
             * used to be able to use HTTPS from your local machine by setting the second argument of the function call to 'true'.
             * That is:
             *         NotifyRequest::useSecureConnection(true, true);
             * 
             * You can download the current Certificates Authority file (cacert.pem) file from https://curl.se/docs/caextract.html
             * to replace the one in the main root directory of the SDK. Please maintain the file name as cacert.pem
             */
            // NotifyRequest::useSecureConnection(true);
            
            // initialise request
            $smsReq = new SMSRequest();
            $smsReq->setAuthModel(AuthModel::API_KEY);
            $smsReq->setAuthApiKey('YOUR_API_KEY');
            
            $smsReq->setSender('SENDER_ID');    // message sender Id must be requested from account to be used
            $smsReq->setMessage('Hello {$name}! Your balance is ${$balance}.');     // must be single quoted string
            $smsReq->setMessageType(TextMessageType::TEXT);
            
            // data for two clients
            $data[] = array('name'=>'Daniel', 'phone'=>'233246314915', 'balance'=>59.45);
            $data[] = array('name'=>'Oppong', 'phone'=>'0207729851', 'balance'=>984.45);
            
            // add personalised data to destinations
            foreach ($data as $clientData){
                $phone = $clientData['phone'];
                $name  = $clientData['name'];
                $balance = $clientData['balance'];
                $values = array($name, $balance);
                
                $smsReq->addPersonalisedDestination($phone, false, $values);
            }
            
            // submit must be after the loop
            return $smsReq->submit();
        } 
        
        catch (\Exception $ex) {
            error_log($ex->getMessage());
        }
    }
}
