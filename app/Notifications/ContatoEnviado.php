<?php

namespace App\Notifications;

use App\Http\Requests\Sistema\ContatoRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContatoEnviado extends Notification
{
    use Queueable;

    private $request;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ContatoRequest $request)
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
        ->subject('Guitarpedia Admin - Contato via site')
        ->greeting('Olá ' . $notifiable->nome . '!')
        ->line('Alguém entrou em contato com você através do formulário de "Fale Conosco" do site. Abaixo seguem os dados:')
        ->line('**Nome:** ' . $this->request->nome)
        ->line('**E-mail:** ' . $this->request->email)
        ->line('**Telefone:** ' . $this->request->telefone)
        ->line('**Assunto:** ' . $this->request->assunto)
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
