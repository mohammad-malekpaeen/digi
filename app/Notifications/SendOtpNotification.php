<?php

namespace App\Notifications;

use App\Contracts\Notifications\EmailNotification;
use App\Mail\OtpEmailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class SendOtpNotification extends Notification implements EmailNotification, ShouldQueue
{

    use Queueable;

    /**
     * @param string $email
     * @param string $otp
     */
    public function __construct(
        protected string $email,
        protected string $otp,
    )
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new OtpEmailMessage($this->otp))
            ->to($this->email);
    }
}
