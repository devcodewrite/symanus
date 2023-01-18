<?php

namespace App\Notifications;

use App\Models\Setting;
use Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TodayIncome extends Notification
{
    use Queueable;

     /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Attendance $of)
    {
        $this->attendance = $of;
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
        if(!$notifiable->guardian) return false;
        return (new SMSMessage())
            ->message($this->makeMessage($notifiable))
            ->destinations($notifiable->guardian->phone);
    }

    public function toArray ($notifiable) {
        if(!$notifiable->guardian) return null;

        return [
            'id' => Hash::sha1(uniqid()),
            'message' => $this->makeMessage($notifiable),
            'destinations' => $notifiable->guardian->phone,
        ]; // leave empty if you dont understand it
    }

    private function makeMessage($notifiable)
    {
        $school = Setting::find('school_name');
        $school_name = $school?$school->value:'School';
        $school = Setting::find('school_phone');
        $school_phone = $school?$school->value:'0246092155';
        $firstname =$notifiable->firstname;
        $surname = $notifiable->surname;

        return "$firstname $surname is absent from $school_name on "
                .date('d/m/y',strtotime($this->attendance->adate))
                .".Kindly call $school_name on: $school_phone to confirm this claim. Thank you.\n\nPowered by CODEWRITE | www.codewrite.org";
    }
}
