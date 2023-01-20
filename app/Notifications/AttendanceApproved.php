<?php

namespace App\Notifications;

use App\Models\Attendance;
use App\Models\Setting;
use Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AttendanceApproved extends Notification
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
        if(!$notifiable->user) return false;
        return (new SMSMessage())
            ->message($this->makeMessage($notifiable))
            ->destinations($notifiable->user->phone);
    }

    public function toArray ($notifiable) {
        if(!$notifiable->user) return null;

        return [
            'id' => Hash::make(uniqid()),
            'message' => $this->makeMessage($notifiable),
            'destinations' => $notifiable->user->phone,
        ]; // leave empty if you dont understand it
    }

    private function makeMessage($notifiable)
    {
        $setting = new Setting();
        $school_name = $setting->getValue('school_name', 'School');
  
        $firstname =$this->attendance->user->firstname;
        $surname = $this->attendance->user->surname;
        $phone = $this->attendance->user->phone;
        return "$firstname $surname has submitted attendance for "
                .date('d/m/y',strtotime($this->attendance->adate))
                .".School: $school_name, contact: $phone.Kindly validate and approve. Thank you.\n\nPowered by CODEWRITE | www.codewrite.org";
    }
}
