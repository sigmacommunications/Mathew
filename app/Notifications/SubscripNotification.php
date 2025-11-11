<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscripNotification extends Notification
{
    use Queueable;

    
    protected $userName;
    protected $packageName;

    /**
     * Create a new notification instance.
     */
    public function __construct($userName, $packageName)
    {
		
        $this->userName = $userName;
        $this->packageName = $packageName;
    }

    
		public function via(object $notifiable): array
		{
			return ['database'];
		}


	 public function toDatabase($notifiable)
     {
		 $message = "Congratulations! You've successfully subscribed. Package Duration: $this->packageName";
       
        
        return [
            'message' => $message,
        ];
	 }
		
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}

