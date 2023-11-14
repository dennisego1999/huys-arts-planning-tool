<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        $this->connection = 'redis';
    }

    public function via(object $notifiable): array
    {
        return ['broadcast', 'database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Hello!',
            'text' => 'Welcome to this dashboard' ,
            'type' => 'info'
        ];
    }
}
