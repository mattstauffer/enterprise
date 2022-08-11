<?php

namespace App\Notifications;

use App\Models\Form;
use App\Models\Response;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConfirmWorkshop extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Form $confirmation,
        public Response $workshop,
    ) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject("You have a new task to complete for {$this->workshop->name}")
            ->markdown('mail.confirm-workshop', [
                'title' => $this->workshop->name,
                'event' => $this->confirmation->event->name,
                'ends' => $this->confirmation->end->timezone($this->confirmation->event->timezone)->format('F j, Y'),
                'url' => url("/dashboard/workshops?response_id={$this->workshop->id}")
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
