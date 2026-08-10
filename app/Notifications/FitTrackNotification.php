<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class FitTrackNotification extends Notification
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $message,
        public string $type = 'info'
    ) {
    }

    /**
     * Store the notification in the database.
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Data saved inside the notifications table.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
        ];
    }
}