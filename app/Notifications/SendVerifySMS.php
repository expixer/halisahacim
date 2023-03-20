<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class SendVerifySMS extends Notification
{
    public function __construct()
    {
        //
    }

    public function via($notifiable): array
    {
        return [];
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage())
            ->content("Doğrulama kodunuz {$notifiable->mobile_verify_code}");
    }

    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }

}
