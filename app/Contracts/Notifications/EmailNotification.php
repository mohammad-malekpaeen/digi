<?php

namespace App\Contracts\Notifications;

interface EmailNotification
{
    public function toMail($notifiable);
}
