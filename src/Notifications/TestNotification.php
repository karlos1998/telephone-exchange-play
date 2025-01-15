<?php

namespace Karlos3098\TelephoneExchangePlay\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Karlos3098\TelephoneExchangePlay\Interfaces\TelephoneExchangePlayNotification;
use Karlos3098\TelephoneExchangePlay\Services\PlayMessage;

class TestNotification extends Notification implements TelephoneExchangePlayNotification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [
            'play-exchange',
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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

    public function toPlayTelephoneExchange($notifiable): PlayMessage
    {
        return (new PlayMessage)
            ->line("testowa")
            ->line("wiadomość");
    }
}
