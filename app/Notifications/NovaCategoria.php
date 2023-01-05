<?php

namespace App\Notifications;

use App\Http\Requests\Sistema\Professores\NovaCategoriaRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NovaCategoria extends Notification
{
    use Queueable;

    private $request;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(NovaCategoriaRequest $request)
    {
        $this->request = $request;
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
        ->subject('Guitarpedia Admin - Solicitação de nova categoria')
        ->greeting('Olá ' . $notifiable->nome . '!')
        ->line('O professor **' . $this->request->p . '** solicitou o cadastro de uma nova categoria. Abaixo segue a mensagem dele:')
        ->line('**Mensagem:** ' . $this->request->mensagem);
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
