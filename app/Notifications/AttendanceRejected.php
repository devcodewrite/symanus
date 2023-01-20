<?php

namespace App\Notifications;

use App\Models\Attendance;
use App\Models\Setting;
use Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AttendanceRejected extends Notification
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
        if(!$notifiable->user) return null;

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
  
        $firstname =$this->attendance->approvalUser->firstname;
        $surname = $this->attendance->approvalUser->surname;
        $phone = $this->attendance->approvalUser->phone;
        return "$firstname $surname has rejected your attendance  of "
                .date('d/m/y',strtotime($this->attendance->adate))
                ." at $school_name.\nContact: $phone. Thank you.\n\nPowered by CODEWRITE | www.codewrite.org";
    }
}
