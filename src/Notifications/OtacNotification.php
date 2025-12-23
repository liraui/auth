<?php

namespace LiraUi\Auth\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OtacNotification extends Notification
{
    /**
     * Create a new OTAC notification instance.
     *
     * @param  array<string, mixed>  $data
     */
    public function __construct(
        public array $data
    ) {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        /** @var string $code */
        $code = $this->data['code'];

        /** @var \Carbon\Carbon $expires */
        $expires = $this->data['expires'];

        return (new MailMessage)
            ->subject('Requested verification code '.$code)
            ->line('The following verification code was requested for your account')
            ->line('**'.$code.'**')
            ->line('It will expire in '.$expires->diffForHumans().'. If you did not request this code, no further action is required.');
    }
}
