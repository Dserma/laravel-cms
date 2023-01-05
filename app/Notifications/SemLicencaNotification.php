<?php

namespace App\Notifications;

use App\Models\Semlicenca;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SemLicencaNotification extends Notification
{
    use Queueable;

    private $request;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Semlicenca $item)
    {
        $this->item = $item;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->subject('Guitarpedia Admin - Falta de Licença do Zoom')
        ->greeting('Olá ' . $notifiable->nome . '!')
        ->line('Alguém tentou agendar uma aula, mas devido à falta de licenças do Zoom, não foi possível. Abaixo, seguem os dados:')
        ->line('**Aluno:** ' . $this->item->aluno->fullName)
        ->line('**Professor:** ' . $this->item->professor->fullName)
        ->line('**Aula:** ' . $this->item->nomeAula)
        ->line('**Data:** ' . $this->item->dataHora);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
