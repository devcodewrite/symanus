<?php

namespace App\Notifications;

use App\Broadcasting\SmsChannel;
use App\Models\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class StudentAbsent extends Notification
{
    use Queueable;

    private $guardian;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['sms'];
    }

    public function toSMS ($notifiable) 
    {
       
        return (new SMSMessage())
            ->message($this->makeMessage($notifiable))
            ->destinations($this->guardian->phone);
    }

    public function toArray ($notifiable) {
        return [
            'guardian_id' => $this->id,
            'message' => $this->makeMessage($notifiable),
            'destinations' => $this->guardian->phone,
        ]; // leave empty if you dont understand it
    }

    private function makeMessage($notifiable)
    {
        $school = Setting::find('school_name');
        $school_name = $school?$school->value:'School';
        $school = Setting::find('school_phone');
        $school_phone = $school?$school->value:'0246092155';

        return "{$notifiable->firstname} {$notifiable->surname} is absent from $school_name on "
                .now('Africa/Accra')->format('d/m/y')
                .".Kindly call school on: $school_phone to confirm this claim. Thank you.\n\nPowered by CODEWRITE | www.codewrite.org";
    }
}
