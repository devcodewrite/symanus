<?php

namespace App\Notifications;

use App\Models\Attendance;
use App\Models\Setting;
use Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AttendanceSubmitted extends Notification
{
    use Queueable;
    public $attendance;
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
        if(!$notifiable->phone) return false;
        return (new SMSMessage())
            ->message($this->makeMessage($notifiable))
            ->destinations($notifiable->phone);
    }

    public function toArray ($notifiable) {
        if(!$notifiable->phone) return null;

        return [
            'id' => Hash::make(uniqid()),
            'message' => $this->makeMessage($notifiable),
            'destinations' => $notifiable->phone,
        ]; // leave empty if you dont understand it
    }

    private function makeMessage($notifiable)
    {
        $setting = new Setting();
        $school_name = $setting->getValue('school_name', 'School');
  
        $firstname =$this->attendance->user->firstname;
        $surname = $this->attendance->user->surname;
        $phone = $this->attendance->user->phone;
        return "$firstname $surname has submitted attendance of "
                .date('d/m/y',strtotime($this->attendance->adate))
                ." for Approval at $school_name.\nContact: $phone.\nKindly validate and approve it. Thank you.\n\nPowered by CODEWRITE | www.codewrite.org";
    }
}
