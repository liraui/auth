<?php

namespace LiraUi\Auth\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtacNotification extends Notification
{
    /**
     * Create a new OTAC notification instance.
     */
    public function __construct(
        public array $data
    ) {
        //
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Requested verification code '.$this->data['code'])
            ->line('The following verification code was requested for your account')
            ->line('**'.$this->data['code'].'**')
            ->line('It will expire in '.$this->data['expires'].' minutes. If you did not request this code, no further action is required.');
    }
}
