<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use TarfinLabs\Netgsm\NetgsmChannel;
use TarfinLabs\Netgsm\Sms\NetgsmSmsMessage;

class RegisteredPlayerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private User $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        $channels = ['mail'];

        // $channels[] = 'vonage';
/*        if ($notifiable->routes[NetgsmChannel::class]) {
            $channels[] = NetgsmChannel::class;
        }*/

        return [];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->subject('Tebrikler! Halısahacım uygulamasına başarıyla kaydoldunuz.')
            ->greeting("Tebrikler {$notifiable->name}!")
            ->line('Halısahacım uygulamasına başarıyla kaydoldunuz.');
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toNetgsm($notifiable)
    {
        return (new NetGsmSmsMessage("Tebrikler {$notifiable->name}! Halısahacım uygulamasına başarıyla kaydoldunuz."));
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage())
            ->content("Tebrikler {$notifiable->name}! Halısahacım uygulamasına başarıyla kaydoldunuz.");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
